<?

include_once "_common.php";

$id = $_GET['id'];

$pendingRow = cbFindPendingRow($id);

$array = mysql_fetch_array($pendingRow);
$number = $array['number'];

cbUpdateHeftAll($number, $array['german_title'],
  $array['author'], $array['published']);

cbUpdateSummaries($number, $array['german_title'], $array['english_title'],
  $array['author'], $array['author_name'], $array['author_email'],
  $array['date_summary'], $array['time'],
  $array['summary'], $array['published']);

  cbRemoveFromPending($id);

  $redirectUrl = $DISPLAY_SUMMARY_URL . "?number=$number";
  cbRedirect($redirectUrl);


?>
