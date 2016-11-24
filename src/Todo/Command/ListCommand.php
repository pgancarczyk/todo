<?php

namespace Todo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {
    
    protected function configure()
    {
        $this->setName('tasks')
                ->setDescription('List tasks');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(sprintf("Test: %s", "test"));
    }
}
