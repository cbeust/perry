<?

include_once "_common.php";

$language = $_GET['language'];
$number = $_GET['number'];

$text = 'Upload '
. ($language == "en" ? "an English" : "a German")
. ' file for issue #' . $number
;

cbHeader("$text", "$text", false /* no rss */);


echo "<p>Please make sure that the number for this issue (" . $number . ") appears in the file name."

. '<p> <form action="_upload.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<input type="hidden" name="number" value="' . $number . '"/>
<input type="hidden" name="language" value="' . $language . '"/>
<br />
<input type="submit" name="submit" value="Submit" />
</form>

';

?>
