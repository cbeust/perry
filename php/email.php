<?

include_once "_common.php";

echo "Emailing " . $_GET["file"] . " Subject:" . $_GET["title"];

cbSendEmailWithAttachment($_GET["file"], $_GET["title"]);
?>
