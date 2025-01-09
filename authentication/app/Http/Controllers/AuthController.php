<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function __construct(protected UserService $userService)
    {
       
    }
    public function register(UserRegisterRequest $request){
        return $this->userService->register( $request);
    }
    public function login(UserLoginRequest $request)
    {
        return $this->userService->login($request);
    }

    
    public function userData()
    {
        return $this->userService->userData();
    }

    public function logout()
    {
        return $this->userService->logout(request());
    }


}
