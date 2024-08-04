<?php

namespace App\DocumentManagement\Application\Commands\CheckGuideNumber;

use App\DocumentManagement\Application\Helpers\GuideNumberHelper;
use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(name: 'app:check-guide-number')]
class CheckGuideNumberCommand extends Command
{
    private GuideNumberHelper $helper;

    public function __construct(private GuideNumberRepository $repository, private MailerInterface $mailer, private string $mail_sender, private string $mail_to_notify)
    {
        $this->helper = new GuideNumberHelper();
        parent::__construct('app:check-guide-number');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $guideNumber = $this->repository->getGuideNumber();
            $currentNumber = $this->helper->extractNumbersFromGuide($guideNumber->getCurrentNumber());
            $limitNumber = $this->helper->extractNumbersFromGuide($guideNumber->getEndNumber());
            if (($limitNumber - $currentNumber) > 100) {
                $output->writeln('El número de guía está dentro de un rango seguro.');
                return Command::SUCCESS;
            }

            $email = (new Email())
                ->from($this->mail_sender)
                ->to($this->mail_to_notify)
                ->subject('Número de guía cerca del límite')
                ->text('El número de guía actual está cerca de su límite. Por favor, tome las medidas necesarias.')
                ->html('<p>El número de guía actual está cerca de su límite. Por favor, tome las medidas necesarias</p>');

            $this->mailer->send($email);

            $output->writeln('Notificación de correo enviada.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        } catch (TransportExceptionInterface $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}