<?php

namespace App\Http\Repositories\DocumentRepository;

use App\Http\Repositories\Repository;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepository extends Repository
{
    public function __construct(Document $model)
    {
        parent::__construct($model);
    }

    public function addDocument($data)
    {
        return DB::table('documents')->insert($data);
    }
}
