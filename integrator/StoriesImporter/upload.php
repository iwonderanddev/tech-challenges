<html>
<div style="margin-left:auto; margin-right:auto; margin-top:200px; max-width: 400px;">
<a href="index.php">Back to index </a>
<br>
<br>
<?php
// This file manages CSV imports
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if(isset($_POST["action"])) {

    // Load the Helper
    require_once("Helper/StoriesImporter.php");
    $verboseMode = (isset($_POST['verbose']));
    $importer = new StoriesImporter($verboseMode);
    
    // Custom user file
    if ($_POST['action'] == "Upload !") {
        $inputFile = $_FILES["fileToUpload"]["tmp_name"];
        
        if ($inputFile) {
            $stories = $importer->parseCSV($inputFile);
            $importer->addStories($stories);
        }
        //Redirects to index if no file was selected
        else {
            header('Location: ' . "index.php?message=" . "No file was submitted, please, use the \"browse\" button to select one before submitting");
            die();
        }
    // Default test file
    } else if ($_POST['action'] == "IMPORT test file") {
        $stories = $importer->parseCSV();
        $importer->addStories($stories);
    } else {
        echo "INVALID action"; die();
    }
}



?>
</div>
</html>