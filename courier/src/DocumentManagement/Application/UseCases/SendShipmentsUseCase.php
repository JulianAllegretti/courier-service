<?php

namespace App\DocumentManagement\Application\UseCases;

use App\DocumentManagement\Application\DTO\SendShipments472Request;
use App\DocumentManagement\Application\Interfaces\IApiHTTPClient;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use Symfony\Component\Console\Output\OutputInterface;

readonly class SendShipmentsUseCase implements ISendShipmentsUseCase
{
    public function __construct(private string $app_472_url, private IApiHTTPClient $apiHTTPClient, private FiledRepository $repository)
    {
    }

    public function sendShipments(string $time_start, string $time_end, string $difference_days, ?OutputInterface $output = null): string
    {
        $filed = $this->repository->getDocuments($time_start, $time_end, $difference_days);
        $request = [];
        foreach ($filed as $item) {
            $documents = $item['documents'];
            if (count($documents) == 0) continue;

            $shipment = new SendShipments472Request(
                $item['codigo_guia'], $item['nombre_completo'], $item['direccion'],
                '', '', strtolower($item['prioridad']) == 'si' ? 'Urgente' : 'Normal'
            );

            $request[] = $shipment;
        }

        if (count($request) == 0) return '';

        $output?->writeln('Cantidad de guias enviadas: ' . count($request));

        return $this->apiHTTPClient->post($this->app_472_url, $request);
    }
}