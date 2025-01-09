<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Service\ImageService;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    public function __construct(protected ImageService $imageService){

    }
    public function upload(ImageRequest $request){
        return $this->imageService->upload($request);
    }
    public function getUserImage(){
        return $this->imageService->getUserImage();
    }
}
