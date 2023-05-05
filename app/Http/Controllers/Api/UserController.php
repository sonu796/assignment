<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'usertype' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 403);
        }

            $user = new User;
            $user->name =  $request->name;
            $user->email =  $request->email;
            $user->password =  $request->password;
            $user->gender =  $request->gender;
            $user->age =  $request->age;
            $user->user_type =  $request->usertype;
            $user->save();
            $massage = 'Successfully User Register';
        
         return response()->json(['message'=>$massage,'statuscode'=>'200','success'=>'true'], 200);
    }
}
