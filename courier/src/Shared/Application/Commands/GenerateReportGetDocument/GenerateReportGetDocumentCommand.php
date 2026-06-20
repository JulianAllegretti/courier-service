<?php

namespace App\Shared\Application\Commands\GenerateReportGetDocument;

use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-report-get-document')]
class GenerateReportGetDocumentCommand extends Command
{
    public function __construct(private readonly LogGetDocumentFileRepository $repository, private string $time_start, private string $time_end, private string $difference_days)
    {
        parent::__construct('app:generate-report-get-document');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $delimiter = '|&';
        try {
            $this->time_start = $input->getArgument('time_start') ? $input->getArgument('time_start') : $this->time_start;
            $this->time_end = $input->getArgument('time_end') ? $input->getArgument('time_end') : $this->time_end;
            $this->difference_days = $input->getArgument('difference_days') !== null ? $input->getArgument('difference_days') : $this->difference_days;

            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Inicio job para generar el plano con las guias que generaron error al descargar los pds --');
            $logs = $this->repository->getLogs($this->time_start, $this->time_end, $this->difference_days);
            $headers = [
                'NumRadicado', 'IdDocumento', 'Request', 'Error', 'FechaDeCreacion'
            ];
            $content = implode($delimiter, $headers) . PHP_EOL;
            foreach ($logs as $log) {
                unset($log['id_log_get_document']);
                $content .= implode($delimiter, $log) . PHP_EOL;
            }

            $date = new DateTime();
            $fp = fopen("public/error/error-get-document-".$date->format('Y-m-d').'.txt',"w");
            fwrite($fp,$content);
            fclose($fp);
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin job para generar el plano con guias que generaron error al descargar los pds --');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin con error del job para generar el plano con las guias que generaron error al descargar los pds  --');
            return Command::FAILURE;
        }
    }

    protected function configure()
    {
        $this
            ->addArgument('time_start', InputArgument::OPTIONAL, 'What time to start?')
            ->addArgument('time_end', InputArgument::OPTIONAL, 'What time end?')
            ->addArgument('difference_days', InputArgument::OPTIONAL, 'How many days ago?')
        ;
    }
}