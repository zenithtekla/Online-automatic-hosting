<?php
function hrefCallback($p) {  
  $name = htmlspecialchars($p[0]);
  $href = !empty($p[1])? $name : "http://$name";
  return "<a href=\"$href\">$name</a>";
}
function hrefActivate($text) {
  return preg_replace_callback(
    '{
      (?:
        (\w+://)          
        |                 
        www\.             
      )
      [\w-]+(\.[\w-]+)*   
      \S*                 
      (?:                 
          (?<! [[:punct:]] )  
        | (?<= [-/&+*]     )
      )
    }xis',
    "hrefCallback",
    $text
  );
}  

$dbUser = "root";
$dbPass = "ultramarine";
$db_site = "sage";

if (session_id() == "") session_start();
mysql_connect("localhost",$dbUser,$dbPass);
mysql_select_db($db_site);

if (isset($_POST['send'])) {
	if ( empty($_POST['name']) || empty($_POST['text']))
		echo "Name or Text Invalid";
	$s_Name = $_POST['name'];
	$s_Text = $_POST['text'];
	$s_Text = hrefActivate($s_Text);
	$s_IP = $_SERVER['REMOTE_ADDR'];
	$b_NewMessage = true;
	$s_Date = date("Y-m-d G:i:s");
}

try
{
	if (isset($_POST['action'])) {
		if ( isset($_POST['id']) ) $t_id = $_POST['id'];
		echo "Invalid ID";
		$t_query = "SELECT sessionid, deleted, edited_newid FROM messagelog WHERE id =". $t_id;
		$result = $db_site->query($t_query);
		$row = $result->fetch();
		if ($row[0] == session_id() && $row[1] == 0 && $row[2] == 0) {
			$t_query = "UPDATE messagelog SET deleted=1 WHERE id=". $t_id;
			$db_site->query($t_query);
		}
	}
}
catch(PDOException $e)
{
	PDO_CatchError($e);
}
?>
<form name = 'myfrm' method="POST">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="id">
</form>
<script>
function Del(val) {
	if (confirm("Are you sure this text should be deleted?")) {
		var frm = document.myfrm;
		frm.id.value = val;
		frm.submit();
	}
}
</script>

<?php
try
{
	if (isset($b_NewMessage)) {
		$s_Name = mysql_real_escape_string($s_Name);
		$s_Text = mysql_real_escape_string($s_Text);
		$t_query = "insert into messagelog (name, text, date, ip, sessionid) values ('$s_Name', '$s_Text', '$s_Date', '$s_IP', '". session_id(). "')";
		$db_site->query($t_query);
	}

	$result = $db_site->query("select name, text, date, sessionid, id, deleted, edited_newid from messagelog");
	PDO_AddError($db_site);
?>
<table>

<?php
	while($row = $result->fetch()) {
		if ($row[5]==1) continue;
		if ($row[6]<>0) continue;
		if ($row[3] == session_id() ) {
?>

	<tr><td><font color=yellow><b><?=$row[0]?></b></font>: <?=$row[1]?>
	<td style="width: 140px;" valign="top"><?=$row[2]?></td>
	<td valign="top"><a onclick='Del(<?=$row[4]?>)'>X</a></td></tr>
	
<?php
		}
		else {
?>
	<tr><td><font color=yellow><b><?=$row[0]?></b></font>: <?=$row[1]?>
	<td style="width: 140px;" valign="top"><?=$row[2]?></td>
	<td></td></tr>
<?php
		}
	}
?>

</table>
<?php
}
catch(PDOException $e)
{
	PDO_CatchError($e);
}
?>
<form method="POST">
	<div class="fid"><input type="text" 
		onfocus="if (value =="Name") { value = ''}" 
		onBlur ="if (value == '') { value ="Name"}" 
		class="if" name="name" value="Name" maxlength=20>
	</div>
	<div class="fid"><textarea name="text"
		onfocus="if (value =="Message") { value = ''}" 
		onBlur ="if (value == '') { value ="Message"}"
		class="if" rows="6" >Message</textarea></div>
	<input style="text-align:center;" type="submit" name = 'send' value="ok">
</form>