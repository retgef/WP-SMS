<?php


if($_GET['smsretrieve'] == 'true') {
      easysm_retrieve_form();
}

if($_GET['smsmanage'] == 'true') {
      global $sms_path_get;
      easysm_manage_form();
}

if($_GET['smshome'] == 'true') {
      easysms_subscribe_form("","","","");
}

if($_GET['smsunsubscribe'] == 'true') {
      
      $carrier = mysql_escape_string($_GET['carrier']);
      $phone = mysql_escape_string($_GET['phone']);
      
      global $formCheck;
      $formCheck = 0;
      
      if ($phone != null)
      {
	    if (!ereg("^[0-9]{1,15}$", $phone)){
	          global $unsubscribeError;
	          $unsubscribeError = "<p class='easysms_error'>Enter only numbers.</p>";
	          global $formCheck;
	          $formCheck = 1;
	    }
      }
      
      if ($phone == null)
      {
	    global $unsubscribeError;
	    $unsubscribeError = "<p class='easysms_error'>Please enter a phone number.</p>";
	    global $formCheck;
	    $formCheck = 1;
      }

      if ($carrier == "notselected"){ 
	    global $formCheck;
	    $formCheck = 1;
	    global $unsubscribeError;
	    $unsubscribeError .= "<p class='easysms_error'>Please choose a carrier</p>";
      }
      
      if ($formCheck == 0)
      {          
            $sql="SELECT * FROM easysms WHERE carrierEmail = '".$carrier."' AND phoneNumber = '".$phone."'";
	    $result = mysql_query($sql);
	    $rows = mysql_numrows($result);
	    if ($rows != 0)
	    {
	       $sql="DELETE FROM easysms WHERE phoneNumber='".$phone."'";
	        mysql_query($sql);
	        echo "<p class='easysms_text'>You have been successfully unsubscribed!</p>";
		global $sms_path_get;
		easysms_subscribe_form('','','','');
	    }
	    
	    else
            {
                 echo "<p class='easysms_error'>No users found!</p>";
                 easysm_manage_form();
            }
      }
      else
      {
	    global $unsubscribeError;
	    echo $unsubscribeError;
	    easysm_manage_form();
      }
}

