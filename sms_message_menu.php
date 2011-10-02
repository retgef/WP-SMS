<?

if ($_POST['sms_preview'])
{
    if($_POST['sms_message'] == null)
    {
        unset($_POST['sms_preview']);
        global $sms_update;
        $sms_update = "<font color='red'><b>Message cannot be blank!</b></font>";
        sms_message_table();
    }
    else
    {
    sms_message_preview();
    }
}

elseif ($_POST['sms_confirm'])
{
    sms_message_confirm();
}

elseif ($_POST['sms_test'])
{
    sms_message_test();
    sms_message_preview();
}
elseif ($_POST['sms_edit'])
{
    sms_message_table();
}

else
{
    $sql = "SELECT ID from easysms where confirm = 'yes'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    if($num_rows != 0)
    {
	sms_message_table();
    }
    else
    {
	sms_message_error();
    }
}


function sms_message_table()
{ ?>


        <div class="wrap">

	<h2>Send SMS</h2>
        <? global $sms_update; echo $sms_update;  ?>
	<form name="post" method="post">

	<script language=JavaScript>
	<!--
	// Counter script from: http://www.plus2net.com/javascript_tutorial/textarea-counter.php
	function check_length(easysms)
	{
	maxLen = 140; 
	if (easysms.message.value.length >= maxLen) {
		var msg = "You have reached your maximum limit of characters allowed";
		alert(msg);
		easysms.message.value = easysms.message.value.substring(0, maxLen);
	}
	else
	{ 
		easysms.text_num.value = maxLen - easysms.message.value.length;}
	}
	//-->
	</script>
	 
        <p class='easysms_text'>Recipients:
	<select name="sms_recipients">
        <?
        if($_POST['sms_recipients'])
        {
            if($_POST['sms_recipients'] != 'all')
            {
                
                $sql = "SELECT * FROM easysms_groups WHERE ID = '".$_POST['sms_recipients']."'";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                echo "<option value=".$row['ID']." selected='selected'>".$row['groupName']."</option>";
            }
        }
        
        ?>
	<option value="all" <?  if($_POST['sms_recipients'] != 'all') { echo ''; } elseif($_POST['sms_recipients'] == 'all') { echo 'selected=selected'; } else { echo 'selected=selected'; }  ?>>All Subscribers</option>
        <?
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM easysms_groups ORDER BY groupName ASC");
        foreach($result as $results)
        {
	    $sql = "SELECT * FROM easysms_group_users WHERE group_id = '".$results->ID."'";
	    $result = mysql_query($sql);
	    $num_rows = mysql_num_rows($result);
	    if($num_rows != null)
	    {
	    ?>
            
            <option value="<? echo $results->ID ?>"><? echo $results->groupName ?></option>
            
        <? }} ?>
        </select></p>
							
	<h3>Subject</h3>
             
        <input class='easysms'  type="text" name="sms_subject" size="30" value="<? echo str_replace("\\", "", $_POST['sms_subject']); ?>" id="title" /> <p class='easysms_text'>If left blank, default subject is: <a href=admin.php?page=easySMS_settings><? echo get_option('sms_default_subject') ?></a></p>
	
	<h3>Message</h3>
        
        <textarea id="message" rows='3' cols='40' id='content' onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); class='' name="sms_message"><? echo str_replace("\\", "", $_POST['sms_message']); ?></textarea>
     	
        <p class='easysms_text'><label>Characters Left:</label>
	<input class='easysms'  size=3 value=140 name=text_num disabled="disabled"></p>
		
	<input class='easysms'  name="sms_preview" type="submit" class="button-primary" value="Preview" />
        
	</form>

	</div>
	
<?
}


function sms_message_preview()
{
    $subject = str_replace("\\", "", $_POST['sms_subject']);
    if($subject == null)
    {
        $subject = get_option('sms_default_subject');
    }
    $message = str_replace("\\", "", $_POST['sms_message']);
    
    if($_POST['sms_recipients'] != 'all')
    {
    $sql = "SELECT * FROM easysms_group_users WHERE group_id = '".$_POST['sms_recipients']."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $num_rows = mysql_num_rows($result);
    
    $sql = "SELECT * FROM easysms_groups WHERE ID = '".$_POST['sms_recipients']."'";
    $result = mysql_query($sql);
    $row1 = mysql_fetch_array($result);
    
    $groupMsg = $row1['groupName']." - ".$num_rows." Subscriber(s)";
    }
    else
    {
    $sql = "SELECT * FROM easysms WHERE confirm = 'yes'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $num_rows = mysql_num_rows($result);
    $groupMsg = "All Subscribers - ".$num_rows." Subscriber(s)";
    }
?>
    <div class="wrap">
    <form method="post">
    <input class='easysms'  type="hidden" name="sms_subject" value="<? echo $subject ?>">
    <input class='easysms'  type="hidden" name="sms_message" value="<? echo $message ?>">
    <input class='easysms'  type="hidden" name="sms_recipients" value="<? echo $_POST['sms_recipients'] ?>">
        
    <h2>Preview Message</h2>
    
    <? global $sms_test; echo $sms_test; ?>    
    
    <h3>Recipients:</<h3>
    <p class='easysms_text'><span style="background-color:#F2F5A9; padding:5px;"><? echo $groupMsg ?></span></p>
      
    
    
    <h3>Subject:</<h3>
    <p class='easysms_text'><span style="background-color:#E0ECF8; padding:5px;"><? echo $subject ?></span></p>
      
    <h3>Message:</<h3>
    <p class='easysms_text'><span style="background-color:#E0ECF8; padding:5px;"><? echo $message ?></span></p>
    
    
    <p class='easysms_text'><input class='easysms'  name="sms_edit" type="submit" class="button-primary" value="Edit Message" /><input class='easysms'  name="sms_confirm" type="submit" class="button-primary" value="Send Message" /></p>
    <br />
    
    <p class='easysms_text'><span style="border:1px solid #606060; padding:25px; background-color:#E0ECF8">   
    Send test SMS to my phone:
    <input type="text" value="Numbers Only" name="sms_test_number" length="40"> @ 
    <select name="sms_test_carrier">
    <option value="not-selected" selected="selected">Select Carrier</option>
<?
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms_carriers ORDER BY carrierName ASC");
    foreach($result as $results)
    { ?>
        <option value="<? echo $results->carrierEmail ?>"><? echo $results->carrierName ?></option>
<?  } ?>
    </select>
    <input name="sms_test" type="submit" class="button-primary" value="Send Test" /></span></p>
   
   
    </form>    
    </div>
<?
    
}

