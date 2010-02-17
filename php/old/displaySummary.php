<?

include "config.php";

$number = $_GET['heft'];

$heftRow = cbFindHeftRow($number);
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
<HTML>
<HEAD>
<TITLE>Perry Rhodan #' 
. $number 
. '</TITLE>
<link rel="stylesheet" href="http://beust.com/perry/summary.css" >
<link rel="stylesheet" href="http://beust.com/beust.css" >
</HEAD>

<body text="#FFCC00" bgcolor="#FFFFFF" link="#33CCFF" vlink="#cc00cc" alink="#FF0000" background="http://beust.com/perry/background.jpg">
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
. '<img border="0" width="200" height="250" src="' . $url . '" />
</td>
</table>
<BR>
<BR>
<HR WIDTH=\"100%\">
<p>'
. "|" . cbGenSpan("previous", cbGenUrl($number-1, "Previous episode"))
. "|" . cbGenUrlCycle(cbFindCycle($number), "Back to the main menu")
. "|" . cbGenSpan("previous", cbGenUrl($number+1, "Next episode"))
;
if (cbIsCurrentUserAdmin()) {
  echo "|" . cbGenEditUrl($number, "Edit this summary");
}

}
else {
  echo 

  '<p align="center">'
. '<a href="' . $url  . '">'
. '<img border="0" width="200" height="250" src="' . $url . '"/></a>'
. '<br>'
. 'No summary was found for this issue.<br>
You can <a href="'
. $EDIT_SUMMARY_URL
. '?heftNumber='
. $number
. '">submit one</a> or return to the <a href="http://beust.com/perry">main page</a></p>';
}


?>
