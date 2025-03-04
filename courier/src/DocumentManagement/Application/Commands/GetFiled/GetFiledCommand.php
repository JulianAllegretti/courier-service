<?php

namespace App\DocumentManagement\Application\Commands\GetFiled;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Command;

class GetFiledCommand implements Command
{
    private ResponsePaginator $filed;
    private int $page;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }
    public function __construct(int $page){
        $this->page = $page;
    }

    public function getFiled(): ResponsePaginator
    {
        return $this->filed;
    }

    public function setFiled(ResponsePaginator $filed): void
    {
        $this->filed = $filed;
    }
}