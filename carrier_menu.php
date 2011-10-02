<?php

if(isset($_GET['edit']))
{
    sms_carrier_edit($_GET['edit']);
}
elseif(isset($_GET['delete']))
{
    sms_carrier_delete($_GET['delete']);
}
elseif(isset($_GET['add']))
{
    sms_carrier_add();
}
else
{
sms_carrier_table();    
}


function sms_carrier_table()
{
?>
<div class=wrap>
<h2>EasySMS Carriers</h2>
<p class='easysms_text'><a href="admin.php?page=easySMS_carriers&add=true">Add A Carrier</a></p>
<br />
<table class="widefat">
<thead>
<tr class="thead">
	<th>Carrier</th>
	<th>Email</th>
        <th>Subscribers</th>
        <th></th>
        <th></th>
</tr>
</thead>
<tbody class="list:user user-list">

<?
GLOBAL $wpdb;
$result = $wpdb->get_results("SELECT * FROM easysms_carriers ORDER BY carrierName ASC");

foreach($result as $results)
{
    $sql = "SELECT * FROM easysms WHERE carrierEmail = '".$results->ID."'";
    $result1 = mysql_query($sql);
    $num_rows = mysql_num_rows($result1);
    if($num_rows == 0){$num_rows = 'None';}
    ?>
    <tr class="alternate">
        <td><strong><? echo $results->carrierName ?></strong></td>
        <td><? echo $results->carrierEmail ?></td>
        <td><? echo $num_rows ?></td>
        <td><a href="admin.php?page=easySMS_carriers&edit=<? echo $results->ID ?>">Edit</a></td>
        <td><a href="admin.php?page=easySMS_carriers&delete=<? echo $results->ID ?>">Delete</a></td>
    </tr>
    
    <?
}

?>
</tbody>
</table>
<div class="tablenav">
<br class="clear" />
</div>
</div>

<? }

function sms_carrier_add()
{
        
    if(isset($_POST['sms_carrier_add']))
    {
	$sms_email = strpos($_POST['sms_carrier_email'],'.');
	$sms_domain = str_replace('@', '', $_POST['sms_carrier_email']);
	$sql = "SELECT * FROM easysms_carriers WHERE carrierName = '".$_POST['sms_carrier_name']."'";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	$sql1 = "SELECT * FROM easysms_carriers WHERE carrierEmail = '".$sms_domain."'";
	$result1 = mysql_query($sql1);
	$num_rows1 = mysql_num_rows($result1);
	
	
	if($_POST['sms_carrier_name'] == null)
	{
	    $carrier_update = $carrier_update."<font color='red'><b>Please enter a carrier name!</b></font><br />";
	}
		    
	elseif($num_rows > 0)
	{
	    $carrier_update = $carrier_update."<font color='red'><b>That carrier name is already taken!</b></font><br />";
	}

	if($_POST['sms_carrier_email'] != null)
	{
	    if($sms_email === false)
		{
		    $carrier_update = $carrier_update."<font color='red'><b>Please place an extension on the domain!</b></font><br />";
        	}
	}
	
	if($_POST['sms_carrier_email'] == null)
	{
	    $carrier_update = $carrier_update."<font color='red'><b>Please enter a domain!</b></font><br />";
	}
	
	elseif($num_rows1 > 0)
        {
	        $carrier_update = $carrier_update."<font color='red'><b>That carrier email is already taken!</b></font><br />";
        }
        
	if($num_rows1 == 0 && $num_rows == 0 && $_POST['sms_carrier_name'] != null && $_POST['sms_carrier_email'] != null && $sms_email == true)
	{
	    $sql = "INSERT INTO easysms_carriers (carrierName, carrierEmail) VALUES ('".$_POST['sms_carrier_name']."', '".$sms_domain."')";
	    mysql_query($sql);
	    $carrier_update = "<br />Carrier Added!<br />";
	}
        
		
	
    }
      
    ?>
   <div class="wrap">
	<h2>Add Carrier</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_carriers">Back to Carriers</a></p>
        <? echo $carrier_update ?>
	<table class="form-table">
	<? easysms_update_options() ?>
	<form method="post">
	<tr valign="top">
	<th scope="row"><label for="sms_carrier_name">Display Name</label></th>
	<td><input class='easysms'  type="text" name="sms_carrier_name" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_carrier_email">SMS Domain</label></th>
	<td><input class='easysms'  type="text" name="sms_carrier_email" size="40" /> Example: <b>mydomain.com</b></td>
	</tr>
	</table>
	<p class="submit">
	<input class='easysms'  type="submit" name="sms_carrier_add" value="Add Carrier" />
	</p>
	</form>
	</div>
<? }


