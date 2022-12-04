<html>
<div style="margin-left:auto; margin-right:auto; margin-top:200px; max-width: 400px;">
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="submit" name="action" value="IMPORT test file">
    <br>Or select a custom .csv file to upload:
    <br><input type="file" name="fileToUpload" id="fileToUpload" style="margin-top:4px">
    <br><input type="submit" name="action" value="Upload !" style="margin-top:4px">
    <br><label><input type="checkbox" name="verbose" value="verbose" text="Verbose mode" checked="checked">Verbose import output</label>
    </form>

<br>
<?php
if(isset($_GET["message"])) {
    echo $_GET["message"];
}
?>
</div>
</html>