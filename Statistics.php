<script type="text/javascript">
tday  =new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
tmonth=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");

function GetClock(){
d = new Date();
nday   = d.getDay();	
nmonth = d.getMonth();
ndate  = d.getDate();
	
nyear = d.getYear();
nhour  = d.getHours();
nmin   = d.getMinutes();
nsec   = d.getSeconds();

if(nyear<1000) nyear=nyear+1900;

     if(nhour ==  0) {ap = " AM";nhour = 12;} 
else if(nhour <= 11) {ap = " AM";} 
else if(nhour == 12) {ap = " PM";} 
else if(nhour >= 13) {ap = " PM";nhour -= 12;}

if(nmin <= 9) {nmin = "0" +nmin;}
if(nsec <= 9) {nsec = "0" +nsec;}

switch (ndate){
	case 1:
	case 21:
	case 31:
		ed = "st";
		break;
	case 2:
	case 22:
		ed = "nd";
		break;
	case 3:
	case 23:
		ed = "rd";
		break;
	default:
		ed = "th";
	}

document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+ed+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
setTimeout("GetClock()", 1000);
}
window.onload=GetClock;
</script>
<div id="clockbox"></div><br>
<link type="text/css" rel="stylesheet" href="http://wpaudioplayer.com/wp-content/themes/wpap/assets/syntax-highlighter/styles/SyntaxHighlighter.css"/>
There are
<table title="Gen bots statistics" class = tablestatistic cellspacing="0" cellpadding="2" border="1" >

<?php

$num_files = count(glob($_SERVER['DOCUMENT_ROOT'].'/Replays/*'));
$dir = 'C:\Program Files (x86)\Warcraft III\Maps\Download\\';
$ext = array('w3m', 'w3x');
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

mysql_connect("localhost", "root", "ultramarine");
mysql_select_db("sage");

	// show number of players participated in games
	function fetchdata( $t ) {
	$sql = "SELECT id FROM ". $t. " ORDER BY id DESC LIMIT 0,1";	
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		echo '<tr><td>'. $row[0]. '</td>';
		}
	}
	function rowcount( $t ) {
	$sql = "SELECT COUNT(*) FROM ". $t;	
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		echo '<tr><td>'. $row[0]. '</td>';
		}
	}
	
	fetchdata('gameplayers')?>
	<td><p class = Table>Players</p></td></tr>	
	<tr><td><?php echo count($maps) ?></td>
	<td><p class = Table><a href="maplist.php" target="_blank" title="click to download">Maps</a></p></td></tr>
	<?php fetchdata('downloads')?>
	<td><p class = Table>Download Times</p></td>	
	<?php fetchdata('games')?>
	<td><p class = Table><a href="gametrack.php" target="_blank" title="detail review">Games</a></p></td></tr>
	<tr><td><?php echo $num_files ?></td>
	<td><p class = Table><a href="replays.php" target="_blank" title="click to download">Replays</a></p></td></tr>
	<?php fetchdata('admins')?>
	<td><p class = Table>Admins</p></td></tr>	
	<?php fetchdata('safelist')?>
	<td><p class = Table>Safelisted Players</p></td></tr>
	<?php rowcount('bans')?>
	<td><p class = Table><a href="bans.php" target="_blank" title="detail review">Banned Players</a></p></td></tr>
	<?php fetchdata('users')?>
	<td><p class = Table><a href="playershistory.php" target="_blank" title="detail review">Users</a></p></td></tr>
</table>

<script type="text/javascript" src="http://wpaudioplayer.com/wp-content/themes/wpap/assets/syntax-highlighter/scripts/shCore.js"></script>
<script type="text/javascript" src="http://wpaudioplayer.com/wp-content/themes/wpap/assets/syntax-highlighter/scripts/shBrushXml.js"></script>
<script type="text/javascript">
//dp.SyntaxHighlighter.ClipboardSwf = "http://wpaudioplayer.com/wp-content/themes/wpap/assets/syntax-highlighter/scripts/clipboard.swf";
dp.SyntaxHighlighter.HighlightAll("code");
</script>