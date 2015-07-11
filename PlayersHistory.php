<h3>Player History</h3>
<form action="usersearch.php" method="post">
     Search: <input type="text" name="term" />
    <input type="submit" name="summit" value="Submit" />
</form>
<?php
$time_start = microtime(true);
$conn = mysql_connect("localhost", "root", "ultra");
mysql_select_db("sage");
if(!$conn)
{
  die('Could not connect: ' . mysql_error());
}
$rec_limit = 18;
$sql = "SELECT COUNT(*) FROM (SELECT properusername FROM users GROUP BY properusername ORDER BY lastseen DESC) as SQ";

$result = mysql_query( $sql, $conn );
if(!$result)
{
  die('Could not get data: ' . mysql_error());
}
$row = mysql_fetch_array($result, MYSQL_NUM );
$rec_count = $row[0];
$endpage = round($row[0]/$rec_limit)-1;
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
$left_rec = $rec_count - ($page * $rec_limit);
	// Выполнение MySQL-запроса, для получения списка забаненных игроков.
	$result = mysql_query("SELECT properusername, lastseen FROM users GROUP BY properusername ORDER BY users.lastseen DESC LIMIT $offset, $rec_limit");

	// Рисование таблицы.
	?>
	<table title="Gen bots" class = tablestatistic cellspacing="0" cellpadding="2" border="1" >
	<tr><td><p class = Table>Name</p></td>
	<td><p class = Table>Lastseen</p></td></tr>
	<?php

	while($row = mysql_fetch_array($result))
	{
		echo '<tr><td>'. $row[0]. '</td><td>'. $row[1].  '</td></tr>';
	}
	?>
	</table>
<?php
$priortoendpage = $endpage - 1;
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
}

mysql_close($conn);
$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<p>Page generated in <?php echo round($time, 4); ?> seconds. Copyright &copy; 2013 by TheGenMaps.Tk</p>