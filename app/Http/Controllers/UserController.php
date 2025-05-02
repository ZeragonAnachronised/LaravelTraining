<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function reg(Request $request) {

        $rules = [
            'name' => 'required|string|alpha|min:4|max:32',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'status' => 'present|in:student,teacher,worker',
            'destiny' => 'present|array',
            'destiny.*' => 'present|in:learning,qualification,development',
            'password' => ['required', Password::min(16)->max(64)->letters()->numbers()]
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

        $validator = Validator::make($request->all(), $rules, $messages);

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
                'password' => Hash::make($request->password),
                'user_tag' => Str::uuid()
            ]);
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }
    }
    public function auth(Request $request) {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'email.required' => 'email is required',
            'password.required' => 'password is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
        else if(Auth::attempt($request->all())) {
            $token = $request->user()->createToken('bearer_token');

            return response()->json([
                'success' => true,
                'token' => $token->plainTextToken,
                'user' => Auth::user()
            ], 200);
        }
    }
    public function sessionDown() {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'logged out'
        ], 200);
    }
    public function allDown() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'all logged out'
        ], 200);
    }
}
