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

  cbGenHtml($number, $title, $englishTitle, $author, $summary,
      $summaryCount, $url, $authorName, $date);
} // displaySummary

/**
 * Generate a link to the image cover
 */
function cbGenCover($url, $align) {
  return
      '<a href="' . $url  . '">'
    . '<img style="padding: 10px;" align="' . $align
    . '" border="0" width="200" height="250"'
    . 'src="' . $url . '" />'
    . '</a>';
}

/**
 * Generate the HTML content for this summary.
 */
function cbGenHtml($number, $title, $englishTitle, $author, $summary,
    $summaryCount, $url, $authorName, $date) {
  echo
    '<p align="center">'
    . "<p align='center'>"
    . cbGenSpan("number", $number)
    . ' - '
    . cbGenSpan("german-title", $title)
    . "<br>"
    . cbGenSpan("english-title", $englishTitle)
    . "<br>"
    . cbGenSpan("author", $author)
    . "<hr width='20%'/>"
    . "</p>"
    . "<htr>"
    . "<table><tr><td>"
    ;

    if ($summaryCount > 0) {
      echo cbGenSpan("text", $summary);
      echo '</td>'
        . '<td valign="top">'
	. cbGenCover($url, "right")
        . '</td></tr></table>'
        ;

    } else {
      global $MAIN_URL, $EDIT_SUMMARY_URL;
      echo
        '</table>'
        . '<p align="center">'
	. cbGenCover($url, "center")
        . '<br>'
        . 'No summary was found for this issue.<br>
          You can <a href="'
        . $EDIT_SUMMARY_URL
        . '?number='
        . $number
        . '">submit one</a> or return to the '
	. '<a href="' . $MAIN_URL . '">main page</a></p>';
    }

    echo '<p align="right">'
      . (is_null($authorName) ? "" : cbGenSpanSmall("author", $authorName))
      . (is_null($date) ? "" : " " . cbGenSpanSmall("date", $date))
      . '</p>'
      ;
}

function cbDisplayFooter($number, $withNextAndPrevious) {
  global $LEFT_IMG, $RIGHT_IMG;
  if ($withNextAndPrevious == 1) {
    echo "\n"
      . '<table align="center" width="50%" border="0">'
      . '<tr>'
      . "\n"
      . '<td align="right">'
      .  cbGenSpan("previous", cbGenUrl($number-1, cbGenImg($LEFT_IMG)))
      . '</td>'
      . "\n"
      . '<td align="center">'
      . "\n"
      . cbGenUrlCycle(cbFindCycle($number), "Back to the cycle")
      . "</td>"
      . "\n"
      . '<td align="right">'
      .  cbGenSpan("previous", cbGenUrl($number+1, cbGenImg($RIGHT_IMG)))
      . '</td>'
      . '</tr>'

      ;
   } else {
     echo cbGenUrlCycle(cbFindCycle($number), "Back to the main menu");
   }

  $extras = "";

  $user = $_COOKIE["user"];

  //
  // English/French
  //
  if (cbIsAdmin($user)) {
    $lang = cbLang();
    if ($lang == "fr") {
      $newLang = "";
      $langText = "English";
    } else {
      $newLang = "fr";
      $langText = "French";
    }
    $newLang = $lang == "fr" ? "" : "&lang=fr";
    $extras = $extras . "\n | " . cbGenUrlWithLang($number, $langText, $newLang);
  }

  //
  // Edit this summary
  //
  if (cbCanEdit($user)) {
    $extras = $extras . "\n | " . cbGenEditUrl($number, "Edit this summary");
  }

  //
  // Download/upload German
  //
  $german_file = cbGetGermanFile($number);
  global $GERMAN;
  if (cbCanDownload($user) && ! is_null($german_file)) {
    $extras = $extras
        . "\n | " . cbGenDownload($german_file, $GERMAN, "Download German");
  } else if (cbCanUpload($user)) {
    $extras = $extras
        . "\n | " . cbGenUpload($GERMAN, $number, "Upload German");
  }

  //
  // Download/upload English
  //
  $english_file = cbGetEnglishFile($number);
  global $ENGLISH;
  if (cbCanDownload($user) && ! is_null($english_file)) {
    $extras = $extras
        . "\n | " . cbGenDownload($english_file, $ENGLISH, "Download English");
  } else if (cbCanUpload($user)) {
    $extras = $extras
        . "\n | " . cbGenUpload($ENGLISH, $number, "Upload English");
  }

  if ($extras != "") $extras = $extras . " |";

  echo "<tr><td></td><td align='center'>" . $extras . "</td></tr></table>";

  if ($withNextAndPrevious == 0) {
    echo '<BR><BR>'
      . '<HR WIDTH=\"100%\">'
      . '<p>'
    ;
  }
}

function cbDisplayFooterOld($number, $withNextAndPrevious) {
  if ($withNextAndPrevious == 1) {
    echo '<BR><BR>'
      . '<HR WIDTH=\"100%\">'
      . '<p>'
      . "\n | " . cbGenSpan("previous", cbGenUrl($number-1, "Previous episode"))
      . "\n | " . cbGenUrlCycle(cbFindCycle($number), "Back to the main menu")
      . "\n | " . cbGenSpan("previous", cbGenUrl($number+1, "Next episode"))
     ;
   } else {
     echo cbGenUrlCycle(cbFindCycle($number), "Back to the cycle");
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
