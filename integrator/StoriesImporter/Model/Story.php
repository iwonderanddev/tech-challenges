<?php
namespace Model;


/**
 * Class Story
 * @package IWD_workflow
 * A story, with its parent story & epic, when applicable
 */
class Story {
    /** 
     * @var
     * Task's name/description
     */
    public $description;
    
    /** 
     * @var
     * Advancement status
     */
    public $status;
    
    /** 
     * @var
     * The name of the epic this story belongs to
     */
    public $epic;
    
    /** 
     * @var
     * Parent story, which needs to be completed before this one can start.
     */
    public $blockedBy;
    
    /**
     * @constructor
     * Basic constructor filling all 4 standard Story fields
     */
    public function __construct($description, $status, $epic, $blockedBy) {
        $this->description = $description;
        $this->status = $status;
        $this->epic = $epic;
        $this->blockedBy = $blockedBy;
    }

    /**
     * Displays this story as a text string
     *
     * @param Place   $where  Where something interesting takes place
     * @param integer $repeat How many times something interesting should happen
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Monkey Coder <mcoder@facebook.com>
     * @return Status
     */
    public function toString() {
        return "{$this->description}, {$this->status}, {$this->epic}, {$this->blockedBy}";
    }

}