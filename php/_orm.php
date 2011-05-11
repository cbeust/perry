<?

include_once "_common.php";
include_once "_db.php";

function cbSummaryTable() {
  $lang = cbLang();
  return is_null($lang) ? "summaries" : "summaries_" . $lang;
}

function cbQuery($query) {
  global $host, $username, $password, $database;

  mysql_connect($host, $username, $password) or die ("Can't connect");
  @mysql_select_db($database) or die("Can't find database $database");
  $result = mysql_query($query);

  cbTrace($query);
  cbTrace("RESULT: $result");
  mysql_close();

  return $result;

}

function cbFindEnglishTitle($heft) {
  $query = "SELECT english_title FROM summaries WHERE number = $heft";
  $summariesRow = cbQuery($query);
  $result = null;
  if (mysql_numrows($summariesRow) > 0) {
    $result = mysql_result($summariesRow, 0, "english_title");
  }

  return $result;
}

function cbFindGermanTitle($heft) {
  $query = "SELECT title FROM hefte WHERE number = $heft";
  $summariesRow = cbQuery($query);
  $result = null;
  if (mysql_numrows($summariesRow) > 0) {
    $result = mysql_result($summariesRow, 0, "title");
  }

  return $result;
}

function cbFindColumnInSummaries($start, $end, $column) {
  $query = "SELECT * FROM summaries WHERE number >= $start && number <= $end";
  $res = cbQuery($query);
  $n = mysql_numrows($res);
  $result = null;
  for ($i = 0; $i < $n; $i++) {
    $title = mysql_result($res, $i, $column);
    $number = mysql_result($res, $i, "number");
    $result[$number] = $title;
  }

  return $result;
}

function cbHasSummary($number) {
  $query = "SELECT * FROM summaries WHERE number = $number";
  $result = cbQuery($query);
  return mysql_numrows($result);
}


function cbFindSummaryRow($number) {
  $table = cbSummaryTable();
//  $table = "summaries_fr";
  $query = "SELECT * FROM ." . $table . " WHERE number = $number";
  $result = cbQuery($query);
  $n = mysql_numrows($result);
  return $result;
}

function cbFindCyclesRow() {
  $query = "SELECT * FROM cycles";
  $result = cbQuery($query);
  return $result;
}

function cbFindLatestSummaryRow($limit) {
  $query = "select number, date from summaries where summary is not null order by date desc, time desc limit " . 0 . "," . $limit . ";";
  return cbQuery($query);
}

function cbCountSummariesForCycle($number) {
  $result = 0;

  $q1 = "select * from cycles where number = $number";
  $res1 = cbQuery($q1);
  $n = mysql_numrows($res1);
  if ($n > 0) {
    $start = mysql_result($res1, 0, "start");
    $end = mysql_result($res1, 0, "end");

    $q2 = "select count(*) from summaries where number >= $start && number <= $end and summary is not null && summary != ''";	
    $res2 = cbQuery($q2);
    $result = mysql_result($res2, 0, null);
  }

  return $result;
}

function cbCountSummaries() {
  $q2 = "select count(*) from summaries where summary is not null && summary != ''";
  $res2 = cbQuery($q2);
  $result = mysql_result($res2, 0, null);
  return $result;
}

function cbLatestSummary() {
  $q = "select * from summaries where date is not null order by date";
  $result = cbQuery($q);
  $number = mysql_result($result, 0, "number");
  $date = mysql_result($result, 0, "date");
  cbLog("Latest summary : $number $date");
}

function cbFindCycleRow($heft) {
  $query = "SELECT * FROM cycles WHERE start <= $heft && $heft <= end";
  $res = cbQuery($query);
  return $res;
}

function cbFindCycle($heft) {
  $res = cbFindCycleRow($heft);
  $n = mysql_numrows($res);
  $result = null;
  if ($n > 0) {
    $result = mysql_result($res, 0, "number");
  }

  return $result;
}


function cbFindSummary($heft) {
  $res = cbFindSummaryRow($heft);
  $n = mysql_numrows($res);
  $result = null;
  if ($n > 0) {
    $result = mysql_result($res, 0, "summary");
  }

  return $result;
}

function cbFindHeftRow($heft) {
  $query = "SELECT * FROM hefte WHERE number = $heft";
  return cbQuery($query);
}

function cbHeftCount() {
  $query = "SELECT COUNT(*) FROM hefte";
  $row = cbQuery($query);
  return mysql_result($row, 0, null);
}

function cbFindEnglishTitles($start, $end) {
  return cbFindColumnInSummaries($start, $end, "english_title");
}

function cbFindEnglishSummaries($start, $end) {
  return cbFindColumnInSummaries($start, $end, "summary");
}

