<?php

namespace App\DocumentManagement\Application\Commands\GetFiledById;

use App\DocumentManagement\Domain\Entity\Filed;
use App\Shared\Domain\Command;
use Doctrine\Common\Collections\Collection;

class GetFiledByIdCommand implements Command
{
    /**
     * @var int
     */
    private int $id_filed;
    /**
     * @var Filed|null
     */
    private Filed|null $filed;

    /**
     * @var Collection|null
     */
    private array|null $logsInsert;

    /**
     * @var array|null
     */
    private array|null $logsGetDocuments;

    /**
     * @param int $id_filed
     */
    public function __construct(int $id_filed)
    {
        $this->id_filed = $id_filed;
    }

    /**
     * @return int
     */
    public function getIdFiled(): int
    {
        return $this->id_filed;
    }

    /**
     * @param int $id_filed
     * @return void
     */
    public function setIdFiled(int $id_filed): void
    {
        $this->id_filed = $id_filed;
    }

    /**
     * @return Filed|null
     */
    public function getFiled(): Filed|null
    {
        return $this->filed;
    }

    /**
     * @param Filed|null $filed
     * @return void
     */
    public function setFiled(Filed|null $filed): void
    {
        $this->filed = $filed;
    }

    public function getLogsInsert(): ?array
    {
        return $this->logsInsert;
    }

    public function setLogsInsert(?array $logsInsert): void
    {
        $this->logsInsert = $logsInsert;
    }

    public function getLogsGetDocuments(): ?array
    {
        return $this->logsGetDocuments;
    }

    public function setLogsGetDocuments(?array $logsGetDocuments): void
    {
        $this->logsGetDocuments = $logsGetDocuments;
    }
}