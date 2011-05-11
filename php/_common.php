<?

include_once "_config.php";
include_once "_orm.php";
include_once "_permissions.php";

function cbTweetSummary($number, $title) {
  global $DISPLAY_SUMMARY_URL;

  $emailTo = "PerryRhodanUs@twittermail.com";
  $url = $DISPLAY_SUMMARY_URL . "?number=" . $number;
  $message = $number . ": " . $title . "       " . $url;
  $ok = mail($emailTo, "", $message, "");
}

function e($s) {
  echo $s . "\n";
}

function cbLog($msg) {
  print "<p align=\"right\">$msg</p>";  
}

function cbTrace($msg) {
  global $debug;

//      print "<p align=\"right\">$msg</p>";
  if ($debug) {
/*
    if (cbIsCurrentUserAdmin()) {
*/
      print "<p align=\"right\">$msg</p>";
    }
//  }
}

function cbAdSense() {

return '

<script type="text/javascript"><!--
google_ad_client = "pub-1467757024002850";
google_ad_width = 120;
google_ad_height = 240;
google_ad_format = "120x240_as";
google_ad_channel ="7523371528";
google_color_border = "333333";
google_color_bg = "000000";
google_color_link = "FFCC00";
google_color_url = "FFCC00";
google_color_text = "FFCC00";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
';
}

function cbCss() {
  global $CSS_URL;
  return "\n"
      . '<link rel="stylesheet" href="' . $CSS_URL . '" >'
      . "\n"
      . '<link rel="stylesheet" href="http://beust.com/beust.css" >'
      . "\n"
      ;
}

function cbLoginInfo() {
  $user = $_COOKIE['user'];
  $string = "Login";

  if (is_null($user)) {
    $string = cbGenLogin("Login");
  } else {
    $ui = cbGetUserInfo($user);
    if (!is_null($ui[0])) {
      $string = $ui[0] . ", " . cbGenLogout();
    }
  }

  return "<p style='font-size: 80%;' align='right'>" . $string . "</p>";
}

function cbHeader($title, $pageTitle, $withRss) {
  global $CSS_URL, $RSS_FEED;
  echo '<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>'
. $title
. '</title>'
. "\n"
. ($withRss
    ? '<link rel="alternate" type="application/rss+xml" title="RSS" href="' . $RSS_FEED . '"/>'
    : "")
. "\n"
. cbCss()
. "\n"
. '</head>'
. "\n"
. "<body>\n"
. cbLoginInfo()
. "<h1 align='center'>" . $pageTitle . "</h1>"
. "\n"
;
}

/////
// URL generation
//

function cbGenLogin($text) {
  global $LOGIN_URL;
  return "<a href='" . $LOGIN_URL . "'>" . $text . "</a>";
}

function cbGenLogout() {
  global $LOGOUT_URL;
  return "\n<a href=" . $LOGOUT_URL . ">Logout</a>";
//  return "\n<a href='' OnClick='javascript: document.cookie="
//   . "user=; expires=Thu, 01-Jan-70 00:00:01 GMT;'>Logout</a>";
}

function cbGenSpan($span, $content) {
  return "<span class=\"" . $span . "\">"
  . $content
  . "</span>\n";
}

function cbGenSpanSmall($span, $content) {
  return "<span class=\"" . $span . "\">"
  . '<font size="-1">'
  . $content
  . '</font>'
  . "</span>\n";
}

function cbGenUrlWithLang($number, $content, $lang) {
  global $DISPLAY_SUMMARY_URL;

  return '<a href="'
    . $DISPLAY_SUMMARY_URL
    . '?number=' . $number
    . $lang
    . '">' . $content . '</a>';
}

function cbGenUrl($number, $content) {
  return cbGenUrlWithLang($number, $content, cbLangParam());
}

function cbGenImg($src) {
  return '<img border="0" src="' . $src . '"/>';
}

function cbGenEditUrl($number, $content) {
  global $EDIT_SUMMARY_URL;
  $lang = $_GET['lang'];
  return '<a href="' . $EDIT_SUMMARY_URL . '?number='
    . $number
    . (is_null($lang) ? "" : "&lang=" . $lang)
    . '">' . $content . '</a>';
}

function cbGenUrlCycle($number, $content) {
  global $DISPLAY_CYCLE_URL;

  return '<a href="'
. $DISPLAY_CYCLE_URL
. '?number='
. $number . '">' . $content . '</a>'
;
}

function cbGenDisplaySummaries($start, $end, $text) {
  global $DISPLAY_SUMMARY_URL;

  return '<a href="' . $DISPLAY_SUMMARY_URL
    . '?start=' . $start . '&end=' . $end
    . '">' . $text
    . '</a>'
    ;
}

function cbGenDownload($path, $language, $text) {
  global $DOWNLOAD_URL;

  if (! is_null($path) && strlen($path) > 0) {
    return '<a href="' . $DOWNLOAD_URL . $language . "/" . rawurlencode($path)
        . '">' . $text . '</a>';
  } else {
    return "&nbsp;";
  }
}

function cbGenEmailAttachment($file) {
  global $MAIL_URL;
  return '<a href="' . $MAIL_URL
      . "?file=" . rawurlencode($file) . "&title=" . basename($file)
      . '">' . "Send email" . '</a>';
}

function cbGenUpload($language, $number, $text) {
  global $UPLOAD_URL;

  return '<a href="' . $UPLOAD_URL . "?language=" . $language . "&number=" . $number . '">' . $text . '</a>';
}

//
// URL generation
/////

function cbRedirect($redirectUrl) {
  echo '<script type="text/javascript" language="JavaScript">
         this.location.href = "'
. $redirectUrl
. '";
  </script>';
}

function cbGetGermanFiles() {
  global $GERMAN;
  return glob("../" . $GERMAN . "/*");
}

function cbGetEnglishFiles() {
  global $ENGLISH;
  return glob("../" . $ENGLISH . "/*");
}

function cbLang() {
  $lang = $_GET['lang'];
  if (is_null($lang)) $lang = $_POST['lang'];
  return $lang;
}

function cbLangParam() {
  $lang = cbLang();
  return is_null($lang) ? "" : "&lang=" . $lang;
}

function cbSendEmailWithAttachment($fileatt, $fileatt_name) {
  $fileatt_type = "application/octet-stream"; // File Type

  $email_from = "cedric@beust.com"; // Who the email is from
  $email_subject = $fileatt_name;
  $email_message = "Perry Rhodan " . $fileatt_name . "\n\n";
  $email_to = "cbeust@kindle.com"; // Who the email is to
  $headers = "From: ".$email_from;

  $file = fopen($fileatt,'rb');
  $data = fread($file,filesize($fileatt));
  fclose($file);

  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

  $headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";

  $email_message .= "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $email_message . "\n\n";

  $data = chunk_split(base64_encode($data));

  $email_message .= "--{$mime_boundary}\n" .
    "Content-Type: {$fileatt_type};\n" .
    " name=\"{$fileatt_name}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
    $data . "\n\n" .
    "--{$mime_boundary}--\n";

  $ok = mail($email_to, $email_subject, $email_message, $headers);
//  $ok = 1;

  if($ok) {
    echo "<p>The file was successfully sent!<p>";

/*
    echo "<pre>To:" . $email_to
      . "\nSubject:" . $email_subject
      . "\nHeaders:" . $headers
      . "\nMessage:" . $email_message
      . "</pre>"
      ;
*/

  } else {
    die("Sorry but the email could not be sent. Please go back and try again!");
  }
}


?>
