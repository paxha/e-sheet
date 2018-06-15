<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            $objects = json_decode($validator->errors());
            $message = null;
            foreach ($objects as $object) {
                foreach ($object as $error) {
                    $message .= $error;
                }
            }
            $message = str_replace('.', ',', $message);
            $message = rtrim($message, ',');
            return array(
                'status' => 401,
                'message' => $message
            );
        }

        if (!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            return array(
                'status' => 401,
                'message' => 'Incorrect Email or Password',
            );
        }

        $user = Auth::user();

        $data = array();
        $data['Bearer'] = $user->createToken('MyApp')->accessToken;
        $data['user'] = $user;

        return array(
            'status' => 101,
            'message' => 'Login Successful!',
            'data' => $data,
        );
    }

    public function register(Request $request)
    {
        return 'login function working';
    }
}
