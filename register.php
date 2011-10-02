<?php

if ($_GET['smsregister'] == "true")
{
      easysms_ajax_register();
}

function easysms_ajax_register()
{

global $formCheck;
$formCheck = 0;

if (isset($_GET['first'])){
      if ($_GET['first'] == null){
      global $formCheck;
      $formCheck = 1;
      global $sms_formError;
      $sms_formError = "<p class='easysms_error'>Enter your first name.</p>";
      }
}

if (isset($_GET['last'])){
      if ($_GET['last'] == null){
      global $sms_formError;
      $sms_formError .= "<p class='easysms_error'>Enter your last name.</p>";
      global $formCheck;
      $formCheck = 1;
    }
}

if (isset($_GET['phone'])){
      if ($_GET['phone'] != null)
      {
      if (!ereg("^[0-9]{1,15}$", $_GET['phone']))
      {
      global $sms_formError;
      $sms_formError .= "<p class='easysms_error'>Enter numbers only.</p>";
      global $formCheck;
      $formCheck = 1;
      }
      $sql = "SELECT * FROM easysms WHERE phoneNumber = '".$_GET['phone']."'";
      $result = mysql_query($sql);
      $rows = mysql_num_rows($result);
      if($rows != 0)
      {
            global $sms_formError;
            $sms_formError .= "<p class='easysms_error'>That number is already registered.</p>";
            global $formCheck;
            $formCheck = 1;
      }
      }
      else
      {
            global $sms_formError;
            $sms_formError .= "<p class='easysms_error'>Enter a phone number.</p>";
            global $formCheck;
            $formCheck = 1;
      }
      
}

if (isset($_GET['carrier'])){
if ($_GET['carrier'] == "notselected"){ 
      global $sms_formError;
      $sms_formError .= "<p class='easysms_error'>Select a carrier.</p>";
      global $formCheck;
      $formCheck = 1;
      }
}

global $formCheck;
if($formCheck == 1)
{
    global $sms_formError;
    echo $sms_formError;
    global $sms_path_get;
    easysms_subscribe_form($_GET['first'], $_GET['last'], $_GET['phone'], $_GET['carrier']);
}
else
{
    $first = mysql_escape_string($_GET['first']);
    $last = mysql_escape_string($_GET['last']);
    $phone = mysql_escape_string($_GET['phone']);
    $carrier = mysql_escape_string($_GET['carrier']);
   
    $sql = "SELECT * FROM easysms_carriers WHERE ID = '".$carrier."'";
    $result = mysql_query($sql);
    $carrierfetch = mysql_fetch_array($result);
    $cellemail = $phone."@".$carrierfetch['carrierEmail'];
    $cellcode = substr(str_shuffle('0123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ'), 0, 4);
  
    $sql = "INSERT INTO easysms (firstName, lastName, phoneNumber, carrierEmail, randomCode, confirm, msgCount) VALUES ('".$first."', '".$last."', '".$phone."', '".$carrier."', '".$cellcode."', 'no', '0')";
    mysql_query($sql) or die ("Query failed: " . mysql_error());
    
    
    $from = "From: ". get_option('sms_from_name') . " <" . get_option('sms_from_email') . ">\r\n";
    $subject = get_option('sms_default_subject')." ";
    $message =  "Your verification code is:\n".$cellcode."\n(case-sensitive)";
	
    if(mail($cellemail, $subject, $message, $from))
    {
        $notify = get_option('sms_new_notify');
        if($notify == "yes")
        {
        $blog_name = get_bloginfo('name');
        $notify_email = get_option('sms_new_notify_email');
        if ($notify_email == null)
        {
                $nofity_email = get_bloginfo('admin_email');
        }
        $from = "From: ". $blog_name . " <" . $notify_email . ">\r\n";
        $message = $first." ".$last." has subscribed to ".get_bloginfo('name')." SMS updates.  Manage your SMS subscribers: ".get_bloginfo('url')."/wp-admin/admin.php?page=easySMS_subscribers";
        mail($notify_email, "New SMS Subscriber", $message, $from);
        }
        global $sms_path_get;	    
       	easysm_confirm_form($phone, $sms_path_get);
		
    }

    else
    {
        echo "<p class='easysms_error'>Something went wrong. Please contact the administrator.</a>";
    }

    
}
}
?>