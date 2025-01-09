<?php

namespace App\Service;

use App\Http\Requests\ImageRequest;
use App\Repository\ImageRepository;
use App\trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    use ResponseTrait;

    /**
     * Create a new class instance.
     */
    public function __construct(protected ImageRepository $imageRepository)
    {
        //
    }
    public function upload(ImageRequest $request)
    {
        try {
        $rolesAndPermissions = request()->roles_and_permissions;
            if ($rolesAndPermissions->admin && $rolesAndPermissions->admin->create) {
            $user_id = request()->user_id;

            $imageName = $request->file('image')->store('images');
            // insert into database
            $this->imageRepository->upload($imageName, $user_id);
            $url = Storage::temporaryUrl(
                $imageName,
                now()->addMinutes(60)
            );
            return $this->responseMessage(true, 200, 'Image uploaded successfully', $url);
        } else {
            return $this->responseMessage(false,  403, "You don't have permission to upload image");
        }
        } catch (\Throwable $th) {
            return $this->responseMessage(false, 500, $th->getMessage());
        }
    }
    public function getUserImage()
    {
        $rolesAndPermissions = request()->roles_and_permissions;
        if ($rolesAndPermissions) {
            if ($rolesAndPermissions->admin && $rolesAndPermissions->admin->read) {
                $userImages = $this->imageRepository->getUserImage(request()->user_id);
                return $this->responseMessage(true, 200, 'user image', $userImages);
            } else {             
                return $this->responseMessage(false, 403, 'You do not have permission to view this resource');
            }
        }
    }
}
