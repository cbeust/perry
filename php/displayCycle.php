<?

include_once "_common.php";

$cycleNumber = $_GET['number'];

if (is_null($cycleNumber)) exit;

$query = "SELECT * FROM cycles WHERE number = '" . $cycleNumber . "'";

$resultCycles = cbQuery($query);
$englishTitle = mysql_result($resultCycles, 0, "english_title");
$numRows = mysql_numrows($resultCycles);

cbHeader("Perry Rhodan Summaries:" . $englishTitle,
    "Perry Rhodan Summaries:",
    false /* no rss */);

if ($numRows > 0) {
  $start = mysql_result($resultCycles, 0, "start");
  $end = mysql_result($resultCycles, 0, "end");
  $cycleNumber = mysql_result($resultCycles, 0, "number");

  $query2 = "SELECT * FROM hefte WHERE number >= $start && number <= $end";
  $resultHefte = cbQuery($query2);
  $numHefteRows = mysql_numrows($resultHefte);

  $heftStartRow = cbFindHeftRow($start);
  $heftStart = mysql_result($heftStartRow, 0, "published");
  $heftEndRow = cbFindHeftRow($end);
  $heftEnd = null;
  if (mysql_num_rows($heftEndRow) > 0) {
    $heftEnd = mysql_result($heftEndRow, 0, "published");
  }

  $summaryStartRow = cbFindSummaryRow($start);
  $summaryStart = null;
  if (mysql_num_rows($summaryStartRow) > 0) {  
    $summaryStart = mysql_result($summaryStartRow, 0, "date");
  }
  $summaryEndRow = cbFindSummaryRow($end);
  $summaryEnd = null;
  if (mysql_num_rows($summaryEndRow) > 0) {  
    $summaryEnd = mysql_result($summaryEndRow, 0, "date");
  }

  $titles = cbFindEnglishTitles($start, $end);
  $summaries = cbFindEnglishSummaries($start, $end);

  e('<h1 align="center"><i>' . $englishTitle . '</i></h1>');
  e('<h2 align="center">(Cycle ' . $cycleNumber . ', Hefte #' . $start . '-#' . $end . ')</h2>');
  e('<p align="right"><a href="mailto:cedric@beust.com">Cedric Beust</a> </p><hr>');

  echo '
<p>
Published in Germany from '
. $heftStart
. ' to '
. $heftEnd
. '<p>
Started reading: '
. $summaryStart
. '<p>
Finished reading: '
. $summaryEnd
. '<p>'
. cbGenDisplaySummaries($start, $end, "Display all the summaries on one page")
;

  echo '<p><TABLE BORDER=3>';

  $count = mysql_numrows($resultHefte);
  cbTrace("FOUND RESULTS:" . $count);

  for ($i = 0; $i < $count; $i++) {
    $heftNumber = mysql_result($resultHefte, $i, "number");
    $germanTitle = mysql_result($resultHefte, $i, "title");
    $htmlGermanTitle = cbGenUrl($heftNumber, $germanTitle);
    $englishTitle = cbFindEnglishTitle($heftNumber);
    $author = mysql_result($resultHefte, $i, "author");

    $displayedEnglishTitle = cbGenSpan("english-title-small", $englishTitle);
    
    echo "<tr> \n";
    echo "<td>" . cbGenSpan("number-small", $heftNumber) . "</td> \n";
    echo "<td>" . cbGenSpan("german-title-small", $htmlGermanTitle) . "</td> \n";
    echo "<td>" . $displayedEnglishTitle . "</td> \n";
    echo "<td>" . cbGenSpan("author", $author) . "</td> \n";
    echo "</tr>";
  } 

/*
  for ($i = $start; $i <= $end; $i++) {

    if ($summaries[$i] != "") {
      $rowIndex = $i - $start;
      $germanTitle = mysql_result($resultHefte, $rowIndex, "title");
      cbTrace("GERMAN TITLE FOR " . $rowIndex . ":" . $germanTitle);
      $author = mysql_result($resultHefte, $rowIndex, "author");
      cbTrace("DISPLAYING TITLE " . $i . ":" . $titles[$i]);
      $summary = $summaries[$i];
      $germanTitle = cbGenUrl($rowIndex, $germanTitle);
  
      echo "<tr> \n";
      echo "<td>" . cbGenSpan("number", $i) . "</td> \n";
      echo "<td>" . cbGenSpan("german-title", $germanTitle) . "</td> \n";
      echo "<td>" . cbGenSpan("english-title", $titles[$i]) . "</td> \n";
      echo "<td>" . cbGenSpan("author", $author) . "</td> \n";
      echo "</tr>";
    }
  }
*/
}
else {
  echo "No such cycle:  $cycle";
}

echo '</table>
<p>
<hr width="100%" />
<a href="'
. $ALL_CYCLES_URL
. '">Back to the main menu.</a>


</body>
</html>
';

?>
