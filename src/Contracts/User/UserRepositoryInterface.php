<?php
/**
 * UserRepositoryInterface
 *
 * PHP version 7
 *
 * @category Interface
 * @package  Interface
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */


namespace Azibom\whoAreYou\Contracts\User;

use Illuminate\Http\Request;

/**
 * UserRepositoryInterface interface
 *
 * @category Interface
 * @package  Interface
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
interface UserRepositoryInterface
{
    /**
     * register function
     *
     * @param  Request $request request var
     * @return mixed
     */
    public function register(Request $request);

    /**
     * login function
     *
     * @param Request $request request var
     * @return mixed
     */
    public function login(Request $request);

    /**
     * refreshToken function
     *
     * @param Request $request request var
     * @return mixed
     */
    public function refreshToken(Request $request);

    /**
     * details function
     *
     * @return mixed
     */
    public function details();

    /**
     * logout function
     *
     * @param Request $request request var
     * @return mixed
     */
    public function logout(Request $request);

    /**
     * response function
     *
     * @param [type]  $data       data var
     * @param integer $statusCode statusCode var
     * @return array
     */
    public function response($data, int $statusCode);

    /**
     * getTokenAndRefreshToken function
     *
     * @param string $email    email var
     * @param string $password password var
     * @return mixed
     */
    public function getTokenAndRefreshToken(string $email, string $password);

    /**
     * sendRequest function
     *
     * @param string $route      route var
     * @param array  $formParams formParams var
     * @return array
     */
    public function sendRequest(string $route, array $formParams);

    /**
     * getOclient function
     *
     * @return Oclient $client
     */
    public function getOclient();
}
