<?

include_once "_config.php";
include_once "_orm.php";

echo
     '<?xml version="1.0" encoding="iso-8859-1" ?>' . "\n"
   . '<rss version="2.0"' . "\n"
   . '  xmlns:dc="http://purl.org/dc/elements/1.1/"' . "\n"
   . '  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"' . "\n"
   . '  xmlns:admin="http://webns.net/mvcb/"' . "\n"
   . '  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"' . "\n"
   . ">\n"
   . "  <channel>\n"
   . "    <title>Perry Rhodan Summaries</title>\n"
   . "    <link>" . $MAIN_URL . "</link>\n"
   . "    <description>Summaries of Perry Rhodan cycles in English</description>\n"
   . "    <dc:language>en-us</dc:language>\n"
   . "    <dc:creator>cedric@beust.com</dc:creator>\n"
   . "    <dc:date>" . date('d/m/y H:i:s') . "</dc:date>\n"
   . "    <sy:updatePeriod>daily</sy:updatePeriod>\n"
   . "    <sy:updateFrequency>1</sy:updateFrequency>\n"
;

$maxItems = 10;

$summaryRow = cbFindLatestSummaryRow($maxItems);

for ($i = 0; $i < $maxItems; $i++) {
  $heft = mysql_result($summaryRow, $i, "number");
  $date = mysql_result($summaryRow, $i, "date");
  $germanTitle = cbFindGermanTitle($heft);
  $englishTitle = cbFindEnglishTitle($heft);
  $content = $heft . ": " . $englishTitle;

  echo "    <item>\n"
    .  "      <title>" . $content . "</title>\n"
    .  "      <link>" . $DISPLAY_SUMMARY_URL . "?number=" . $heft . "</link>\n"
    .  "      <description>" . $germanTitle . "</description>\n"
    .  "      <dc:date>" . $date . "</dc:date>\n"
    . "    </item>\n";
  
}

echo "  </channel>\n"
  .  "</rss>\n";

?>
