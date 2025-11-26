<?php

namespace App\DocumentManagement\Application\Commands\GenerateFileByGuidesNumber;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-file-by-guides-number')]
class GenerateFileByGuidesNumberCommand extends Command
{
    public function __construct(private readonly FiledRepository $repository)
    {
        parent::__construct('app:generate-file-by-guides-number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $delimiter = '|&';
        $guides_number = $input->getArgument('guides_number');
        try {
            $output->writeln('-- Inicio job para generar el plano con las guias recibidas --');
            $filed = $this->repository->getDocumentsByGuidesNumber($guides_number);
            $headers = [
                'NumRadicado', 'CodGuia', 'RutaArchivo', 'TipoDocumento', 'Documento', 'Celular', 'NumTramite',
                'CodDane', 'Direccion', 'NombreCompleto', 'Telefono', 'Prioridad', 'Impreso', 'PortePago', 'TipoPortePago',
                'TipoProceso', 'RadicadoCasoPadre', 'UsuarioSolicitante', 'FechaDeCreacion'
            ];
            $content = implode($delimiter, $headers).PHP_EOL;
            foreach ($filed as $item) {
                $documents = $item['documents'];

                if (count($documents) == 0) {
                    continue;
                }

                foreach ($documents as $document) {
                    if (!isset($document['ruta']) || $document['ruta'] == '') {
                        continue;
                    }
                    $content .= $this->createTxtForFile($item, $delimiter, $document['id_gestor_documento'].'.pdf'.$delimiter);
                }
            }

            $date = new DateTime();
            $fp = fopen("public/planos/radicados-by-guides-number-".$date->format('Y-m-d').'.txt',"w");
            fwrite($fp,$content);
            fclose($fp);
            $output->writeln('-- Fin job para generar el plano con las guias recibidas --');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('-- Fin con error del job para generar el plano con las guias recibidas --');
            return Command::FAILURE;
        }
    }

    private function createTxtForFile(array $item, string $delimiter, string $routeDocument): string {
        $content = $item['num_radicado'].$delimiter;
        $content .= $item['codigo_guia'].$delimiter;
        $content .= "public/files/".$routeDocument;
        if (isset($item['identification']) && count($item['identification']) > 0) {
            $content .= $item['identification']['tipo_documento'].$delimiter;
            $content .= $item['identification']['documento'].$delimiter;
        } else {
            $content .= $delimiter;
            $content .= $delimiter;
        }

        unset(
            $item['id_radicado'], $item['fk_identificacion'], $item['num_radicado'], $item['identification'],
            $item['documents'], $item['codigo_guia'], $item['guia_impresa']
        );
        $content .= implode($delimiter, $item).PHP_EOL;

        return $content;
    }

    protected function configure()
    {
        $this->addArgument('guides_number', InputArgument::REQUIRED, 'What guides number?');
    }
}