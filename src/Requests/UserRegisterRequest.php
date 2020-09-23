<?php
/**
 * UserRegisterRequest
 *
 * PHP version 7
 *
 * @category Request
 * @package  Request
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace Azibom\whoAreYou\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * UserRegisterRequest Class
 *
 * @category Request
 * @package  Request
 * @author   Azibom <mrsh13610@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class UserRegisterRequest extends FormRequest
{
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * rules function
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
          ];
    }

    /**
     * failedValidation function
     *
     * @param Validator s$validator That is a validator
     * @return void
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            response()->json(
                $validator->errors(),
                self::UNPROCESSABLE_ENTITY
            )
        );
    }
}
