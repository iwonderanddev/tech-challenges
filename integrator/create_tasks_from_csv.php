<?php

require_once("IWD_workflow.php");
use IWD_workflow\Story as Story;

//Constants
define("INPUT_FILE","stories.csv");
define("NEWLINE","<BR>");
define("MAX_ALLOWED_LINE_LENGTH", 1000);
define("SHORTCUT_API_TOKEN", "6388d558-2155-4094-9640-7b5c208273fc"); //@TODO : externalize in protected file !



/**
 *  Simple CSV parsing.  Perfomance shall be tweaked if larges files are to be used.
 *  @param inputFile The file to parse
 * 
 *  @throws Exception If read operation failed
 *  @return an array containing parsed Stories to create
 */
//@TODO : use PHP's fgetcsv function instead.  Currently, header is read as if it were data, which is a bug.
function parseCSV($inputFile) {
    $storiesToAdd = Array();
    
    //Empty lines are skipped to reduce potential import errors
    try {
        $lines = file($inputFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
        foreach($lines as $line) {
            $fields = explode(",", $line);
            $parsedStory = new Story($fields[0], $fields[1], $fields[2], $fields[3]);
            $storiesToAdd []= ($parsedStory);
        }
        return $storiesToAdd;
    }
    catch(Exception $e) {
        throw new Exception("An error occured when parsing CSV file");
    }
}

/**
 *  (Supposedly) adds stories to Shortcut
 *  @param storiesSet The set of stories to add, with their dependencies.
 * 
 *  @throws Exception If read operation failed
 *  @return an array containing parsed Stories to create
 */
function addStories($storiesSet) {
    //We parse all stories and create each one separetely if it has no uncreated parent.
    //Then reiterate over the tab to add story having their parents newly create, until all stories are done.
    //Brute-forcy method, but is creating a clean tree really necessary here ?
    //@TODO : add checks for creation errors, error codes & exceptions
    $createdStories = array();
    
    do {
        $StoriesToRemove = array();
        for ($i=0; $i<count($storiesSet); ++$i) {
            // Story can only be created if referred blocking story already exists
            $story = $storiesSet[$i];
            if (($story->blockedBy == "")
            || (array_key_exists($story->blockedBy, $createdStories))) {
                createStory($story);
                $createdStories[$story->description] = true;
                $StoriesToRemove[] = $i;
            }
        }
        // Added stories are removed from source array for next iterations
        if (count($StoriesToRemove) > 0) {
            for ($j=count($StoriesToRemove) -1; $j>=0; --$j) {
                //unset($storiesSet[$StoriesToRemove[$j]]);
                array_splice($storiesSet, $StoriesToRemove[$j], 1);
            }
        }
        // Infinite loop prenvention in case of bad input (e.g. circular refence between tasks leading to infinite loop)
        else {
            echo "FILE PROCESSING ABORTED. " . count($storiesSet) . " line(s) skipped";
            return FALSE;
        }
    }
    while (count($storiesSet) > 0);
    return count($createdStories);
}

/**
 *  (Supposedly) adds a story to Shortcut via its REST API
 *  @param story The story to add
 * 
 */
function createStory($story) {
    //@TODO !!!  Call API
    echo "Creating Story \"$story->description\"" . NEWLINE;
}

echo "<html>";
$stories = parseCSV(INPUT_FILE);
addStories($stories);
