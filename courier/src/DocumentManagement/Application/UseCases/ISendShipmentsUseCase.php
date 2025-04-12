<?php

namespace App\DocumentManagement\Application\UseCases;

use Symfony\Component\Console\Output\OutputInterface;

interface ISendShipmentsUseCase
{
    public function sendShipments(string $time_start, string $time_end, string $difference_days, ?OutputInterface $output = null) : string;
}