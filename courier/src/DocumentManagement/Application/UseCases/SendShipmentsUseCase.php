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

            if (!in_array($item['codigo_guia'], ['MT901096329CO','MT901094793CO','MT901093000CO','MT901091622CO','MT901095477CO','MT901092412CO','MT901094097CO','MT901092946CO','MT901093876CO','MT901091644CO','MT901094380CO','MT901092699CO','MT901092948CO','MT901094781CO','MT901095034CO','MT901095072CO','MT901091151CO','MT901091321CO','MT901095218CO','MT901094499CO','MT901096288CO','MT901096291CO','MT901096255CO','MT901094111CO','MT901094085CO','MT901095140CO','MT901093191CO','MT901095740CO'])) continue;

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
        $textWithoutAccents = str_replace(
            array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ"),
            array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N"),
            $text
        );
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $textWithoutAccents);
    }
}