<?php

namespace App\Shared\Application\Commands\GenerateReportInsert;

use App\Shared\Domain\Repository\LogInsertInformationRepository;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-report-insert')]
class GenerateReportInsertCommand extends Command
{
    public function __construct(private readonly LogInsertInformationRepository $repository, private string $time_start, private string $time_end, private string $difference_days)
    {
        parent::__construct('app:generate-report-insert');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $delimiter = '|&';
        try {
            $this->time_start = $input->getArgument('time_start') ? $input->getArgument('time_start') : $this->time_start;
            $this->time_end = $input->getArgument('time_end') ? $input->getArgument('time_end') : $this->time_end;
            $this->difference_days = $input->getArgument('difference_days') !== null ? $input->getArgument('difference_days') : $this->difference_days;

            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Inicio job para generar el plano con las guias que generaron error al insertar --');
            $logs = $this->repository->getLogs($this->time_start, $this->time_end, $this->difference_days);
            $headers = [
                'NumRadicado', 'Request', 'Error', 'FechaDeCreacion'
            ];
            $content = implode($delimiter, $headers) . PHP_EOL;
            foreach ($logs as $log) {
                unset($log['id_log_insert_information']);
                $content .= implode($delimiter, $log) . PHP_EOL;
            }

            $date = new DateTime();
            $fp = fopen("public/error/error-insert-information-".$date->format('Y-m-d').'.txt',"w");
            fwrite($fp,$content);
            fclose($fp);
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin job para generar el plano con las guias que generaron error al insertar --');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin con error del job para generar el plano con las guias que generaron error al insertar --');
            return Command::FAILURE;
        }
    }

    private function createTxtForFile(array $item, string $delimiter, string $routeDocument): string {
        $content = implode($delimiter, $item) . PHP_EOL;

        return $content;
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