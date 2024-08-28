<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SignUp\SendTokenRequest;
use App\Http\Requests\Api\Auth\SignUp\VerifyRequest;
use App\UseCases\CreateAction;
use App\UseCases\FindByEmailAction;
use App\Utils\OneTimeToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;

class SignUpController extends Controller
{

    /**
     * @param SendTokenRequest $request
     * @return JsonResponse
     * @throws RandomException
     */
    public function sendToken(SendTokenRequest $request): JsonResponse
    {
        $token = OneTimeToken::generate();

        /** @var array{ name: string, email: string, job: string, age: string, prefecture: string } $data */
        $data = $request->validated();

        // 入力メールアドレスで登録されているユーザーを検索
        $user = FindByEmailAction::run($data["email"]);

        if ($user) {

            // @todo 登録済みの旨のメールを送信
        } else {

            $request->session()->put("signup_data", [
                "data"     => $data,
                "token"    => Hash::make($token),
                "expireAt" => time() + 60 * 30 // 10分間
            ]);

            // @todo ワンタイムパスワードを送信
        }

        return $this->responseJson(["result" => "ok"]);
    }

    /**
     * @param VerifyRequest $request
     * @return true
     * @throws HttpJsonResponseException
     */
    public function register(VerifyRequest $request): true
    {
        $input_token = $request->validated()["token"];

        if (!$request->session()->has("signup_data"))
            throw new HttpJsonResponseException(
                400,
                "validation",
                "Validation failed",
                [
                    "code" => ["有効期限切れです。"]
                ]
            );

        /** @var array{ data: array, token: string, expireAt: int } $signup_data */
        $signup_data = $request->session()->get("signup_data");

        // Session Data
        /** @var array{ name: string, email: string, job: string, age: string, prefecture: string } $data */
        $data = $signup_data["data"];
        /** @var string $token */
        $token = $signup_data["token"];
        /** @var int $token */
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
                    "code" => ["ワンタイムパスワードが間違っています。。"]
                ]
            );

        $user = CreateAction::run(
            name: $data["name"],
            email: $data["email"],
            job: $data["job"],
            age: $data["age"],
            prefecture: $data["prefecture"]
        );

        Auth::loginUsingId($user->id);

        $request->session()->forget("signup_data");
        $request->session()->regenerate();

        return true;
    }
}
