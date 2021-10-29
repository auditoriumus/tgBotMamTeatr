<?php

namespace App\Http\Services\PictureServices;

use App\Http\Repositories\PictureRepository\PictureRepository;
use App\Http\Services\Service;
use App\Models\Picture;

class BasePictureService
{

    protected $pictureRepository;

    public function __construct(PictureRepository $pictureRepository)
    {
        $this->pictureRepository = $pictureRepository;
    }
}
