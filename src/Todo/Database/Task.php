<?php

namespace Todo\Database;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class Task {
    
    /**
     * @Column(name="id", type="integer")
     * @ID
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */    
    private $id;
    
    /**
     * @var string
     *
     * @Column(name="value", type="string", length=255)
     */    
    private $value;
    
    /**
     * @var \DateTime
     *
     * @Column(name="date_entered", type="datetime")
     */    
    private $dateEntered;
    
    /**
     * @ManyToMany(targetEntity="Tag", inversedBy="tasks", cascade={"persist"})
     * @JoinTable(name="tasks_tags")
     * 
     * @var array
     */
    private $tags;
    
    /**
     * @var \DateTime
     *
     * @Column(name="date_planned", type="date", nullable=true)
     */    
    private $datePlanned;
    
    
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @PrePersist
     */
    public function onCreated() {
        $this->setDateEntered(new \DateTime);
    }
    
    public function setDateEntered($value) {
        $this->dateEntered = $value;
    }
    
    public function addTag(Tag $tag) {
        $tag->addTask($this);
        $this->tags[] = $tag;
    }
    
    public function setDatePlanned(\DateTime $date) {
        $this->datePlanned = $date;
    }    
    
    public function getValue() {
        return $this->value;
    }

}
