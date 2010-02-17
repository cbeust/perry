<?

include "_config.php";

$query = "SELECT * FROM pending";
$result = cbQuery($query);
$count = mysql_numrows($result);

cbHeader("Summaries waiting for approval", "Summaries waiting for approval",
    false /* no rss */);

<table border='1' width='80%'>
<tr>
<td>Id</td>
<td>Number</td>
<td>Author</td>
<td>Submitter's name</td>
<td>Submitter's email</td>
<td>Date</td>
<td>Summary</td>
</tr>
";

for ($i = 0; $i < $count; $i++) {
  $id = mysql_result($result, $i, "id");
  $number = mysql_result($result, $i, "number");
  $author = mysql_result($result, $i, "author");

  $approveUrl = $APPROVE_URL . '?id=' . $id;
  echo "<tr>"
    . "<td>" . $id . "</td>\n"
    . "<td><a href='" . $approveUrl . "'>" . $number . "</a></td>\n"
    . "<td>" . $author . "</td>\n"
    . "<td>" . mysql_result($result, $i, "english_title") . "</td>\n"
    . "<td>" . mysql_result($result, $i, "author_name") . "</td>\n"
    . "<td>" . mysql_result($result, $i, "author_email") . "</td>\n"
    . "<td>" . mysql_result($result, $i, "date_summary") . "</td>\n"
    . "<td>" . mysql_result($result, $i, "summary") . "</td>\n"
    . "</tr>"
    ;
}

echo "</table>";


?>
