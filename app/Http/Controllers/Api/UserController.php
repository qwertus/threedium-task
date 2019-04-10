<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    protected $photosUploadPath = 
        'customer-profile-images' 
    ;
    
    public function login (Request $request) {
        
        $data = $this->validate($request,[
           'email' => 'required', 
           'password' => 'required', 
        ]);
        
        $user = User::where('email',$data['email'])->first();
        
        if ($user && \Hash::check($data['password'], $user->password))
        {
            return new UserResource($user);
        }else {
            return response()->json(['message'=>'Wrong email or password!'],400);
        }
        
    }
    
    public function regenerateToken (Request $request) {
        
        $data = $this->validate($request,[
           'email' => 'required', 
           'password' => 'required', 
        ]);
        
        $user = User::where('email',$data['email'])->first();
        
        if ($user && \Hash::check($data['password'], $user->password))
        {
            
            $user->api_token = $user->generateApiToken();
            $user->save();
            
            return response()->json(['api_token'=> $user->api_token ]);
        }else {
            return response()->json(['message'=>'Wrong email or password!'],400);
        }
        
    }
    
}
