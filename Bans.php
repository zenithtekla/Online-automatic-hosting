<?php
$time_start = microtime(true);
mysql_connect("localhost", "root", "ultra");
mysql_select_db("sage");
mysql_query("DELETE FROM textchatlog WHERE time < now()");
$sql = '
		SELECT 
            `name`,
            `admin`,
            `reason`,
            `gamecount`,
            `expiredate`
        FROM 
            `bans`
		WHERE
			`warn` = 0
    ';
	// check for sort field
	$sort_by = isset($_GET['s']) ? $_GET['s'] : false;
	// validate the sort field (avoid Bobby Tables!) and provide default
	switch ($sort_by) {
        case 'name':
        case 'admin':
        case 'reason':
        case 'gamecount':
        case 'expiredate':
            break;
        default:
            $sort_by = 'expiredate';
    }
	
	$sql .= ' ORDER BY '.$sort_by.' ';
	
	// get the direction, or use the default
    $direction = isset($_GET['d']) ? $_GET['d'] : false;
    if ($direction != 'ASC' && $direction != 'DESC')
        $direction = 'DESC';
    $sql .= $direction;
	
	// execute query, get results
    $res = mysql_query($sql);
    $results = array();
    if ($res) {
        while ($r = mysql_fetch_assoc($res)) {
            $results[] = $r;
        }
    }
	
	// used in table heading to indicate sort direciton
	$sort_arrow = ($direction == 'ASC' ? '<img src="/PHP/Pictures/arrows/up_arrow.png" />' : '<img src="/PHP/Pictures/arrows/down_arrow.png" />');
	
	// used to build urls to reverse the current sort direction
	$reverse_direction = ($direction == 'DESC' ? 'ASC' : 'DESC');
?>

<table title="Gen bots" cellspacing="0" cellpadding="2">
    <thead>
        <th scope="col" class="<?php echo $sort_by == 'id' ? 'sortColumn' : ''; ?>">
            <a href="bans.php?s=name&d=<?php echo $reverse_direction; ?>">Name</a>
            <?php echo $sort_by == 'name' ? $sort_arrow : ''; ?>
        </th>
        <th scope="col" class="<?php echo $sort_by == 'id' ? 'sortColumn' : ''; ?>">
            <a href="bans.php?s=admin&d=<?php echo $reverse_direction; ?>">Admin</a>
            <?php echo $sort_by == 'admin' ? $sort_arrow : '';  ?>
        </th>
		<th scope="col" class="<?php echo $sort_by == 'id' ? 'sortColumn' : ''; ?>">
            <a href="bans.php?s=reason&d=<?php echo $reverse_direction; ?>">Reason</a>
            <?php echo $sort_by == 'reason' ? $sort_arrow : '';  ?>
        </th>
		<th scope="col" class="<?php echo $sort_by == 'id' ? 'sortColumn' : ''; ?>">
            <a href="bans.php?s=gamecount&d=<?php echo $reverse_direction; ?>">GameCount</a>
            <?php echo $sort_by == 'gamecount' ? $sort_arrow : '';  ?>
        </th>
        <th scope="col" class="<?php echo $sort_by == 'id' ? 'sortColumn' : ''; ?>">
            <a href="bans.php?s=expiredate&d=<?php echo $reverse_direction; ?>">ExpireDate</a>
            <?php echo $sort_by == 'expiredate' ? $sort_arrow : '';  ?>
        </th>
    </thead>
    <tbody>
        <?php	
			if (count($results) > 0) {
                foreach ($results as $r) {
                    print '<tr>';
                    print '<th scope="row">'.$r['name'].'</th>';
                    print '<td>'.$r['admin'].'</td>';
                    print '<td>'.$r['reason'].'</td>';
                    print '<td>'.$r['gamecount'].'</td>';
                    print '<td>'.$r['expiredate'].'</td>';
                    print '</tr>';
                }
            } else {
                print '<tr><td colspan=3>No results found</td></tr>';
            }
        ?>  
    </tbody>
</table>
<?php
$time_end = microtime(true);
$time = $time_end - $time_start;
?>
<p>Page generated in <?php echo round($time, 4); ?> seconds. Copyright &copy; 2013 by TheGenMaps.Tk</p>