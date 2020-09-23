<?php
/**
 * api
 *
 * PHP version 7
 *
 * @category Route
 * @package  Route
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(
    function () {
        Route::group(
            ['namespace' => 'Azibom\whoAreYou\Controllers'],
            function () {
                    Route::post('login', 'UserController@login');
                    Route::post('register', 'UserController@register');
                    Route::post('refreshtoken', 'UserController@refreshToken');
                    Route::group(
                        ['middleware' => ['auth:api']], function () {
                            Route::post('logout', 'UserController@logout');
                            Route::post('details', 'UserController@details');
                        }
                    );
            }
        );
    }
);
