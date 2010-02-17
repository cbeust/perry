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

echo "<table border='1'><tr><th>Number</th><th>Title</th><th>German</th><th>English</th></tr>";

sort($numbers);

global $DOWNLOAD_URL;
for ($i = 0; $i < count($numbers); $i++) {
  $n = $numbers[$i];
  $title = cbFindGermanTitle($n);
  echo "<tr>"
      . "<td>" . $n . "</td>"
      . "<td>" . $title . "</td>"
      . "<td>" . cbGenDownload($germanMap[$n], $GERMAN, "Download") . "</td>"
      . "<td>" . cbGenDownload($englishMap[$n], $ENGLISH, "Download") . "</td>"
      . "</tr>";
}

echo "</table>";

echo "</body></html>";

?>
