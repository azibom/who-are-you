<?php

namespace Azibom\whoAreYou\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Azibom\whoAreYou\Contracts\User\UserRepositoryInterface;
use Azibom\whoAreYou\Requests\UserLoginRequest;
use Azibom\whoAreYou\Requests\UserRegisterRequest;

class UserController extends Controller {
    const SUCCUSUS_STATUS_CODE = 200;
    const UNAUTHORISED_STATUS_CODE = 401;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(UserLoginRequest $request) {
        $response = $this->userRepository->login($request);
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function register(UserRegisterRequest $request) {
        $response = $this->userRepository->register($request);
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function details() {
        $response = $this->userRepository->details();
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function logout(Request $request) {
        $response = $this->userRepository->logout($request);
        return response()->json($response["data"], $response["statusCode"]);
    }

    public function refreshToken(Request $request) {
        $response = $this->userRepository->refreshToken($request);
        return response()->json($response["data"], $response["statusCode"]);
    }
}
