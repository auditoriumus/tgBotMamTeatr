<?php

namespace App\Http\Services\PictureServices;

class AddNewPictureService extends BasePictureService
{
    public function addSeveralPictures($data)
    {
        return $this->pictureRepository->addPictures($data);
    }
}
