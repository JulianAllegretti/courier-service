<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

class DocumentValueObject
{
    private DocumentIdValueObject $documentId;
    private EndPointFileNetValueObject $endPointFileNet;
    private OrderImpValueObject $orderImp;
    private NumPagesValueObject $numPages;

    /**
     * @param DocumentIdValueObject $documentId
     * @param EndPointFileNetValueObject $endPointFileNet
     * @param OrderImpValueObject $orderImp
     * @param NumPagesValueObject $numPages
     */
    public function __construct(DocumentIdValueObject $documentId, EndPointFileNetValueObject $endPointFileNet, OrderImpValueObject $orderImp, NumPagesValueObject $numPages)
    {
        $this->documentId = $documentId;
        $this->endPointFileNet = $endPointFileNet;
        $this->orderImp = $orderImp;
        $this->numPages = $numPages;
    }

    public function getDocumentId(): DocumentIdValueObject
    {
        return $this->documentId;
    }

    public function getEndPointFileNet(): EndPointFileNetValueObject
    {
        return $this->endPointFileNet;
    }

    public function getOrderImp(): OrderImpValueObject
    {
        return $this->orderImp;
    }

    public function getNumPages(): NumPagesValueObject
    {
        return $this->numPages;
    }



}