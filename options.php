<?php



function easysms_options()
{
	easysms_update_options();
	$sms_from = get_option('sms_from_email');
	$sms_name = get_option('sms_from_name');
	$sms_subject = get_option('sms_default_subject');
	$sms_publish = get_option('sms_publish_post');
	$sms_notify = get_option('sms_new_notify');
	$sms_new_notify_email = get_option('sms_new_notify_email');
	if($sms_publish == 'yes') {$pub_yes = 'selected';}
	if($sms_publish == 'no') {$pub_no = 'selected';}
	if($sms_new_notify == 'yes') {$notify_yes = 'selected';}
	if($sms_new_notify == 'no') {$notify_no = 'selected';}
	if(isset($_REQUEST['sms_publish_post'])){}
?>
	<div class="wrap">
	<h2>EasySMS Settings</h2>
	<? global $update_options; echo $update_options; ?>
	<table class="form-table">
	<form method="post">
	<tr valign="top">
	<th scope="row"><label for="sms_from_email">From Email</label></th>
	<td><input class='easysms'  type="text" name="sms_from_email" value="<? if (!isset($_REQUEST['sms_submit'])){ echo $sms_from;} else { echo $_REQUEST['sms_from_email'];} ?>" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_from_name">From Name</label></th>
	<td><input class='easysms'  type="text" name="sms_from_name" value="<? if (!isset($_REQUEST['sms_submit'])){ echo $sms_name;} else { echo $_REQUEST['sms_from_name'];} ?>" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_default_subject">Default Subject</label></th>
	<td><input class='easysms'  type="text" name="sms_default_subject" value="<? if (!isset($_REQUEST['sms_submit'])){ echo $sms_subject;} else { echo $_REQUEST['sms_default_subject'];} ?>" size="40" /></td>
	 <tr valign="top">
	 <th scope="row"><label for="sms_publish_post">Send SMS when posts are published?</label></th>
	 <td><select name="sms_publish_post">
	 <?
		  if(isset($_REQUEST['sms_publish_post']))
		  {
			   if($_REQUEST['sms_publish_post'] == 'yes')
			   { ?>
				 <option name="sms_publish_post_yes" selected value="yes">Yes</option>    
				 <option name="sms_publish_post_no" value="no">No</option>   
			   <? }
		  }
		  else
		  {
	 ?>
	 <option name="sms_publish_post_yes" <? echo $pub_yes; ?> value="yes">Yes</option>
	 <? } ?>
	 <?
		  if(isset($_REQUEST['sms_publish_post']))
		  {
			   if($_REQUEST['sms_publish_post'] == 'no')
			   { ?>
				 <option name="sms_publish_post_no" selected value="no">No</option>
			         <option name="sms_publish_post_yes" value="yes">Yes</option>   
				    
			   <? }
		  }
		  else
		  {
	 ?>
	 <option name="sms_publish_post_no" <? echo $notify_no ?> value="no">No</option>
	 <? } ?>
	 </select>
	 <? echo "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Message Format:</b> &nbsp;&nbsp;New post at ".get_bloginfo('name')." - [[Post Title]] - Visit ".get_bloginfo('url'); ?>
	 </tr>
	  <tr valign="top">
	 <th scope="row"><label>Get notified of new subscribers?</label></th>
	 <td><select name="sms_new_notify">
	 <?
		  if(isset($_REQUEST['sms_new_notify']))
		  {
			   if($_REQUEST['sms_new_notify'] == 'yes')
			   { ?>
				 <option name="sms_new_notify_yes" selected value="yes">Yes</option>    
				 <option name="sms_new_notify_no" value="no">No</option>   
			   <? }
		  }
		  else
		  {
	 ?>
	 <option name="sms_new_notify_yes" <? echo $notify_yes; ?> value="yes">Yes</option>
	 <? } ?>
	 <?
		  if(isset($_REQUEST['sms_new_notify']))
		  {
			   if($_REQUEST['sms_new_notify'] == 'no')
			   { ?>
				 <option name="sms_new_notify_no" selected value="no">No</option>
			         <option name="sms_new_notify_yes" value="yes">Yes</option>   
				    
			   <? }
		  }
		  else
		  {
	 ?>
	 <option name="sms_new_notifyt_no" <? echo $notify_no ?> value="no">No</option>
	 <? } ?>
	 </select>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Where do you want the notification sent? &nbsp;&nbsp;<input class='easysms'  name="sms_new_notify_email" size="40" value="<? echo $sms_new_notify_email ?>"type="text">
	 </tr>
	 	 
	</table>
	<p class="submit">
	<input class='easysms'  type="submit" name="sms_submit" value="Save Changes" />
	</p>
	</form>
	</div>


<?	
}

function easysms_update_options()
{
	if (isset($_REQUEST['sms_submit']))
	{
	$q = 0;
	if ($_REQUEST['sms_from_email'])
	{
		update_option('sms_from_email', $_REQUEST['sms_from_email']);
		$q = 1;
	}
	if ($_REQUEST['sms_from_name'])
	{
		update_option('sms_from_name', $_REQUEST['sms_from_name']);
		$q = 1;
	}
	if ($_REQUEST['sms_default_subject'])
	{
		update_option('sms_default_subject', $_REQUEST['sms_default_subject']);
		$q = 1;
	}
	if ($_REQUEST['sms_publish_post'])
	{
		update_option('sms_publish_post', $_REQUEST['sms_publish_post']);
		$q = 1;
	}
	if ($_REQUEST['sms_new_notify'])
	{
		update_option('sms_new_notify', $_REQUEST['sms_new_notify']);
		$q = 1;
	}
	if ($_REQUEST['sms_new_notify_email'])
	{
		update_option('sms_new_notify_email', $_REQUEST['sms_new_notify_email']);
		$q = 1;
	}
	
	if ($q = 1)
	{
		global $update_options;
		$update_options = "<p class='easysms_text'>Update Successful!</P>";
	}
	else
	{
		global $update_options;
		$update_options = "Update Failed";
		
	}
	}
}

?>