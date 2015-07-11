<?php
$time_start = microtime(true);    
$conn = mysql_connect("localhost", "root", "ultra") or die (mysql_error());
mysql_select_db ("sage");
$term = $_POST['term'];	
$rec_limit = 18;
// $offset = 0;
	$result = mysql_query("SELECT properusername, lastseen FROM users WHERE properusername LIKE '%$term%' GROUP BY properusername ORDER BY users.lastseen DESC");
	?>
	<table title="Gen bots" class = tablestatistic cellspacing="0" cellpadding="2" border="1" >
	<tr><td><p class = Table>Name</p></td>
	<td><p class = Table>Lastseen</p></td></tr>
	<?php
	$n = 0;
	while($row = mysql_fetch_array($result))
	{		
		$n++;
		echo '<tr><td>'. $row[0]. '</td><td>'. $row[1].  '</td></tr>';
	}
	
	if ($n==1)
		$str = '1 result';
	else if ($n>0)
		$str = "$n results";
		else $str ='No result';
	echo "Search for \"$term\" ... $str";
/*	$rec_count = $n;
	$endpage = round($n/$rec_limit)-1;
	if( isset($_GET{'page'} ) )
	{
	   $page = $_GET{'page'} + 1;
	   $offset = $rec_limit * $page ;
	}
	else
	{
	   $page = 0;
	   $offset = 0;
	}
	$left_rec = $rec_count - ($page * $rec_limit); */
	?>
	</table>
<?php
/* $priortoendpage = $endpage - 1;
$mid1 = round($endpage/2);
$mid2 = $mid1 - 1;
$mid3 = $mid1 + 1;
if( $page > 0 )
{
   $last = $page - 2;
   echo "(<a href=\"?page=-1\">1</a>  ";
   echo "<a href=\"?page=0\">2</a> ";
   echo "<a href=\"?page=$last\"><<</a> ";
   echo "<a href=\"?page=$mid2\">$mid2</a> ";
   echo "<a href=\"?page=$mid1\">$mid1</a> ";
   echo "<a href=\"?page=$mid3\">$mid3</a> ";
   if ($page < $endpage)
   echo "<a href=\"?page=$page\">>></a> ";
   echo "<a href=\"?page=$priortoendpage\">$priortoendpage</a> ";
   echo "<a href=\"?page=$endpage\">$endpage</a>)";   
}
else if( $page == 0 )
{
   echo "(<a href=\"?page=-1\">1</a> ";
   echo "<a href=\"?page=0\">2</a> ";
   echo "<a href=\"?page=$mid2\">$mid2</a> ";
   echo "<a href=\"?page=$mid1\">$mid1</a> ";
   echo "<a href=\"?page=$mid3\">$mid3</a> ";
   echo "<a href=\"?page=$page\">>></a> ";
   echo "<a href=\"?page=$priortoendpage\">$priortoendpage</a> ";   
   echo "<a href=\"?page=$endpage\">$endpage</a>)";   
} */

mysql_close($conn);
$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<p>Page generated in <?php echo round($time, 4); ?> seconds. Copyright &copy; 2013 by TheGenMaps.Tk</p>