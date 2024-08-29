<?php

namespace App\Http\Controllers\Api\PressRelease;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\Models\User;
use App\UseCases\User\FindByIdAction as UserFindByIdAction;
use App\UseCases\PressRelease\FindByIdsAction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        /* @var User $user */
        $user = UserFindByIdAction::run(Auth::id());
        if ($user === null) // @todo まともにExceptionする
            throw new Exception("test");

        $company_id = $request->get("company_id");
        $release_id = $request->get("release_id");

        $press_release = FindByIdsAction::run(company_id: $company_id, release_id: $release_id);

        if (!$press_release)
            throw new HttpJsonResponseException(
                400,
                "notfound",
                "PressRelease Not Found",
                compact("company_id", "release_id")
            );

        /* @var Keyword $keyword */
        foreach ($press_release->keywords() as $keyword) {


            $user->view_histories()->create([

            ]);




        }
        $press_release->keywords();


        $press_release->keywords();
    }
}
