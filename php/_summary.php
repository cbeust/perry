<?

/**
 * Display a single summary
 */
function cbDisplaySummary($number) {
  global $EDIT_SUMMARY_URL;

  cbTrace("DISPLAYING " . $number);
  $heftRow = cbFindHeftRow($number) or cbTrace(mysql_error());
  $numRows = mysql_numrows($heftRow);

  $title = mysql_result($heftRow, 0, "title");
  $author = mysql_result($heftRow, 0, "author");
  $summaryRow = cbFindSummaryRow($number);
  $summaryCount = mysql_numrows($summaryRow);

  $url = sprintf("http://perry-rhodan.net/pics/tibis/%04dtibi.jpg", $number);

  $date = null;
  if ($summaryCount > 0) {
    $summary = mysql_result($summaryRow, 0, "summary");
    $englishTitle = mysql_result($summaryRow, 0, "english_title");
    $date = mysql_result($summaryRow, 0, "date");
    $authorName = mysql_result($summaryRow, 0, "author_name");
    if ($date == null) $date = '';
  }

  echo '
    <table BORDER=0 CELLSPACING=0 COLS=3 WIDTH="100%" NOSAVE >
    <tr valign="top" NOSAVE>
    <td WIDTH="10%" NOSAVE></td>
    ';

  echo '
    <td WIDTH="80%" NOSAVE>'
    . "<p align='center'>"
    . cbGenSpan("number", $number)
    . ' - '
    . cbGenSpan("german-title", $title)
    . "<br>"
    . cbGenSpan("english-title", $englishTitle)
    . "<br>"
    . cbGenSpan("author", $author)
    . "</p>"
    . "<p align='right'>"
    ;

    if ($authorName != null) {
      echo cbGenSpanSmall("author", $authorName) . '<br>';
    }
    if ($date != null) {
      echo cbGenSpanSmall("date", $date);
    }

    echo "</p>";

    if ($summaryCount > 0) {
      echo cbGenSpan("text", $summary)
      . '</td>
        <td>
        <a href="' . $url  . '">'
      . '<img border="0" width="200" height="250" src="' . $url . '" />'
      . '</td></tr></table'
      ;
    }

    else {
      echo
      '</table>'
    . '<p align="center">'
    . '<a href="' . $url  . '">'
    . '<img border="0" width="200" height="250" src="' . $url . '"/></a>'
    . '<br>'
    . 'No summary was found for this issue.<br>
    You can <a href="'
    . $EDIT_SUMMARY_URL
    . '?heft='
    . $number
    . '">submit one</a> or return to the <a href="http://beust.com/perry">main page</a></p>';
  }


} // displaySummary

function cbDisplayFooter($number, $withNextAndPrevious) {
  if ($withNextAndPrevious == 1) {
    echo '<BR><BR>'
      . '<HR WIDTH=\"100%\">'
      . '<p>'
      . "\n | " . cbGenSpan("previous", cbGenUrl($number-1, "Previous episode"))
      . "\n | " . cbGenUrlCycle(cbFindCycle($number), "Back to the main menu")
      . "\n | " . cbGenSpan("previous", cbGenUrl($number+1, "Next episode"))
     ;
   } else {
     echo cbGenUrlCycle(cbFindCycle($number), "Back to the main menu");
   }

   $user = $_COOKIE["user"];
   if (cbCanEdit($user)) {
    echo "\n | " . cbGenEditUrl($number, "Edit this summary");
  }

  $german_file = cbGetGermanFile($number);
  global $GERMAN;
  if (cbCanDownload($user) && ! is_null($german_file)) {
    echo "\n | " . cbGenDownload($german_file, $GERMAN, "Download German");
  } else if (cbCanUpload($user)) {
    echo "\n | " . cbGenUpload($GERMAN, $number, "Upload German");
  }

  $english_file = cbGetEnglishFile($number);
  global $ENGLISH;
  if (cbCanDownload($user) && ! is_null($english_file)) {
    echo "\n | " . cbGenDownload($english_file, $ENGLISH, "Download English");
  } else if (cbCanUpload($user)) {
    echo "\n | " . cbGenUpload($ENGLISH, $number, "Upload English");
  }

  if ($withNextAndPrevious == 0) {
    echo '<BR><BR>'
      . '<HR WIDTH=\"100%\">'
      . '<p>'
    ;
  }
}

function cbGetFile($dir, $number) {
  $result = glob("../" . $dir . "/*" . $number . "*");
  return is_null($result) || sizeof($result) == 0 ? null : basename($result[0]);
}

function cbGetGermanFile($number) {
  global $GERMAN;
  return cbGetFile($GERMAN, $number);
}

function cbGetEnglishFile($number) {
  global $ENGLISH;
  return cbGetFile($ENGLISH, $number);
}

?>
