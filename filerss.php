<?php

// Alerts folder
$itemDir = "alerts";
// RSS URL
$site = "http://archivel.fr/";
// Max number of item for the feed
$feedSize = 20;

if (!is_dir($itemDir) || !is_readable($itemDir)) {
    header("HTTP/1.0 500 Internal Server Error");
    exit();
}

// RSS header
header("Content-Type: application/rss+xml; charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel>\n";
echo "  <title>".ucwords($itemDir)."</title>\n";
echo "  <link>$site</link>\n";
echo "  <atom:link href=\"".getCurrentUrl()."\" rel=\"self\" type=\"application/rss+xml\"/>\n";
echo "  <description>Feed of lasts system alerts.</description>\n";
$items = array();
foreach (scandir($itemDir) as $itemFile) {
    $itemPath = $itemDir.'/'.$itemFile;
    if (!is_file($itemPath) || !is_readable($itemPath)) continue;
    $items[] = $itemPath;
}
usort($items, "mtime_cmp");
$lastDate = max(0, filemtime($items[0]));
echo "  <lastBuildDate>".date("r", $lastDate)."</lastBuildDate>\n";
echo "  <pubDate>".date("r", $lastDate)."</pubDate>\n";

// RSS items
foreach ($items as $i => $item) {
    if ($i >= $feedSize) break;
    echo "\n  <!-- item: '$item' -->\n";
    echo "  <item>\n";
    echo "    <title>".basename($item)."</title>\n";
    echo "    <link>$site$item</link>\n";
    echo "    <guid>$site$item</guid>\n";
    echo "    <pubDate>".date("r", filemtime($item))."</pubDate>\n";
    echo "    <description><![CDATA[";
    $lines = file($item);
    foreach ($lines as $line) {
        echo "$line";
    }
    echo "]]></description>\n";
    echo "  </item>\n";
}
echo '</channel></rss>';

function mtime_cmp($a, $b) {
    if ($a == $b) return 0;
    $a_mtime = filemtime($a);
    $b_mtime = filemtime($b);
    return $b_mtime - $a_mtime;
}

function getCurrentUrl() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

?>
