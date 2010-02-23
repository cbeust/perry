<?

include_once "_common.php";

$user = $_POST['user'];
$name = $_POST['name'];
$admin = cbIsKnown($user);
setcookie("user", $user, $COOKIE_EXPIRATION);
setcookie("name", $name, $COOKIE_EXPIRATION);

$number = $_POST['heftNumber'];
$germanTitle = $_POST['germanTitle'];
$englishTitle = $_POST['englishTitle'];
$author = $_POST['author'];
$authorName = $_POST['fullName'];
$authorEmail = $_POST['emailAddress'];
$summary = $_POST['summary'];
$oldSummary = cbFindSummary($number);
$cycle = $_POST['cycle'];
$date = $_POST['date'];
$time = $_POST['time'];
$published = $_POST['published'];

echo cbHeader("Summary has been submitted");

if ($admin) {
  $id = cbGetUserInfo($user);
  if (is_null($fullName)) $fullName = $id[0];
  if (is_null($emailAddress)) $fullName = $id[1];
  cbUpdateSummaries($number, $germanTitle, $englishTitle,
      $user, $fullName, $emailAddress, $date, $time, $summary, $published);
  cbUpdateHeft($number, $germanTitle, $author);
  $redirectUrl = $DISPLAY_SUMMARY_URL . "?number=$number";
  cbRedirect($redirectUrl);
} else {
  echo '<p align="center"><b>Your summary has been submitted to the administrator.  Once it has been approved, it will be available '
  . cbGenUrl($number, "here")
  . '<br>Thanks for your participation! </b><p>'
;
  echo 'Back to the <a href="' . $ALL_CYCLES_URL . '">main page</a>.';

}

if (isset($_COOKIE['user'])) {
  $user = $_COOKIE['user'];
}

if (! $admin || ($admin && $_COOKIE["user"] != "atlan")) {
  if ($admin) {
    $id = cbGetUserInfo($user);
    if (is_null($fullName)) $fullName = $id[0];
    if (is_null($emailAddress)) $fullName = $id[1];
    $subject = "New summary submitted in admin mode by "
        . $user
	. " (" . $id[1] . ")"
	. " : " . $number;
    cbTrace("Sending mail from " . $fullName . " " . $emailAddress);
    global $MY_EMAIL_ADDRESS;
    mail($MY_EMAIL_ADDRESS,
        "New subject:" . $subject,
        $number . "\n". $germanTitle . "\n" . $englishTitle . "\n"
        . $fullName . "\n"
        . $emailAddress . "\n" . $date
        . "\n" . $DISPLAY_SUMMARY_URL . "?number=" . $number
        . "\n=====\n" . $summary
        . "\n==== OLD SUMMARY ====\n" . $oldSummary
        ,"Reply-to: " . $emailAddress . "\r\n"
    );
  }
  else {
    $subject = "New summary submitted, needs approval";

    $heftRow = cbFindHeftRow($number);
    $array = mysql_fetch_array($heftRow);
    $id = cbInsertIntoPending($number, $germanTitle,
      $array['author'], $array['published'],
      $englishTitle, $authorName, $authorEmail,
      $date, $summary);

    $approve = $APPROVE_URL . '?id=' . $id;
    global $MY_EMAIL_ADDRESS;
    mail($MY_EMAIL_ADDRESS,
        $approve . "\n"
      . $number . "\n". $germanTitle . "\n" . $englishTitle . "\n"
      . $authorName . "\n"
      . $authorEmail . "\n" . $date . "\n=====\n" . $summary
    );
  }
  
}



?>
