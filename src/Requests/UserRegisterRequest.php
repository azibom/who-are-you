<?php
/**
 * Test
 *
 * PHP version 7
 *
 * @category Template_Class
 * @package  Template_Class
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace Azibom\whoAreYou\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Template Class Doc Comment
 *
 * Template Class
 *
 * @category Template_Class
 * @package  Template_Class
 * @author   Author <author@domain.com>
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
     * @param Validator $validator that is validator
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
