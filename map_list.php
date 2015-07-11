<div id="content">
<?php
$PATH = 'C:\Program Files (x86)\Warcraft III\Maps\Download\\';
$dl = '/Wc3Map/';

function format_size($bytes) {
        $units = array("  B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        if ($bytes == 0)
                return 'n/a';
        else
                return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $units[$i];

        unset ($units);
}

if ($handle = opendir($PATH)) {
        $names = array();
        $files = array();
        $total_count = 0;
        $total_size = 0;

        while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..')
                        continue;

                $size = filesize($PATH.$file);
                $total_count++;
                $total_size += $size;
                $name = str_replace('_', ' ', $file);
                $names[] = strtolower($name);
                $files[] = array('file' => $file, 'name' => $name, 'size' => $size);
        }

        array_multisort($names, SORT_ASC, SORT_STRING, $files);

        unset($names);
?>
        <h1>Map list for DOWNLOAD</h1>
        <table>
<?php
        echo "          <th colspan=\"3\">Total count: $total_count&nbsp;&nbsp;-&nbsp;&nbsp;Total size: " . format_size($total_size) . "</th>\n";

        foreach ($files as $key => $val) {
                $ext = strtolower(substr($val['file'], -3));
                echo '          <tr><td><img src="/PHP/Pictures/' . $ext . '.gif" /></td><td class="text"><a href="' . $dl . $val['file'] . '">' . $val['name'] . '</a></td><td class="text">' . format_size($val['size']) . "</td></tr>\n";
        }
?>
                <tr><td class="copy" colspan="3">Copyright &copy; 2013 by TheGenMaps.Tk</td></tr>
        </table>
<?php
// Credits to GiveMeCookie2011
} else {
        echo '<div class="error">Error listing maps for GiveMeGames.</div>';
}
?>
</div>