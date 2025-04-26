<?php

namespace App\DocumentManagement\Application\UseCases;

use App\DocumentManagement\Application\DTO\SendShipments472Request;
use App\DocumentManagement\Application\Interfaces\IApiHTTPClient;
use App\DocumentManagement\Domain\Repository\CodDaneRepository;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use Symfony\Component\Console\Output\OutputInterface;

readonly class SendShipmentsUseCase implements ISendShipmentsUseCase
{
    public function __construct(private string $app_472_url, private IApiHTTPClient $apiHTTPClient, private FiledRepository $repository, private CodDaneRepository $codDaneRepository)
    {
    }

    public function sendShipments(string $time_start, string $time_end, string $difference_days, ?OutputInterface $output = null): string
    {
        $filed = $this->repository->getDocuments($time_start, $time_end, $difference_days);
        $request = [];
        foreach ($filed as $item) {
            $documents = $item['documents'];
            if (count($documents) == 0) continue;

            $codeDane = $this->codDaneRepository->getCodDane($item['cod_dane']);
            if ($codeDane == null && $output != null) {
                $output->writeln('Guia : ' . $item['codigo_guia'] . ' No tiene Cod Dane asignado. No se enviará');
                continue;
            }

            $shipment = new SendShipments472Request(
                $item['codigo_guia'], $this->clearText($item['nombre_completo']), $this->clearText($item['direccion']),
                $codeDane->getName(), $codeDane->getDepto(), $item['num_radicado'], strtolower($item['prioridad']) == 'si' ? 'Urgente' : 'Normal'
            );

            $request[] = $shipment;
        }

        if (count($request) == 0) return '';

        $output?->writeln('Cantidad de guias enviadas: ' . count($request));

        return $this->apiHTTPClient->post($this->app_472_url, $request);
    }

    private function clearText(string $text): string {
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
    }
}