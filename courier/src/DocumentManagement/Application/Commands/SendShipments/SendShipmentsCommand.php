<?php

namespace App\DocumentManagement\Application\Commands\SendShipments;

use App\DocumentManagement\Application\UseCases\ISendShipmentsUseCase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-shipments')]
class SendShipmentsCommand extends Command
{
    public function __construct(private readonly ISendShipmentsUseCase $useCase, private string $time_start, private string $time_end, private string $difference_days)
    {
        parent::__construct('app:send-shipments');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->time_start = $input->getArgument('time_start') ? $input->getArgument('time_start') : $this->time_start;
            $this->time_end = $input->getArgument('time_end') ? $input->getArgument('time_end') : $this->time_end;
            $this->difference_days = $input->getArgument('difference_days') !== null ? $input->getArgument('difference_days') : $this->difference_days;
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Inicio job para enviar la informacion a 472 --');
            $response = $this->useCase->sendShipments($this->time_start, $this->time_end, $this->difference_days, $output);
            $output->writeln($response != "" ? $response : '-- No se envio ningun documento a 472 --');
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin job para generar el plano con las guias recibidas --');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $output->writeln('[' . date('Y-m-d H:i:s') . '] -- Fin con error del job para generar el plano con las guias recibidas --');
            return Command::FAILURE;
        }
    }

    protected function configure(): void
    {
        $this
            ->addArgument('time_start', InputArgument::OPTIONAL, 'What time to start?')
            ->addArgument('time_end', InputArgument::OPTIONAL, 'What time end?')
            ->addArgument('difference_days', InputArgument::OPTIONAL, 'How many days ago?')
        ;
    }
}
