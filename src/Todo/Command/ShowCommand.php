<?php

namespace Todo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Todo\Database\Task;

class ShowCommand extends Command {
    
    private $entityManager;
    
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName('show')
                ->setDescription('Show task for a given date')
                ->addArgument('date', InputArgument::OPTIONAL, 'Date to show tasks for', 'today');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $entityManager = $this->entityManager;
        
        if($input->getArgument('date') === 'all') {
            $tasksToShow = $entityManager->getRepository('Todo\Database\Task')->findAll();
        }
        else {
//            try {
                $date = new \DateTime($input->getArgument('date'));
//            }
//            catch (\Exception $e) {
//                var_dump($e->getMessage());
//                die;
//            }
//            echo __LINE__;
            
            $tasksToShow = $entityManager->getRepository('Todo\Database\Task')->findBy(['datePlanned' => $date]);
        }
//        echo __LINE__;  
        
        foreach ($tasksToShow as $task) {
            $output->writeln(sprintf("[ ] %s", $task->getValue()));
        }
    }
}


//1. poczta polska api (api, console)
//2. horoskop (webscrap)
//3. todo app (doctrine, filesystem, console)
//	php todo.app "Write blog post #blog @tomorrow"
//	php todo.app list
//	[ ] Write blog post #blog
//	php todo.app list @2015-02-02