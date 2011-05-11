<?

$debug = false;

$MY_EMAIL_ADDRESS = "cbeust@gmail.com";
//$MY_EMAIL_ADDRESS = "cbeust@google.com";

if ($debug) {
  error_reporting(E_ALL);
}

$COOKIE_EXPIRATION = time() + 60*60*24*364;  // 1 year

$MAIN_URL = "http://perryrhodan.us/";

$ALL_CYCLES_URL = $MAIN_URL . "php/allCycles.php";
$QUERY_SUMMARY_URL = $MAIN_URL . "php/querySummary.php";
$EDIT_SUMMARY_URL = $MAIN_URL . "php/editSummary.php";
$SUBMIT_SUMMARY_URL = $MAIN_URL . "php/submitSummary.php";
$DISPLAY_SUMMARY_URL = $MAIN_URL . "php/displaySummary.php";
$DISPLAY_CYCLE_URL = $MAIN_URL . "php/displayCycle.php";
$APPROVE_URL = $MAIN_URL . "php/_approve.php";
$DOWNLOAD_URL = $MAIN_URL . "";
$UPLOAD_URL = $MAIN_URL . "php/uploadFile.php";
$LOGIN_URL = $MAIN_URL . "php/login.php";
$LOGOUT_URL = $MAIN_URL . "php/logout.php";
$MAIL_URL = $MAIN_URL . "php/email.php";

$LEFT_IMG = $MAIN_URL . "agt_back-64.png";
$RIGHT_IMG = $MAIN_URL . "agt_forward-64.png";

// Directories where issues can be found
$ENGLISH = "en";
$GERMAN = "ge";

$RSS_FEED = "http://feeds.feedburner.com/PerryRhodanSummaries";

$CSS_URL = $MAIN_URL . "summary.css";
$BACKGROUND_URL = $MAIN_URL . "background.jpg";

// Level for users that are not logged in
$MAX_LEVEL = 5;

?>
