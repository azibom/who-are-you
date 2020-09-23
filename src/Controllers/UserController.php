<?php
/**
 * UserController
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Controller
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace Azibom\whoAreYou\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Azibom\whoAreYou\Contracts\User\UserRepositoryInterface;
use Azibom\whoAreYou\Requests\UserLoginRequest;
use Azibom\whoAreYou\Requests\UserRegisterRequest;

/**
 * UserController Class
 *
 * @category Controller
 * @package  Controller
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class UserController extends Controller
{
    const SUCCUSUS_STATUS_CODE     = 200;
    const UNAUTHORISED_STATUS_CODE = 401;

    /**
     * __construct function
     *
     * @param UserRepositoryInterface $userRepository The UserRepository object
     */
    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * login function
     *
     * @param UserLoginRequest $request The UserLoginRequest object
     * @return void
     */
    public function login(UserLoginRequest $request) {
        $response = $this->userRepository->login($request);
        $result   = response()->json(
            $response["data"],
            $response["statusCode"]
        );
        return $result;
    }

    /**
     * register function
     *
     * @param UserRegisterRequest $request The UserRegisterRequest object
     * @return void
     */
    public function register(UserRegisterRequest $request) {
        $response = $this->userRepository->register($request);
        $result   = response()->json(
            $response["data"],
            $response["statusCode"]
        );
        return $result;
    }

    /**
     * details function
     *
     * @return void
     */
    public function details() {
        $response = $this->userRepository->details();
        $result   = response()->json(
            $response["data"],
            $response["statusCode"]
        );
        return $result;
    }

    /**
     * logout function
     *
     * @param Request $request The Request object
     * @return void
     */
    public function logout(Request $request) {
        $response = $this->userRepository->logout($request);
        $result   = response()->json(
            $response["data"],
            $response["statusCode"]
        );
        return $result;
    }

    /**
     * refreshToken function
     *
     * @param Request $request The Request object
     * @return void
     */
    public function refreshToken(Request $request) {
        $response = $this->userRepository->refreshToken($request);
        $result   = response()->json(
            $response["data"],
            $response["statusCode"]
        );
        return $result;
    }
}
