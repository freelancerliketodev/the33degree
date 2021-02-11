<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data['email'] =  $request->input("email");
        $data['password'] =  $request->input("password");
        $data['password_confirmation'] =  $request->input("password_confirmation");
        
        $loginData = Validator::make($data, [
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        
        if ($loginData->fails()) {
            return response(['message' => 'Invalid data'],400);
        }

        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
    
        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken],200);
    }

    public function login(Request $request)
    {
        $data['email'] =  $request->input("email");
        $data['password'] =  $request->input("password");
        
        $loginData = Validator::make($data, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($loginData->fails() || !auth()->attempt($data)) {
            return response(['message' => 'Invalid Credentials'],400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken],200);

    }

    public function changePassword(request $request)
    {   
        $data['old_password'] = $request->input('old_password');
        $data['new_password'] = $request->input('new_password');
        $data['password_confirmation'] = $request->input('password_confirmation');

        $loginData = Validator::make($data, [
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirmation' => 'required|confirmed',
        ]);

        // Return Error if validation fails
        if ($validation->fails()) {
            return response(['message' => 'Invalid data'],400);
        }

        if (!Hash::check($data['old_password'], auth()->user()->password)) {
            return response(['message' => 'Invalid Credentials'],400);
        }

        $user = User::findOrFail(Auth::user()->id);

        if($user){
            $user->fill([
                'password' => bcrypt($data['new_password'])
            ])->save();

            return response(['message' => 'success'], 200);
        }else{
            return response(['message' => "Can't save new password"], 400);
        }
    }

    public function get(request $request){
        $user = $request->user();
        $user->balance = $user->getBalance();

        return response(['user' => user()],200);
    }

    public function logout()
    { 
        if (auth()->check()) {
            auth()->user()->AauthAcessToken()->delete();  
            return response(['message' => 'success'], 200);
        }
        return response()->json(['message'=>'Unauthorised'], 401);
    }
}