function sms_carrier_edit($id)
{
    if(isset($_POST['sms_carrier_edit']))
    {
	$sms_email = strpos($_POST['sms_carrier_email'],'.');
	$sms_domain = str_replace('@', '', $_POST['sms_carrier_email']);
	$sql = "SELECT * FROM easysms_carriers WHERE ID = '".$id."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	global $formCheck;
	$formCheck = 0;
	
	if($_POST['sms_carrier_name'] == null)
	{
	    $carrier_update = $carrier_update."<font color='red'><b>Carrier name must not be blank!</b></font><br />";
	    global $formCheck;
	    $formCheck = 1;
	}
		    
	if($_POST['sms_carrier_name'] != $row['carrierName'])
	{
	    $sql = "SELECT * FROM easysms_carriers WHERE carrierName = '".$_POST['sms_carrier_name']."'";
	    $result = mysql_query($sql);
	    $num_rows = mysql_num_rows($result);
	    if($num_rows == 1)
	    {
		$carrier_update = $carrier_update."<font color='red'><b>The name ".$_POST['sms_carrier_name']." is already taken!</b></font><br />";
		global $formCheck;
		$formCheck = 1;
	    }
	    
	}
	
	if($_POST['sms_carrier_email'] != null)
	{
	    if($sms_email === false)
	    {
		$carrier_update = $carrier_update."<font color='red'><b>Please place an extension on the domain!</b></font><br />";
		global $formCheck;
		$formCheck = 1;
	    }
	}
	
	
	if($_POST['sms_carrier_email'] == null)
	{
	    $carrier_update = $carrier_update."<font color='red'><b>Domain must not be blank!</b></font><br />";
	    global $formCheck;
	    $formCheck = 1;
	}
	
		
	if($_POST['sms_carrier_email'] != $row['carrierEmail'])
        {
	    $sql1 = "SELECT * FROM easysms_carriers WHERE carrierEmail = '".$_POST['sms_carrier_email']."'";
	    $result1 = mysql_query($sql1);
	    $num_rows1 = mysql_num_rows($result1);
	    if($num_rows1 == 1)
	    {
		$carrier_update = $carrier_update."<font color='red'><b>The domain ".$_POST['sms_carrier_email']." is already taken!</b></font><br />";
		global $formCheck;
		$formCheck = 1;
	    }
        }
	
	if($_POST['sms_carrier_email'] == $row['carrierEmail'] && $_POST['sms_carrier_name'] == $row['carrierName'])
	{
	    $carrier_update = $carrier_update."<font color='red'><b>Nothing changed!</b></font><br />";
	    global $formCheck;
	    $formCheck = 1;
	}
	
	if($formCheck == 0)
	{
	    $sql = "UPDATE easysms_carriers SET carrierName = '".$_POST['sms_carrier_name']."', carrierEmail = '".$_POST['sms_carrier_email']."' WHERE ID = '".$_GET['edit']."' ";
	    mysql_query($sql);
	    $carrier_update = "<br />Update Successful!<br />";
	}
	
    }
	
	  
 
    
    $sql = "SELECT * FROM easysms_carriers WHERE ID = '".$id."'ORDER BY carrierName ASC";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    $sql = "SELECT * FROM easysms WHERE carrierEmail = '".$row['ID']."'";
    $result1 = mysql_query($sql);
    $num_rows = mysql_num_rows($result1);
       
    ?>
   <div class="wrap">
	<h2>Edit Carrier</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_carriers">Back to Carriers</a></p>
        <? echo $carrier_update ?>
	<table class="form-table">
	<? easysms_update_options() ?>
	<form method="post">
	<tr valign="top">
	<th scope="row"><label for="sms_carrier_name">Carrier</label></th>
	<td><input class='easysms'  type="text" name="sms_carrier_name" value="<? echo $row['carrierName'] ?>" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_carrier_email">SMS Domain</label></th>
	<td><input class='easysms'  type="text" name="sms_carrier_email" value="<? echo $row['carrierEmail'] ?>" size="40" /></td>
	</tr>
        <tr valign="top">
	<?
        if(!$num_rows == 0)
        { ?>
        <th scope="row"></th>
        <td><? echo $num_rows ?> subscriber(s) use this carrier. <font color="red">Warning: Messages will not be delivered to these subscribers if the wrong domain is entered.</font></td>
	<? } ?>
        </tr>
	</table>
	<p class="submit">
	<input class='easysms'  type="submit" name="sms_carrier_edit" value="Save Changes" />
	</p>
	</form>
	</div> 
<? }

function sms_carrier_delete($id)
{
    $sql = "SELECT * FROM easysms_carriers WHERE ID = '".$id."'ORDER BY carrierName ASC";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    if(isset($_GET['confirmDelete']))
    {
        $sql = "DELETE FROM easysms_carriers WHERE ID = '".$id."'";
        mysql_query($sql);
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM easysms WHERE carrierEmail = '".$id."'");
        foreach($result as $results)
        {
            $sql = "DELETE FROM easysms WHERE ID = '".$results->ID."'";
            mysql_query($sql);
            $sql = "DELETE FROM easysms_group_users WHERE user_id = '".$results->ID."'";
            mysql_query($sql);
        }
        
        
        
?>
    <div class="wrap">
    <h2>Carrier Deleted!</h2>
    <p class='easysms_text'><a href="admin.php?page=easySMS_carriers">Back to Carriers</a></p>
    </div>
<?  }
    else
    {
    $sql = "SELECT * FROM easysms WHERE carrierEmail = '".$row['ID']."'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    ?>    
        <div class="wrap">
        <h2>Delete Carrier</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_carriers">Back to Carriers</a></p>
        <table class="form-table">
        <tr valign="top">
        <td>
        <h3><font color="red">Warning: All subscribers associated with this carrier will be deleted!</font></h3>
        <h1><a href="admin.php?page=easySMS_carriers&delete=<? echo $row['ID'] ?>&confirmDelete=yes">Do you really want to delete <? echo $row['carrierName'] ?>?</a></h1>
        <h3> <? echo $num_rows ?> subscriber(s) use this carrier.</h3>  
        </td>
        </tr>
        </table>
        </div>
    <? }
}


?>