<?

include_once "_common.php";

$title = "List of Hefte";

echo cbHeader($title, $title, false /* no rss */);

$user = $_COOKIE['user'];
if (!cbCanDownload($user)) exit;

$numbers = Array();
$germanFiles = cbGetGermanFiles();
$englishFiles = cbGetEnglishFiles();

$files = array($germanFiles, $englishFiles);

for ($i = 0; $i < count($germanFiles); $i = $i + 1) {
  preg_match("{(\d+)}", $germanFiles[$i], $array);
  $n = $array[1];
  array_push($numbers, $n);
  $index = strrpos($germanFiles[$i], "/") + 1;
  $germanMap[$n] = substr($germanFiles[$i], $index);
}

for ($i = 0; $i < count($englishFiles); $i = $i + 1) {
  preg_match("{(\d+)}", $englishFiles[$i], $array);
  $n = $array[1];
  if (! in_array($n, $numbers)) {
    array_push($numbers, $n);
  }
  $index = strrpos($englishFiles[$i], "/") + 1;
  $englishMap[$n] = substr($englishFiles[$i], $index);
}

$newTable = "<table style='font-size: 80%;' border='1'><tr><th>Number</th><th>Download</th></tr>";

echo "<table><tr valign='top'><td>";
echo $newTable;

sort($numbers);

global $DOWNLOAD_URL;
for ($i = 0; $i < count($numbers); $i++) {
  $n = $numbers[$i];
  if ($i != 0 && $i % 50 == 0) {
    echo "</table></td>"
      . "<td>" . $newTable;
  }
  echo "<tr>"
      . "<td>" . $n . "</td>"
      . "<td>" . cbGenDownload($germanMap[$n], $GERMAN, "Ge") . " "
      . cbGenDownload($englishMap[$n], $ENGLISH, "En") . "</td>"
      . "</tr>";
}

echo "</table>";

echo "</body></html>";

?>
