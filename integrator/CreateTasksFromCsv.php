<?php
namespace IWD_workflow;

require_once("IWD_workflow.php");
require_once("ShortcutApi.php");

define("SHORTCUT_API_TOKEN", "6388d558-2155-4094-9640-7b5c208273fc"); //@TODO : externalize in protected file !
define("STORY_DEFAULT_STATE_ID", 500000021); 
define("INPUT_FILE","stories.csv");
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
     * Name => ID matching table for inserting stories with the right parent story reference
     */
    protected $storiesIDs;

    /**
     * @constructor
     */
    public function __construct() {
        $this->api = new ShortcutApi(SHORTCUT_API_TOKEN);
        $this->epicIDs = $this->getEpics();
        $this->storiesIDs = array();
    }
    
    /**
     * Get epics IDs so we can refer them when creating our stories
     *
     * @return An array containing the list of epic names as keys and their IDs as values
     */
    function getEpics() {
        $epics = array();
        $res = $this->api->request("GET", "epics");
        foreach ($res["data"] as $k=>$v) {
            $epics[$v["name"]] = $v["id"];
        }
        return $epics;
    }

    /**
     * Creates a story, with its preceding parent task if necessary, and associated epic
     *
     * @return the request resultset
     * @TODO manage errors/exceptions 
     */
    function createStory($story) {
        $requestData = [
            "workflow_state_id" => STORY_DEFAULT_STATE_ID,
            "name" => $story->description,
            "epic_id" => $this->epicIDs[$story->epic]
        ];

//echo "YYYYYYYYYYYYYYYYYYY" . NEWLINE;
//var_dump($requestData);
//echo "YYYYYYYYYYYYYYYYYY2" . NEWLINE;
        $res = $this->api->request("POST", "stories", $requestData);
//var_dump($res);
        $storyId = $res["data"]["id"];
        $this->storiesIDs[$story->description] = $storyId;
//echo "***** added story ID : $storyId *****" . NEWLINE;
//var_dump($this->storiesIDs);
        return $res;
    }

    /**
     * Adds parent-child dependency between 2 stories
     *
     * 
     */
    function addChildToStory($parentId, $childId) {
        $requestData = [
            "after_id" => $parentId
        ];
echo "UUUUUUUUUPdating child $childId with parent $parentId" . NEWLINE;
        $res = $this->api->request("PUT", "stories/$childId", $requestData);
    }
    
    /**
     *  Simple CSV parsing.  Perfomance shall be tweaked if larges files are to be used.
     *  @param inputFile The file to parse
     * 
     *  @throws Exception If read operation failed
     *  @return an array containing parsed Stories to create
     */
    //@TODO : use PHP's fgetcsv function instead.  Currently, header is read as if it were data
    public function parseCSV($inputFile) {
        $storiesToAdd = Array();
        
        //Empty lines are skipped to reduce potential import errors
        try {
            $lines = file($inputFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
            foreach($lines as $line) {
                $fields = explode(",", $line);
                $parsedStory = new Story($fields[0], $fields[1], $fields[2], $fields[3]);
                $storiesToAdd []= ($parsedStory);
            }
            array_splice($storiesToAdd, 0, 1); //Remove header line.
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
     *  @return an array containing parsed Stories to create
     */
    function addStories2($storiesSet) {
        //@TODO : add checks for creation errors, error codes & exceptions
        $requestsResults = array();
        
        for ($i=0; $i<count($storiesSet); ++$i) {
            $story = $storiesSet[$i];
echo "Creating Story \"$story->description\"" . NEWLINE;
            $newStory = $this->createStory($story);
            $newStoryId = $newStory["data"]["id"];
            $requestsResults["$newStoryId"] = $newStory;
            $this->storiesIDs[$story->description] = $newStoryId;
        }

        // Add dependencies links
        for ($i=0; $i<count($storiesSet); ++$i) {
            $story = $storiesSet[$i];
            if (!empty($story->blockedBy)) {
                $childId = $this->storiesIDs[$story->description];
                $parentId = $this->storiesIDs[$story->blockedBy];
                $this->addChildToStory($parentId, $childId);
            }
else {
echo "$storiesSet[$i]->blockedBy  feels empty" . NEWLINE;                
}
        }
    }
    
    
}


    $importer = new StoriesImporter();

    echo "<html>";
    $stories = $importer->parseCSV(INPUT_FILE);
    $importer->addStories2($stories);























    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    