<?php
/**
 * UserRepository
 *
 * PHP version 7
 *
 * @category Repository
 * @package  Repository
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace Azibom\whoAreYou\Repositories\User;

use App\User;
use Azibom\whoAreYou\Contracts\User\UserRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client as Oclient;
use GuzzleHttp\Exception\ClientException;

/**
 * UserRepository Class
 *
 * @category Repository
 * @package  Repository
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class UserRepository implements UserRepositoryInterface
{
    const SUCCUSUS_STATUS_CODE     = 200;
    const UNAUTHORISED_STATUS_CODE = 401;

    /**
     * __construct function
     *
     * @param Client $client client var
     */
    public function __construct(Client $client) {
        $this->http    = $client;
        $this->baseUrl = env('WHO_ARE_YOU_BASE_URL');
    }

    /**
     * register function
     *
     * @param  Request $request request var
     * @return mix
     */
    public function register(Request $request) {
        $email             = $request->email;
        $password          = $request->password;
        $input             = $request->all();
        $input['password'] = bcrypt($input['password']);
        User::create($input);
        $response = $this->getTokenAndRefreshToken($email, $password);
        $response = $this->response($response["data"], $response["statusCode"]);
        return $response;
    }

    /**
     * login function
     *
     * @param Request $request request var
     * @return mix
     */
    public function login(Request $request) {
        $email    = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $response   = $this->getTokenAndRefreshToken($email, $password);
            $data       = $response["data"];
            $statusCode = $response["statusCode"];
        } else {
            $data       = ['error' => 'Unauthorised'];
            $statusCode = self::UNAUTHORISED_STATUS_CODE;
        }

        $response = $this->response($data, $statusCode);
        return $response;
    }

    /**
     * refreshToken function
     *
     * @param Request $request request var
     * @return mix
     */
    public function refreshToken(Request $request) {
        if (is_null($request->header('Refreshtoken'))) {
            $response = $this->response(
                ['error' => 'Unauthorised'], self::UNAUTHORISED_STATUS_CODE
            );

            return $response;
        }

        $refreshToken = $request->header('Refreshtoken');
        $oClient      = $this->getOclient();
        $formParams   = [ 'grant_type' => 'refresh_token',
                          'refresh_token' => $refreshToken,
                          'client_id' => $oClient->id,
                          'client_secret' => $oClient->secret,
                          'scope' => '*'];

        $response = $this->sendRequest("/oauth/token", $formParams);
        return $response;
    }

    /**
     * details function
     *
     * @return mix
     */
    public function details() {
        $user     = Auth::user();
        $response = $this->response($user, self::SUCCUSUS_STATUS_CODE);
        return $response;
    }

    /**
     * logout function
     *
     * @param Request $request request var
     * @return mix
     */
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        $response = $this->response(
            ['message' => 'Successfully logged out'], self::SUCCUSUS_STATUS_CODE
        );

        return $response;
    }

    /**
     * response function
     *
     * @param [type]  $data       data var
     * @param integer $statusCode statusCode var
     * @return array
     */
    public function response($data, int $statusCode) {
        $response = ["data" => $data, "statusCode" => $statusCode];
        return $response;
    }

    /**
     * getTokenAndRefreshToken function
     *
     * @param string $email    email var
     * @param string $password password var
     * @return mix
     */
    public function getTokenAndRefreshToken(string $email, string $password) {
        $oClient    = $this->getOclient();
        $formParams = [ 'grant_type' => 'password',
                        'client_id' => $oClient->id,
                        'client_secret' => $oClient->secret,
                        'username' => $email,
                        'password' => $password,
                        'scope' => '*'];

        $request = $this->sendRequest("/oauth/token", $formParams);
        return $request;
    }

    /**
     * sendRequest function
     *
     * @param string $route      route var
     * @param array  $formParams formParams var
     * @return array
     */
    public function sendRequest(string $route, array $formParams) {
        try {
            $url      = $this->baseUrl.$route;
            $response = $this->http->request(
                'POST', $url, ['form_params' => $formParams]
            );

            $statusCode = self::SUCCUSUS_STATUS_CODE;
            $data       = json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            $statusCode = $e->getCode();
            $data       = ['error' => 'OAuth client error'];
        }

        return ["data" => $data, "statusCode" => $statusCode];
    }

    /**
     * getOclient function
     *
     * @return Oclient $client
     */
    public function getOclient() {
        $client = Oclient::where('password_client', 1)->first();
        return $client;
    }
}
