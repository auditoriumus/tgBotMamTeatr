<?php

namespace App\Http\Services\DocumentServices;

use App\Http\Repositories\DocumentRepository\DocumentRepository;
use App\Http\Services\Service;

class BaseDocumentService extends Service
{

    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }
}
