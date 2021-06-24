<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Constant;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register user.
     *
     * @param RegisterFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterFormRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => Constant::STATUS_ACTIVE,
            'role' => UserRole::MEMBER,
        ];
        $user = $this->userRepository->create($data);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user],
            Response::HTTP_OK);
    }
}