function sms_message_test()
{
    global $formCheck;
    $formCheck = 0;
    $subject = str_replace("\\", "", $_POST['sms_subject']);
    $message = str_replace("\\", "", $_POST['sms_message']);
    
    if($_POST['sms_test_number'] == null)
    {
        global $sms_test;
        $sms_test = "<font color='red'><b>Please enter a phone number.</b></font><br />";
        global $formCheck;
        $formCheck = 1;
    }
    
    if($_POST['sms_test_carrier'] == 'not-selected')
    {
        global $sms_test;
        $sms_test = $sms_test."<font color='red'><b>Please select a carrier.</b></font><br />";
        global $formCheck;
        $formCheck = 1;
    }
    
    if($_POST['sms_test_number'] != null){
        if (!ereg("^[0-9]{1,15}$", $_POST['sms_test_number']))
        {
            global $sms_test;
            $sms_test = $sms_test."<font color='red'><b>Enter only numbers.</b></font>";
            global $formCheck;
            $formCheck = 1;
        }
    }
    
    if($formCheck == 0)
    {
        $cellemail = $_POST['sms_test_number']."@".$_POST['sms_test_carrier'];
        $from = "From: ". get_option('sms_from_name') . " <" . get_option('sms_from_email') . ">\r\n";	
    
        if (mail($cellemail, $subject, $message, $from))
        {
            global $sms_test;
            $sms_test = "<font color='red'><b>Message sent!</b></font>";
        }
        else
        {
            global $sms_test;
            $sms_test = "<font color='red'><b>Something went wrong!  Message was not sent.</b></font>";
        }
    }
    
    
    
}


function sms_message_confirm()
{
    $from = "From: ". get_option('sms_from_name') . " <" . get_option('sms_from_email') . ">\r\n";
    $subject = str_replace("\\", "", $_POST['sms_subject']);
    $message = str_replace("\\", "", $_POST['sms_message']);
    global $formCheck;
    $formCheck = 0;
    
    if($_POST['sms_recipients'] == 'all')
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM easysms WHERE confirm = 'yes'");
        foreach($result as $results)
        {
            $sql = "SELECT * FROM easysms_carriers where ID = '".$results->carrierEmail."'";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $to = $results->phoneNumber."@".$row['carrierEmail'];
            if (mail($to, $subject, $message, $from))
            {
                global $sms_update;
                $sms_update = "<font color='red'><b>Message sent!</b></font>";
                global $formCheck;
                $formCheck = 0;
                $msgCount = $results->msgCount + 1;
                $sql = "UPDATE easysms SET msgCount = '".$msgCount."' WHERE ID = '".$results->ID."'";
                mysql_query($sql);
            }
            else
            {
                global $sms_update;
                $sms_update = "<font color='red'><b>Something went wrong!  Message was not sent.</b></font>";
                global $formCheck;
                $formCheck = 1;
            }
        }
    }
    
    if($_POST['sms_recipients'] != 'all')
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM easysms_group_users WHERE group_id = '".$_POST['sms_recipients']."'");
        foreach($result as $results)
        {
            $sql = "SELECT * FROM easysms where ID = '".$results->user_id."'";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            
            $sql1 = "SELECT * FROM easysms_carriers where ID = '".$row['carrierEmail']."'";
            $result1 = mysql_query($sql1);
            $row1 = mysql_fetch_array($result1);
            
            
            $to = $row['phoneNumber']."@".$row1['carrierEmail'];
            if (mail($to, $subject, $message, $from))
            {
                global $sms_update;
                $sms_update = "<font color='red'><b>Message sent!</b></font>";
                global $formCheck;
                $formCheck = 0;
                $msgCount = $row['msgCount'] + 1;
                $sql = "UPDATE easysms SET msgCount = '".$msgCount."' WHERE ID = '".$row['ID']."'";
                mysql_query($sql);
            }
            else
            {
                global $sms_update;
                $sms_update = "<font color='red'><b>Something went wrong!  Message was not sent.</b></font>";
                global $formCheck;
                $formCheck = 1;
            }
        }
    }
    
    if($formCheck == 0)
    { ?>
    
    <div class="wrap">
    <h2>Message Sent!</h2>
    <? global $sms_update; echo $sms_update; ?>
    <h3><a href=admin.php?page=easySMS_send>Back To Message Form</a></h3>
    </div>
       
<?  }
    
    if($formCheck == 1)
    {
        sms_message_preview();
    }
    
}

function sms_message_error()
{ ?>
    
    <div class="wrap">
    <h2>EasySMS</h2>
    <p class='easysms_text'>Before you can send a message, you must first have at least one subscriber.</p>
    </div>
    
    
<? }


?>