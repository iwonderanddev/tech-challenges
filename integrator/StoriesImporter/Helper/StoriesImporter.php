<?php
//namespace Imports;

require_once("API/RequestManager.php");
require_once("Model/Story.php");

use API\RequestManager as RequestManager;
use Model\Story as Story;

define("SHORTCUT_API_TOKEN", "6388d558-2155-4094-9640-7b5c208273fc"); //@TODO : externalize in protected config file
define("DEFAULT_WORKFLOW_ID", 500000020); 
define("DEFAULT_INPUT_FILE","..\stories.csv");
define("MAX_ALLOWED_LINE_LENGTH", 1000);
define("NEWLINE","<BR>");

class StoriesImporter {


    /**
     * Request manager
     */
    protected $api;

    /**
     * Name => ID matching table for inserting stories with the right Epic reference
     */
    protected $epicIDs;
    /**
     * Name => ID matching table for inserting stories with the right Epic reference
     */
    protected $stateIDs;

    /**
     * Name => ID matching table for linking stories with the right parent story reference
     */
    protected $storiesIDs;

    /**
     * Importer will write some "logs" to standard output if enabled.
     */
    public $verbose;
    
    /**
     * @constructor
     */
    public function __construct($isVerbose = TRUE) {
        $this->api = new RequestManager(SHORTCUT_API_TOKEN);
        $this->epicIDs = $this->getEpicsIDs();
        $this->stateIDs = $this->getWorkflowStatesIDs(DEFAULT_WORKFLOW_ID);
        $this->storiesIDs = array();
        $this->verbose = $isVerbose;
    }
    
    /**
     * Get epics IDs so we can refer them when creating our stories
     *
     * @return An array containing the list of epic names as keys and their IDs as values
     */
    function getEpicsIDs() {
        $epics = array();
        $res = $this->api->request("GET", "epics");
        foreach ($res["data"] as $k=>$v) {
            $epics[$v["name"]] = $v["id"];
        }
        return $epics;
    }
    /**
     * Get states IDs from our workflow so we can refer them when creating our stories
     *
     * @return An array containing the list of story-states names as keys and their IDs as values
     */
    function getWorkflowStatesIDs($workflowId) {
        $stateIDs = array();
        $res = $this->api->request("GET", "workflows/$workflowId");
        foreach ($res["data"]["states"] as $k=>$v) {
            $stateIDs[mb_strtolower($v["name"])] = $v["id"];
        }
        return $stateIDs;
    }
    
    /**
     * Visual "Cleanup" intended for a test space.
     * Sets all stories as "archived".
     */
    public function archiveAllStories() {
        // Retrival of all non-archived stories IDs
        $requestData = ["archived" => "true"]; // Note : At least one search criterion must be set.
        $res = $this->api->request("POST", "stories/search", $requestData);
        if ($res['httpCode'] !== 201) {
            $this->info("Something went wrong @archiveAllStories.1stRequest"); //@TODO real error handling
            $this->info("<pre>" . print_r($res, true));
        }
        $ids = array();
        if (count($res["data"]) > 0) {
            foreach ($res["data"] as $k=>$v) {
                $ids[] = $v["id"];
            }
            // Archive action
            $requestData2 = [
                "archived" => "true",
                "story_ids" => $ids
            ];
            $res2 = $this->api->request("PUT", "stories/bulk", $requestData2);
            if ($res2['httpCode'] !== 200) {
                $this->info("Something went wrong @archiveAllStories.2ndRequest"); //@TODO real error handling
                $this->info("<pre>" .print_r($res2, true));
            }
        }
        $this->info(count($ids) . " stories archived successfully");
    }
    

    /**
     * Creates a story within an Epic
     * Sets name (from Description), Epic and State.
     * Does not add Parent->child story relations.
     *
     * @return the request resultset
     * @TODO manage errors/exceptions 
     */
    function createStory($story) {
        $requestData = [
            "workflow_state_id" => $this->stateIDs[mb_strtolower($story->status)],
            "name" => $story->description,
            "epic_id" => $this->epicIDs[$story->epic]
        ];
        $res = $this->api->request("POST", "stories", $requestData);
        $storyId = $res["data"]["id"];
        $this->storiesIDs[$story->description] = $storyId;
        return $res;
    }

    /**
     * Adds parent-child precedency relations between 2 stories
     *
     * @param $parentId The blocking story ID
     * @param $childId The blocked story ID
     */
    function addChildToStory($parentId, $childId) {
        $requestData = [
            "object_id" => $childId,
            "subject_id" => $parentId,
            "verb" => "blocks",
        ];
        $res = $this->api->request("POST", "story-links", $requestData);
        if ($res['httpCode'] !== 201) {
            $this->info("Something went wrong @deleteAllStories.1stRequest"); //@TODO error handling
            $this->info("<pre>" .print_r($res, true));
            }
        }



        
    /**
     *  Simple CSV parsing.  Perfomance shall be tweaked if larges files are to be used.
     *  @param inputFile The file to parse
     * 
     *  @throws Exception If read operation failed
     *  @return an array with the parsed Stories to create
     */
    public function parseCSV($inputFile = DEFAULT_INPUT_FILE) {
        $storiesToAdd = Array();
        
        //Empty lines are skipped to reduce potential import errors
        try {
            $lines = file($inputFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
            foreach($lines as $line) {
                $fields = explode(",", $line);
                $parsedStory = new Story($fields[0], $fields[1], $fields[2], $fields[3]);
                $storiesToAdd []= ($parsedStory);
            }
            array_splice($storiesToAdd, 0, 1); //Remove header line.  @TODO : use PHP's fgetcsv function instead.
            return $storiesToAdd;
        }
        catch(Exception $e) {
            throw new Exception("An error occured when parsing CSV file");
        }
    }
    
    
    /**
     *  Adds stories to Shortcut via its web API
     *  @param storiesSet The set of stories to add, with their dependencies.
     * 
     *  @throws Exception If read operation failed
     *  @return void
     */
    function addStories($storiesSet) {
        //@TODO : add checks for creation errors, error codes & exceptions
        $requestsResults = array();
        
        for ($i=0; $i<count($storiesSet); ++$i) {
            $story = $storiesSet[$i];
            $this->info ("Creating Story \"$story->description\" with parent \"$story->blockedBy\"");
            $newStory = $this->createStory($story);
            $newStoryId = $newStory["data"]["id"];
            $requestsResults["$newStoryId"] = $newStory;
            $this->storiesIDs[$story->description] = $newStoryId;
            $this->info("&nbsp;&nbsp;Created with id $newStoryId");
        }

        // Add dependencies links
        for ($i=0; $i<count($storiesSet); ++$i) {
            $story = $storiesSet[$i];
            if (!empty($story->blockedBy)) {
                $childId = $this->storiesIDs[$story->description];
                $parentId = $this->storiesIDs[$story->blockedBy];
                $this->addChildToStory($parentId, $childId);
                $this->info("Story $childId is now blocked by Story $parentId");
            }
        }
    }
    
    /**
     * Show standard output if $verbose is set to true), else, flushes them out.
     */
    private function info($msg) {
        if ($this->verbose) {
            echo "$msg" . NEWLINE;
        }
    }    
}
