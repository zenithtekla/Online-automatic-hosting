<?php
$time_start = microtime(true);
mysql_connect("localhost", "root", "ultra");
mysql_select_db("sage");

	// Выполнение MySQL-запроса, для получения списка забаненных игроков.
	$result = mysql_query("SELECT name, sum(num_games) AS Field2, time_active FROM gametrack GROUP BY name ORDER BY Field2 DESC");
	// Рисование таблицы.
	?>
	<table title="Gen bots" class = tablestatistic cellspacing="0" cellpadding="2" border="1" >
	<tr><td><p class = Table>Name</p></td>
	<td><p class = Table>No.Games</p></td>
	<td><p class = Table>Time_Active</p></td></tr>
	<?php

	while($row = mysql_fetch_array($result))
	{
		echo '<tr><td>'. $row[0]. '</td><td>'. $row[1]. '</td><td>'. $row[2]. '</td></tr>';
	}
	?>
	</table>
<?php
$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<p>Page generated in <?php echo round($time, 4); ?> seconds. Copyright &copy; 2013 by TheGenMaps.Tk</p>