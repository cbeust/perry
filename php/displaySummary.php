<?

include_once "_common.php";
include "_summary.php";

$start = $_GET['start'];
$end = $_GET['end'];
$number = $_GET['number'];

if (is_null($start) || is_null($end)) {
  $start = $number;
  $end = $number;
  $numbers = $number;
  $withNextAndPrevious = 1;
} else {
  $numbers = $start . ' - ' . $end;
  $withNextAndPrevious = 0;
}

cbHeader("Perry Rhodan #" . $numbers, "", false /* no rss */);

for ($n = $start; $n <= $end; $n = $n + 1) {
  cbDisplaySummary($n);
  cbDisplayFooter($n, $withNextAndPrevious);
}

?>
