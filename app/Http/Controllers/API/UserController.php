<?php

namespace App\Http\Controllers\API;

use App\Exceptions\BaseException;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $authUser = Auth::user();

            $userAttrs = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'api_token' => Helper::generateTokenApi(),
                'roles' => [
                    config('permission.content_creator')
                ],
                'product_id' => $authUser?->product_id
            ];
            $user = $this->repository->create($userAttrs);

            DB::commit();
            return $this->responseSuccess([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'api_token' => $user->api_token
                ]
            ]);
        }catch (\Exception $exception) {
            DB::rollBack();

            Log::info("message err :".$exception->getMessage() ." request :" .json_encode($request->all()));
            throw new BaseException("Create user failed ." . $exception->getMessage(),500);
        }
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(GetTokenUserRequest $request)
    {
        try {

            $user = User::query()->where('email',$request->get('email'))->first();
            if (!$user) throw new BaseException("User not Found !",500);
            $hasher = app('hash');
            if ($hasher->check($request->get('password') , $user->password)) {
                return $this->responseSuccess([
                    'user' => [
                        'api_token' => $user->api_token
                    ]
                ]);
            }
            throw new BaseException("Password not match our records !",500);

        }catch (\Exception $exception) {
            Log::info("message err :".$exception->getMessage() ." request :" .json_encode($request->all()));
            throw new BaseException("Create user failed ." . $exception->getMessage(),500);
        }
    }




}
