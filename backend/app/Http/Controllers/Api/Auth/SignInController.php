<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignIn\SendTokenRequest;
use App\Http\Requests\Api\Auth\SignIn\VerifyRequest;
use App\Mail\OneTimeToken as OneTimeTokenMail;
use App\Mail\UserNotExists as UserNotExistsMail;
use App\UseCases\User\FindByEmailAction;
use App\Utils\OneTimeToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class SignInController extends Controller
{

    /**
     * @param SendTokenRequest $request
     * @return JsonResponse
     * @throws RandomException
     */
    public function sendToken(SendTokenRequest $request): JsonResponse
    {
        $token = OneTimeToken::generate();

        /** @var array{ email: string } $data */
        $data = $request->validated();
        $request->session()->put("signin_data", [
            "data"     => $data,
            "token"    => Hash::make($token),
            "expireAt" => time() + 60 * 30 // 10分間
        ]);

        // 入力メールアドレスで登録されているユーザーを検索
        $user = FindByEmailAction::run($data["email"]);

        if ($user) {
            // ユーザーが存在する場合、ワンタイムパスワードを生成し、メールを送信。

            $request->session()->put("signin_data", [
                "data"     => $data,
                "token"    => Hash::make($token),
                "expireAt" => time() + 60 * 30 // 10分間
            ]);

            // @todo Queue経由にする
            Mail::to($data["email"])->send(new OneTimeTokenMail($token));
        } else {
            // ユーザーが存在しない場合、ユーザーが存在しない旨のメールを送信。

            // @todo Queue経由にする
            Mail::to($data["email"])->send(new UserNotExistsMail);
        }

        return $this->responseJson(["result" => "ok"]);
    }

    /**
     * @param VerifyRequest $request
     * @return true
     * @throws HttpJsonResponseException
     */
    public function verify(VerifyRequest $request): true
    {
        $input_token = $request->validated()["token"];

        if (!$request->session()->has("signin_data"))
            throw new HttpJsonResponseException(
                400,
                "validation",
                "Validation failed",
                [
                    "code" => ["有効期限切れです。"]
                ]
            );

        /** @var array{ data: array, token: string, expireAt: int } $signup_data */
        $signup_data = $request->session()->get("signin_data");

        // Session Data
        /** @var array{ email: string } $data */
        $data = $signup_data["data"];
        $token = $signup_data["token"];
        $expireAt = $signup_data["expireAt"];

        if (time() > $expireAt)
            throw new HttpJsonResponseException(
                400,
                "validation",
                "Validation failed",
                [
                    "code" => ["有効期限切れです。"]
                ]
            );

        if (!Hash::check($input_token, $token))
            throw new HttpJsonResponseException(
                400,
                "validation",
                "Validation failed",
                [
                    "code" => ["ワンタイムパスワードが間違っています。"]
                ]
            );

        $user = FindByEmailAction::run($data["email"]);

        if (!$user)
            throw new HttpJsonResponseException(
                500,
                "application",
                "Application Error",
                [
                    "code" => ["想定外のエラーが発生しました。"]
                ]
            );

        Auth::loginUsingId($user->id);

        $request->session()->forget("signin_data");
        $request->session()->regenerate();

        return true;
    }
}
