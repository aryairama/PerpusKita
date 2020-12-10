<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->user_id) {
            $user = User::findOrFail(\decrypt($request->user_id));
            if ($request->email == $user->email) {
                if($request->password){
                    return [
                        'name' => 'required|min:5|max:255',
                        'email' => 'required|email|max:255',
                        'password' => 'required|min:8|max:255',
                        'roles' => 'required',
                        'address' => 'required|min:20|max:255',
                        'phone' => 'required|digits_between:12,14',
                        'gender' => 'required'
                    ];
                } else {
                    return [
                        'name' => 'required|min:5|max:255',
                        'email' => 'required|email|max:255',
                        'password' => 'min:0|max:255',
                        'roles' => 'required',
                        'address' => 'required|min:20|max:255',
                        'phone' => 'required|digits_between:12,14',
                        'gender' => 'required'
                    ];
                }
            } else {
                if($request->password){
                    return [
                        'name' => 'required|min:5|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'password' => 'required|min:8|max:255',
                        'roles' => 'required',
                        'address' => 'required|min:20|max:255',
                        'phone' => 'required|digits_between:12,14',
                        'gender' => 'required'
                    ];
                } else {
                    return [
                        'name' => 'required|min:5|max:255',
                        'email' => 'required|email|max:255|unique:users,email',
                        'password' => 'min:0|max:255',
                        'roles' => 'required',
                        'address' => 'required|min:20|max:255',
                        'phone' => 'required|digits_between:12,14',
                        'gender' => 'required'
                    ];
                }
            }
        } else {
            return [
                'name' => 'required|min:5|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|max:255',
                'roles' => 'required',
                'address' => 'required|min:20|max:255',
                'phone' => 'required|digits_between:12,14',
                'gender' => 'required'
            ];
        }

    }
}
