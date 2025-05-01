<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function reg(Request $request) {

        $rules = [
            'name' => 'required|string|alfa|min:8|max:32',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'status' => 'present|in:student,teacher,worker',
            'destiny' => 'present|array',
            'destiny.*' => 'present|in:learning,qualification,development',
            'password' => 'required|min:16|max:64|letters|numbers'
        ];

        $messages = [
            'name.required' => 'name is required',
            'name.alfa' => 'name can only contain letters',
            'name.min' => 'name in too short',
            'name.max' => 'name is too long',
            'email.required' => 'email is required',
            'email.email' => 'email is incorrect',
            'email.unique' => 'email is already taken',
            'password.required' => 'password is required',
            'password.min' => 'password is too short',
            'password.max' => 'password is too long',
            'password.letters' => 'password must contain letters',
            'password.numbers' => 'password must comtain numbers'
        ];

        $validator = Validator::make($request, $rules, $messages);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
        else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'destiny' => $request->destiny,
                'password' => $request->password
            ]);
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }
    }
}
