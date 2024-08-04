<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Document;

interface DocumentRepository
{
    function create(Document $filed): Document;
}