<?php

namespace App\Service;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Repository\UserRepository;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserService
{
   use ResponseTrait;
    public function __construct(protected UserRepository $userRepository)
    {
        
    }

    public function register(UserRegisterRequest $request){
        $user =  $this->userRepository->register($request);
        
        $token = '';
        if (! $token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->responseMessage(false, 401, 'Unauthorized');
        }
        $user->token = $token;
        return $this->responseMessage(true, 200, 'تم التسجيل بنجاح', $user);

    }

    public function login(UserLoginRequest $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        return $this->responseMessage(true, 200, 'تم تسجيل الدخول بنجاح', $this->userRepository->login($credentials));
    }

    public function logout(Request $request){
        $this->userRepository->logout($request);
        return $this->responseMessage(true, 200, 'تم تسجيل الخروج بنجاح');
    }

    public function userData(){
        $user = $this->userRepository->userData(); 
        return $this->responseMessage(true, 200, 'بيانات المستخدم', $user);
    }

}
