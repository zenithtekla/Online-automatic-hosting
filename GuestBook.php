<?php
$username="root";
$password="ultra";
$database="sage";
if(isset($_POST['submit']))//check whether the form was submitted
{
	//collect the posted data
	$name=$_POST['name'];
	$server= isset($_POST['server']) ? $_POST['server'] : 'unknown';
	$location= isset($_POST['location']) ? $_POST['location'] : 'unknown';
	$gameID=$_POST['gameID'];
	$skypeID=$_POST['skypeID'];
	$yahooID=$_POST['yahooID'];
	$email=trim($_POST['email']);
	$comment=$_POST['comments'];
	$submit=$_POST['submit'];	
	// $adminsubmit=$_POST['adminsubmit'];
	// $att=$_POST['att'];
	$date = date("Y-m-d G:i:s");
	$ip= $_SERVER['REMOTE_ADDR'];

	//connect to the database
	$link=@mysql_connect("localhost",$username,$password) or die("Could not connect : ".mysql_error());
	
	//@ sign demystified :- the '@' tells the parser not to show any warnings 
	@mysql_select_db($database) or die( "Unable to select database");
	
	//build the query string
	$sql = "INSERT INTO gbook VALUES('','$name','$server','$location','$gameID','$skypeID','$yahooID','$email','$comment','$submit','','$date','$ip')";

	//execute the query
	@mysql_query($sql,$link) or die("Could not execute : ".mysql_error());
	header("Location: showgbook.php");
	$res = mysql_affected_rows();
	//show the user some message
	if($res > 0) {
		$ret_str="Your entry was successfully added.";
	} else {
		$ret_str = "Your entry was NOT successfully added.";
	} 
	echo $ret_str;
	mysql_close($link);
}
else //if there was no form data simply show the form
{ ?>
<form action="guestbook.php" method="post">
<b><span style="background: yellow; color:darkgreen">Registration/Feedback form</span></b><br>
<br>
<b>Name:</b>		<input title="Enter your name" type="text" name="name" required autofocus maxlength="15" size="15" autocomplete="on"><br>
<b>Location:</b>	<input title="Whereabout are you living?" type="text" name="location" maxlength="15" size="15" autocomplete="on"><br>
<b>Server:</b>		<select title="Choose what server you often play WC3" name="server" multiple size="4">			
			<option value="OMBU">3dgames.com.ar(Ombu)</option>
			<option value="US East">Azeroth(USEast)</option>
			<option value="BattleRo">Battle.lp.ro(LeaguePro)</option>
			<option value="XPAM">Eurobattle.net(XPAM)</option>
			<option value="W3EU">Europe.warcraft3.eu(W3EU)</option>
			<option value="Kalimdo">Kalimdo(ASIA)</option>
			<option value="Konco Indo">Konco.indogamers.us</option>
			<option value="Northrend">Northrend(Europe)</option>
			<option value="Others">Others</option>
			<option value="RevoIndo">RevoIndo</option>
			<option value="Garena">Garena</option>
			<option value="US West">Lodaeron(USWest)</option>
		</select><br>
<b>GamingID:</b> 	<input title="Enter your nickname that corresponds to the server you play" type="text" name="gameID" required maxlength="15" size="15" value="myPlayingNick" onfocus="if(this.value == this.defaultValue) this.value = ''" autocomplete="on"><br>
<b>Skype:</b> 		<input title="Enter your Skype here" type="text" name="skypeID" required maxlength="30" size="30" onfocus="if(this.value == this.defaultValue) this.value = ''" autocomplete="on"><br>
<b>Yahoo:</b> 		<input title="Enter your Yahoo here" type="text" name="yahooID" maxlength="30" size="30" value="myYahooID" onfocus="if(this.value == this.defaultValue) this.value = ''" autocomplete="on"><br>
<b>Email:</b> 		<input title="Enter your Email here" type="email" name="email" required maxlength="40" size="40" value ="email@abc.com" onfocus="if(this.value == this.defaultValue) this.value = ''" autocomplete="on"><br>
<br>
<TEXTAREA onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" NAME="comments" maxlength="512" COLS=40 ROWS=5 required >Say your Feedback or Message to support your registration:</TEXTAREA>
<br>
<input type="Submit" name ="submit" value ="Post"><input type="submit" formaction="guestbook.php" value="Post as admin" name ="adminsubmit">
<INPUT TYPE=RESET onClick="return confirm('Are you sure you want to reset the form?')">
</form>
I have an attachment to share with everyone
<form action="guestbook.php">
  <input type="file" name="att" accept=".w3g,.w3x,.w3t,.txt,.php,.cpp,.h,.csv,.htm,.html,.asp,.rtf,.doc,.docx,.xls,.xlsx,.pdf,.cfg,.ppt,.pptx,image/*">
  <input type="submit" value="Attach">
</form>
<b>Files allowed:</b>.w3g,.w3x,.w3t,.txt,.cpp,.h,.csv,.htm,.html,.php<br>
.asp,.rtf,.doc,.docx,.xls,.xlsx,.pdf,.cfg,.ppt,.pptx,image files
<br><br>
<b>©<a href=http://thegenmaps.tk/>TheGenMaps.TK</a></b>
<?php } //end of the if-else ?>