function cbUpdateHeft($number, $germanTitle, $author)
{
  $existQuery = "SELECT * from hefte where number = $number";
  $heftRow = cbQuery($existQuery);
  $currentGermanTitle = mysql_result($heftRow, 0, "title");
  $query = "UPDATE hefte 
            SET title = '$germanTitle', author = '$author'
            WHERE number = '$number'";
  cbQuery($query);

}

function s($str) {
  return "'" . str_replace("'", "''", $str) . "'";
}  

function cbUpdateHeftAll($number, $title, $author, $published) {
  $existQuery = "SELECT * FROM hefte WHERE number = $number";
  $hefteRow = cbQuery($existQuery);
  $hefteRows = mysql_numrows($hefteRow);

  if ($hefteRows == 0) {
    $query = "INSERT INTO hefte VALUES ($number , '$title',
     '$author', '$published', '')";
  }
  else {
    $query = "UPDATE hefte
      SET number = $number,
      title = '$title',
      author = '$author',
      published = '$published'";
  }

  cbTrace($query);
  $result = cbQuery($query);

}

function cbUpdateSummaries($number, $germanTitle, $english_title, 
                           $author, $author_name, $author_email,
                           $date, $time, $summary, $published)
{

  cbUpdateHeftAll($number, $germanTitle, $author, $published);

  $table = cbSummaryTable();

  $existQuery = "SELECT * from " . $table . " where number = $number";
  $summariesRow = cbQuery($existQuery);
  $summariesRows = mysql_numrows($summariesRow);
  $english_title = s($english_title);
  $summary = s($summary);

  // Update summaries
  if ($summariesRows == 0) {
    $query = "INSERT INTO " . $table . "  VALUES ($number , $english_title,
     '$author_name', '$author_email', '$date', $summary, '$time')";
  }
  else {
    $query = "UPDATE " . $table . " 
    SET english_title = $english_title,
    author_email = '$author_email',
    author_name = '$author_name',
    date = '$date',
    summary = $summary,
    time = '$time'
    WHERE number = '$number'";
  }

  $result = cbQuery($query);
  cbLog($query);

  // Update cycle if needed
/*
  $cycleRow = cbFindCycleRow($number);
  $storedCycle = mysql_Result($cycleRow, 0, "german_title");
  if ($storedCycle != $cycle) {
    cbSetCycleGermanTitle($number, $cycle);
  }
*/

  // Update Twitter
    // Tweet
  cbTweetSummary($number, $english_title);
}

function cbSetCycleGermanTitle($number, $germanTitle) {
  $query = "UPDATE cycles
    SET german_title = '$germanTitle'
    WHERE $number >= start && $number <= end";

  cbQuery($query);
  
}

function cbInsertIntoPending($number, $germanTitle, $author,
  $published, $englishTitle, $authorName, $authorEmail,
  $dateSummary, $summary)
{
  $englishTitle = s($englishTitle);
  $summary = s($summary);
  $germanTitle = s($germanTitle);
  $query = "INSERT INTO pending VALUES (0, $number, $germanTitle,
    '$author', '$published', $englishTitle, '$authorName',
    '$authorEmail', '$dateSummary', $summary)";

  cbQuery($query);

  $query2 = "select max(id) from pending";
  $rs = cbQuery($query2);
  $result = mysql_fetch_row($rs);
  return $result[0];
}

function cbFindPendingRow($id) {
  $query = "SELECT * FROM pending WHERE id = $id";
  $result = cbQuery($query);

  return $result;
}

function cbRemoveFromPending($id) {
  $query = "DELETE FROM pending WHERE id = $id";
  cbQuery($query);
}

function cbGetAdminLevel($user) {
  global $MAX_LEVEL;
  $query = "SELECT level FROM users WHERE login = '" . $user . "'";
  $rows = cbQuery($query);
  $result = $MAX_LEVEL;
  if (mysql_numrows($rows) > 0) {
    $result = mysql_result($rows, 0, "level");
  }

  return $result;
}


// Return an array of:
// [0] = Full name
// [1] = Email address
function cbGetUserInfo($user) {
  if (cbIsKnown($user)) {
    $query = "SELECT name, email FROM users WHERE login = '" . $user . "'";
    $rows = cbQuery($query);
    if (mysql_numrows($rows) > 0) {
      return array(mysql_result($rows, 0, "name"),
          mysql_result($rows, 0, "email"));
    } else {
      return null;
    }
  } else {
    $name = $_GET["name"];
    $email = "";
    return array($name, $email);
  }
}


function cbIsKnown($user) {
  $query = "SELECT name, email FROM users WHERE login = '" . $user . "'";
  $rows = cbQuery($query);
  return (mysql_numrows($rows) > 0);
}



?>
