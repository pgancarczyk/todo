<?php

namespace Todo\Database;

/**
 * @Entity
 */
class Tag {
    
    /**
     * @Column(name="id", type="integer")
     * @ID
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    /**
     * @Column(name="value", type="string", length=255, unique=true)
     * 
     * @var string
     */
    private $value;
    
    /**
     * @ManyToMany(targetEntity="Task", mappedBy="tags")
     * 
     * @var \Doctrine\Common\Collections\ArrayCollection()
     */
    private $tasks;
    
    
    public function __construct() {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }
    
    public function setValue($value) {
        $this->value = $value;
    }

}
