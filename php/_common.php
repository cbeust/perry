<?

include_once "_config.php";
include_once "_orm.php";
include_once "_permissions.php";

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

function cbBackground() {
  global $BACKGROUND_URL;
  return "\n"
      . '<body text="#FFCC00" bgcolor="#FFFFFF" link="#33CCFF"'
      . ' vlink="#cc00cc" alink="#FF0000" background="'
      . $BACKGROUND_URL
      . '">'
      . "\n";
}

function cbCss() {
  return "\n"
      . '<link rel="stylesheet" href="http://beust.com/perry/summary.css" >'
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
    ? '<link rel="alternate" type="application/rss+xml" title="RSS" href="' . $RSS_FEED . "/>"
    : "")
. "\n"
. cbCss()
. "\n"
. '</head>'
. "\n"
. cbBackground()
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

function cbGenUrl($number, $content) {
  global $DISPLAY_SUMMARY_URL;

  return '<a href="'
. $DISPLAY_SUMMARY_URL
. '?number=' . $number 
. '">' . $content . '</a>';
}

function cbGenEditUrl($number, $content) {
  global $EDIT_SUMMARY_URL;
  return '<a href="' . $EDIT_SUMMARY_URL . '?heft='
    . $number . '">' . $content . '</a>';
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

?>
