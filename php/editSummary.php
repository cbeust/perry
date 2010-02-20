<?

include_once "_common.php";

$number=$_GET['number'];
$query = "SELECT * FROM hefte WHERE number = $number";
$hefteRow = cbQuery($query);
$numRows = mysql_numrows($hefteRow);

if (isset($_COOKIE["user"])) {
  $user = $_COOKIE["user"];
  cbTrace("FOUND COOKIE FOR USER: $user");
}

if (! isset($user)) {
  $user = "";
}

if (isset($_COOKIE["name"])) {
  $name = $_COOKIE["name"];
  cbTrace("FOUND COOKIE FOR USER: $name");
}

if (! isset($name)) { $name = ""; }

cbHeader("Perry Rhodan:  Type in your summary", "", false /* no rss */);

if ($numRows > 0) {
  $germanTitle = mysql_result($hefteRow, 0, "title");
  $author = mysql_result($hefteRow, 0, "author");
}
else {
  $germanTitle = "";
  $author = "";
}

  $cycleRow = cbFindCycleRow($number);
  $cycle = mysql_result($cycleRow, 0, "german_title");
  $summaryRow = cbFindSummaryRow($number);
  if (mysql_numrows($summaryRow) > 0) {
    $summary = mysql_result($summaryRow, 0, "summary");
    $date = mysql_result($summaryRow, 0, "date");
    $time = mysql_result($summaryRow, 0, "time");
  }
  if (! isset($date)) {
    list($date, $time) = split(" ", date("Y-m-d H:s"));
  }

  $englishTitle = cbFindEnglishTitle($number);

  echo '

  <form action="'
  . $SUBMIT_SUMMARY_URL
  . '" method="post">'
  . '<h3><p align="center">Perry Rhodan #'
  . $number
  . '<br>Cycle: 
  <input type="text" cols="80" name="cycle" value="'
  . $cycle
  . '"</h3></p>';


  echo '
  <p>

  <table>

  <tr>

  <td>
  Title:
  </td>
  <td>
  <input type="text" size="60" name="germanTitle" value="'
  . $germanTitle
  . '"/>
  </td>
  </tr>

  <tr>
  <td>
  Author:
  </td>
  <td>
  <input type="text" size="60" name="author" value="'
  . $author
  . '"/>
  </td>
  </tr>

  <tr>
  <td>
  Date:
  </td>
  <td>
  <input type="text" size="60" name="date" value="'
  . $date
  . '"/>
  </td>
  </tr>

  <tr>
  <td>
  English title:
  </td>
  <td>
  <input type="text" size="60" name="englishTitle" value="'

. $englishTitle

. '"/>
  </td>
  </tr>
</table>
  
<p>

  Your summary:<br>
  <font size="-1"><em>
Regular HTML, don\'t forget &lt;p&gt; between each paragraph.
</em>
  </font>
  <p>
  <textarea rows="15" cols="80" name="summary">'
. $summary 
. '</textarea>
  
  <input type="hidden" name="heftNumber" value="'
. $number  
. '" />
  <input type="hidden" name="time" value="'
. $time
. '" />
  <input type="hidden" name="user" value="'
. $user
. '" />



  <p>

<table>
<tr>
<td>
  Your name (optional):
</td>
<td>
  <input type="text" size="60" name="name" value="'
. $name
. '"/>
</td>
</tr>

<tr>
<td>  
  Your email address (optional):
</td>
<td>
  <input type="text" size="60" name="email" />
  <br>
  <font size="-1"><em>Your email address will not appear on the Web site and 
  I will only use it to let you know when your summary becomes available.
  </em>
  </font>
</td>
</tr>

<tr>
<td>
  User name (administrator only):
</td>
<td>
  <input type="text" size="60" name="user" value="' . $user . '"/>
</td>
</tr>

<tr align="center">
<td colspan="2">
<br>
'
;

if (cbIsAdmin($user)) {
  echo '<em><font size="-1">Admin mode ('. $user . ':' . cbIsAdmin($user) . ')</font></em>';
}

echo '<br><INPUT TYPE=SUBMIT VALUE="Submit">
</td>
</tr>
</table>
  
  </form>
  
';

?>