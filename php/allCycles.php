<?

include "_common.php";

cbHeader("Perry Rhodan cycles", "Perry Rhodan Cycles", true /* rss */);

echo 'Here is a list of all the Perry Rhodan cycles along with the number 
of issues that have an English summary.  If you recently read
an issue that is not listed below, please <a href="'
. $QUERY_SUMMARY_URL
. '">submit a summary</a>.



You can also subscribe to the
<a href="http://feeds.feedburner.com/PerryRhodanSummaries">
RSS feed
<img src="http://beust.com/pics/feed-icon16x16.png"
     alt="http://feeds.feedburner.com/PerryRhodanSummaries" border="0"/></a>,
 <a href="http://twitter.com/PerryRhodanUS">follow us on Twitter</a> 
 or jump directly to an issue:

<table align="center">
<tr align="center"><td>
<form action = '
. $DISPLAY_SUMMARY_URL 
. ' method="get"><input type="text" name="number"></input>'
. '<br>'
. '<input type="submit" value="Show" />'
. '</td></tr></table>'
. '<p>'
;

$summaryPercentage = round(cbCountSummaries() * 100 / cbHeftCount());

echo '

<table>
<tr>
<td>
Total number of summaries:
</td>
<td>'
. cbCountSummaries()
. ' ('
. $summaryPercentage
. '%).
</td></tr>
</tr>
</table>';

echo "Latest summaries posted:";

$summaryRow = cbFindLatestSummaryRow(5);

echo "<ul>";
for ($i = 0; $i < 5; $i++) {
  $heft = mysql_result($summaryRow, $i, "number");
  $date = mysql_result($summaryRow, $i, "date");
  $englishTitle = cbFindEnglishTitle($heft);
  $content = "#" . $heft . ":  " . $englishTitle;
  echo "<li>" . cbGenUrl($heft, $content)
    . " (" . $date . ")"
    . "</li>";
}
echo "</ul>";

echo '
<br>

<table border="2" >
<tr>
<th>Number</th>
<th>Issues</th>
<th>German title</th>
<th>English title</th>
<th>Number of summaries</th>
<th>Percentage completed</th>
</tr>
';


$cycleRow = cbFindCyclesRow();
$cycleCount = mysql_numrows($cycleRow);

for ($i = 0; $i < $cycleCount; $i++) {
  $number = mysql_result($cycleRow, $i, "number");
  $start = mysql_result($cycleRow, $i, "start");
  $end = mysql_result($cycleRow, $i, "end");
  $germanTitle = mysql_result($cycleRow, $i, "german_title");
  $englishTitle = mysql_result($cycleRow, $i, "english_title");
  $summaryCount = cbCountSummariesForCycle($number);
  $percentage = round(($summaryCount / (1 + $end - $start)) * 100);

  echo '<tr><td align="center">'
  . $number
  . '</td><td>'
  . $start . '-'. $end
  . '</td><td>'
  . cbGenUrlCycle($i + 1, $germanTitle)
  . '</td><td>'
  . $englishTitle
  . '</td><td align="center">'
  . $summaryCount
  . '</td><td align="center">'
  . $percentage . ' %'
  . '</td>
  </tr>
  ';
}

echo '</table>';

echo '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">'
 . '</script>'
 . '<script type="text/javascript">'
 . '_uacct = "UA-238215-1";'
 . 'urchinTracker();'
 . '</script>'
;


include "../news.html";

?>
