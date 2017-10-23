<?php

namespace DueDateCalculator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DueDateCalculatorCommand extends Command
{
    protected function configure()
    {
        $this->setName("duedate:calculate")
            ->setDescription("Calculate Due Date")
            ->addArgument('Submit day', InputArgument::REQUIRED, 'Date in YYYY-MM-DD HH:MM:SS format')
            ->addArgument('Turnaround time', InputArgument::REQUIRED, 'Number, represents the hour');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $calculator = new DueDateCalculator();
        $submitDate = $input->getArgument('Submit day');
        $turnaroundTime = $input->getArgument('Turnaround time');

        try {
            $result = $calculator->calculate($submitDate, $turnaroundTime);
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
            exit();
        }

        $output->writeln('Result: ' . $result);

    }
}