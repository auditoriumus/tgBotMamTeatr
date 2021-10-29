<?php

namespace App\Http\Repositories\PictureRepository;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PictureRepository extends \App\Http\Repositories\Repository
{
    public function __construct(Picture $model)
    {
        parent::__construct($model);
    }

    public function addPictures($data)
    {
        return DB::table('pictures')->insert($data);
    }
}
