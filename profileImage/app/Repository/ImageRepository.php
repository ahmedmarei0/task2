<?php

namespace App\Repository;

use App\Models\UserImage;

class ImageRepository
{
    public function upload($imageName, $userId){
        $userImage = UserImage::create([
            'user_id' => $userId,
            'path' => $imageName
        ]);
        return $userImage;
    }

    public function getUserImage($userId){
            $userImages = UserImage::select(['path'])   
                                    ->where('user_id', $userId)
                                    ->pluck('path')->toArray();
            return $userImages;
    
    }
}
