<?php

namespace Todo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Todo\Database\Task;
use Todo\Database\Tag;

class AddCommand extends Command {
    
    private $entityManager;
    
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName('add')
                ->setDescription('Enter a task')
                ->addArgument('task', InputArgument::REQUIRED, 'Content of the task, may include #tags and @date');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $entityManager = $this->entityManager;
        
        $value = $input->getArgument('task');
        
        $task = new Task();
        $task->setValue($value);

        $hashtags = [];
        $date = "";
        preg_match_all("/(#\w+)/", $value, $hashtags);
        preg_match("/@[A-Za-z0-9_-]*/", $value, $date);
        
        $plannedAt = new \DateTime(ltrim($date[0], "@"));
        
        $task->setDatePlanned($plannedAt);
        
        foreach ($hashtags[0] as $hash) {
            $tag = $entityManager->getRepository('Todo\Database\Tag')->findOneBy(['value' => $hash]);
            if (!$tag) {
                $tag = new Tag();
                $tag->setValue($hash);
            }
            $task->addTag($tag);
        }
        
        $entityManager->persist($task); 
        $entityManager->flush();
        
        $output->writeln(sprintf("Test: %s", $value));
    }
}


//1. poczta polska api (api, console)
//2. horoskop (webscrap)
//3. todo app (doctrine, filesystem, console)
//	php todo.app "Write blog post #blog @tomorrow"
//	php todo.app list
//	[ ] Write blog post #blog
//	php todo.app list @2015-02-02