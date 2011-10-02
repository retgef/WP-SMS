<?php

$cellcode = mysql_escape_string($_GET['cellcode']);
$phone = mysql_escape_string($_GET['phone']);


if($_GET['smsconfirm'] == 'true') {

	$sql = "SELECT * FROM easysms WHERE phoneNumber = '".$phone."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if ($cellcode == $row['randomCode']) {
        	$sql = "UPDATE `easysms` SET `confirm` = 'yes' WHERE `randomCode` = '".$cellcode."'";
		mysql_query($sql);
?>		<h2>Number Verified!</h2>
	        <p class='easysms_text'>Thanks for subscribing!</p>
                
<?		global $sms_path_get;
		easysms_subscribe_form('','','','');
	}
	elseif ($cellcode == null)
	{
		echo "<p class='easysms_error'>Please enter your code.</p>";
		easysm_confirm_form($phone);
	}
        else
	{
		echo "<p class='easysms_error'>Wrong Verification Code</p>";
		easysm_confirm_form($phone);
	}
}

if($_GET['smsresend'] == 'true') {
	
      	$sql = "SELECT * FROM easysms WHERE phoneNumber = '".$phone."' AND confirm = 'no'";
	$result = mysql_query($sql);
	$easysms_user = mysql_fetch_array($result, MYSQL_ASSOC);
	$num_rows = mysql_numrows($result);
	if ($num_rows != 0)
	{
	        $sql = "SELECT * FROM easysms_carriers WHERE ID = '".$easysms_user['carrierEmail']."'";
                $result = mysql_query($sql);
                $carrier = mysql_fetch_array($result);
		$to = $phone."@".$carrier['carrierEmail'];
	        $from = "From: ". get_option('sms_from_name') . " <" . get_option('sms_from_email') . ">\r\n";
	    	$subject = get_option('sms_default_subject')." ";
	    	$message =  "Your verification code is:\n".$easysms_user['randomCode']."\n(case-sensitive)";
	    
		  if(mail($to, $subject, $message, $from)){
			echo "<p class='easysms_text'>Verification Code Resent!</p>";
			easysm_confirm_form($phone);
		  }
	}
	elseif($phone == null)
	    {
		  echo "<p class='easysms_error'>Please enter a number!</p>";
		  easysm_retrieve_form();
	    }
	elseif (!ereg("^[0-9]{1,15}$", $phone))
		{
		  echo "<p class='easysms_error'>Numbers only please!</p>";
		  easysm_retrieve_form();
		}
	
			    
	elseif($num_rows == 0)
	    {
		  $sql = "SELECT * FROM easysms WHERE phoneNumber = '".$phone."' AND confirm = 'yes'";
		$result = mysql_query($sql);
		$easysms_user = mysql_fetch_array($result, MYSQL_ASSOC);
		$num_rows = mysql_numrows($result);
		if($num_rows > 0)
		{
		  echo "<p class='easysms_error'>That number is already confirmed!</p>";
		  easysm_retrieve_form();
		}
		if($num_rows == 0)
		{
		  echo "<p class='easysms_error'>That number has not been registered.</p>";
		  easysm_retrieve_form();
		}
		
	    }
	else
	 {
		  echo "<p class='easysms_error'>Something went wrong. Your verification code was not sent.</p>";
		  easysm_confirm_form($phone);

	 }
}

if($_GET['smschange'] == 'true')
{
      easysms_delete_user($phone);
      echo "<p class='easysms_error'>Number Deleted!</p>";
      easysms_subscribe_form('', '', '', '');
}

?>