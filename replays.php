<?php
header('Content-Type: text/html; charset=UTF-8');
$time_start = microtime(true);

$dir = 'C:\wampServer2\www\Replays\\';
$ext = array('w3g');
$maps = array();

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);

try
{
	foreach($iterator as $fileinfo)
		if($fileinfo->isFile() && in_array(substr($fileinfo, strrpos($fileinfo, '.') + 1), $ext))
			$maps[] = array('basename' => $fileinfo->getBasename());

	sort($maps);
}
catch(UnexpectedValueException $e)
{
	printf('Directory [%s] contained a directory we can not recurse into', $dir);
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="UTF-8" />
	<title>Maps List</title>

	<style>body{background-color:#FFF;color:#333;font:14px/20px Arial,sans-serif;}</style>
</head>



<body>

<h3><?php echo 'Total replays: ' , count($maps); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/Replays/"><b>View Archive</b></a></h3>
<?php
echo '<ul>';

$search = array('&', '\'');
$replace = array('&#x26;', '&#x27;');
$i=1;
foreach($maps as $map)
	echo '<li>'.$i++.'. <a href="/Replays/' , $map['basename'] , '">' , str_replace($search, $replace, $map['basename']) , '</a></li>';

echo '</ul>';

$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<p>Page generated in <?php echo round($time, 4); ?> seconds. Copyright &copy; 2013 by TheGenMaps.Tk</p>