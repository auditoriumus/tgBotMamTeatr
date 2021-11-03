<?php

namespace App\Http\Services\DocumentServices;

class AddNewDocumentService extends BaseDocumentService
{
    public function addSeveralDocuments($data)
    {
        return $this->documentRepository->addDocument($data);
    }
}
