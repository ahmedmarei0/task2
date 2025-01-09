<?php

namespace App\Repository;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserRepository
{
    use ResponseTrait;

    public function register($request){
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password), 
            "roles_and_permissions"=>json_encode(
                (object)[
                    "admin"=>(object)['read' => true , 'create' => true , 'update' => false , 'delete' => false],
                ]
            )         
        ]);           
        return $user;
    }

    public function login($credentials){
        if (! $token = auth()->attempt($credentials)) {
            return $this->responseMessage(true, 401, 'Unauthorized');
        }
        return $token;
    }

    public function logout($request){          
        return auth()->logout();
    }

    public function userData(){
        return auth()->user();
    }
}
