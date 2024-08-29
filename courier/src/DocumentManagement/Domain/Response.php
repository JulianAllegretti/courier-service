<?php

namespace App\DocumentManagement\Domain;

class Response
{
    /**
     * @var string
     */
    public $CodGuia;
    /**
     * @var string
     */
    public $ErrorCode;
    /**
     * @var string
     */
    public $ErrorMessage;
    /**
     * @var string
     */
    public $NumRadicado;

    /**
     * @var integer
     */
    public $NumPaginas;

    /**
     * @var integer
     */
    public $NumDocumentos;

    /**
     * @var integer
     */
    public $CountResult;

    public function __construct($CodGuia = null, $ErrorCode = null, $ErrorMessage = null, $NumRadicado = null)
    {
        $this->CodGuia = $CodGuia;
        $this->ErrorCode = $ErrorCode;
        $this->ErrorMessage = $ErrorMessage;
        $this->NumRadicado = $NumRadicado;
        $this->NumPaginas = 0;
        $this->NumDocumentos = 0;
        $this->CountResult = 0;
    }

    public function getCodGuia(): ?string
    {
        return $this->CodGuia;
    }

    public function getErrorCode(): ?string
    {
        return $this->ErrorCode;
    }

    public function getErrorMessage(): ?string
    {
        return $this->ErrorMessage;
    }

    public function getNumRadicado(): ?string
    {
        return $this->NumRadicado;
    }

    public function setCodGuia(?string $CodGuia): void
    {
        $this->CodGuia = $CodGuia;
    }

    public function setErrorCode(?string $ErrorCode): void
    {
        $this->ErrorCode = $ErrorCode;
    }

    public function setErrorMessage(?string $ErrorMessage): void
    {
        $this->ErrorMessage = $ErrorMessage;
    }

    public function setNumRadicado(?string $NumRadicado): void
    {
        $this->NumRadicado = $NumRadicado;
    }

    public function setNumPaginas(int $NumPaginas): void
    {
        $this->NumPaginas = $NumPaginas;
    }

    public function setNumDocumentos(int $NumDocumentos): void
    {
        $this->NumDocumentos = $NumDocumentos;
    }

    public function setCountResult(int $CountResult): void
    {
        $this->CountResult = $CountResult;
    }

    public function getNumPaginas(): int
    {
        return $this->NumPaginas;
    }

    public function getNumDocumentos(): int
    {
        return $this->NumDocumentos;
    }

    public function getCountResult(): int
    {
        return $this->CountResult;
    }


}