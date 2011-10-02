<?php

if(isset($_GET['edit']))
{
    sms_subscriber_edit($_GET['edit']);
}

elseif(isset($_GET['delete']))
{
    sms_subscriber_delete($_GET['delete']);
}

else
{
    sms_subscriber_table();    
}

function shortdesc($text)
{
    $chars = 50;
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text." ...";
    return $text;
}

function sms_subscriber_table()
{ ?>
    <div class=wrap>
    <h2>EasySMS Subscribers</h2>
    <br />
    <h2>Confirmed</h2>
    <table class="widefat">
    <thead>
    <tr class="thead">
            <th>Name</th>
            <th>Phone</th>
            <th>Groups</th>
            <th>SMS Count</th>
            <th>Note</th>
            <th></th>
            <th></th>
            
    </tr>
    </thead>
    <tbody class="list:user user-list">

<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms WHERE confirm = 'yes' ORDER BY lastName ASC");

    foreach($result as $results)
    {
        $sql = "SELECT * FROM easysms_group_users WHERE user_id = '".$results->ID."'";
        $result1 = mysql_query($sql);
        $num_rows = mysql_num_rows($result1);
        if($num_rows == 0){$num_rows = 'None';}
        ?>
        <tr class="alternate">
            <td><strong><? echo $results->lastName.", ".$results->firstName ?></strong></td>
            <td><? echo $results->phoneNumber ?></td>
            <td><? echo $num_rows ?></td>
            <td><? echo $results->msgCount ?></td>
            <td><? echo shortdesc($results->notes) ?></td>
            <td><a href="admin.php?page=easySMS_subscribers&edit=<? echo $results->ID ?>">Edit</a></td>
            <td><a href="admin.php?page=easySMS_subscribers&delete=<? echo $results->ID ?>">Delete</a></td>
        </tr>
        
        <? } ?>
    </tbody>
    </table>
    
    <div class="tablenav">
    <br class="clear" />
    </div>
    
    <br /><br />
    <h2>Not Confirmed</h2>
    <table class="widefat">
    <thead>
    <tr class="thead">
            <th>Name</th>
            <th>Phone</th>
            <th></th>
    </tr>
    </thead>
    <tbody class="list:user user-list">

<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms WHERE confirm = 'no' ORDER BY lastName ASC");

    foreach($result as $results)
    {
        $sql = "SELECT * FROM easysms_group_users WHERE user_id = '".$results->ID."'";
        $result1 = mysql_query($sql);
        $num_rows = mysql_num_rows($result1);
        if($num_rows == 0){$num_rows = 'None';}
        ?>
        <tr class="alternate">
            <td><strong><? echo $results->lastName.", ".$results->firstName ?></strong></td>
            <td><? echo $results->phoneNumber ?></td>
            <td><a href="admin.php?page=easySMS_subscribers&delete=<? echo $results->ID ?>">Delete</a></td>
        </tr>
        
        <? } ?>
    </tbody>
    </table>
    <div class="tablenav">
    <br class="clear" />
    </div>
    </div>
    
<?
}

function sms_subscriber_edit($id)
{
    
    
    if(isset($_POST['sms_subscriber_edit']))
    {
        global $formCheck;
        $formCheck = 0;
        
               
        if($_POST['sms_subscriber_firstName'] == null)
        {
            global $subscriber_update;
            $subscriber_update = "<br /><font color='red'><b>First name cannot be blank.</b></font><br />";
            global $formCheck;
            $formCheck = 1;
        }
        
        if($_POST['sms_subscriber_lastName'] == null)
        {

            global $subscriber_update;
            $subscriber_update = $subscriber_update."<br /><font color='red'><b>Last name cannot be blank.</b></font><br />";
            global $formCheck;
            $formCheck = 1;
        }
        if($formCheck == 0)
        {
        $sql = "UPDATE easysms SET firstName = '".$_POST['sms_subscriber_firstName']."', lastName = '".$_POST['sms_subscriber_lastName']."' , notes = '".$_POST['sms_subscriber_notes']."' WHERE ID = '".$id."' ";
        mysql_query($sql);
        global $subscriber_update;
        $subscriber_update = "<br />Update Successful!<br />";
        }
    }
    
    if (isset($_POST['remove_subscriber_group']))
    {
        $sms_group = $_POST['subscriber_groups'];
        foreach ($sms_group as $sms_groups)
        {
            $sql = "DELETE FROM easysms_group_users WHERE user_id = '".$id."' AND group_id = '".$sms_groups."'";
            mysql_query($sql);
        }     
        $remove_groups = "<br />Subscriber was successfully removed from groups!<br />";
    }
    
    if (isset($_POST['add_subscriber_group']))
    {
        $sms_group = $_POST['subscriber_groups'];
        foreach ($sms_group as $sms_groups)
        {
            $sql = "INSERT INTO easysms_group_users (user_id, group_id) VALUES ('".$id."', '".$sms_groups."')";
            mysql_query($sql);
        }     
        $remove_groups = "<br />Subscriber was successfully added to groups!<br />";
    }
    
    
    $sql = "SELECT * FROM easysms WHERE ID = '".$id."' ORDER BY lastName ASC";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result); 
    
    $sql = "SELECT * FROM easysms_carriers WHERE ID = '".$row['carrierEmail']."'";
    $result = mysql_query($sql);
    $carrier = mysql_fetch_array($result);
       
    ?>
   <div class="wrap">
    <h2>Edit Subscriber Profile</h2>
    <p class='easysms_text'><a href="admin.php?page=easySMS_subscribers">Back to Subscribers</a></p>
    <? global $subscriber_update; echo $subscriber_update ?>
    <table class="form-table">
    <form method="post">
    <tr valign="top">
    <th scope="row"><label>First Name</label></th>
    <td><input class='easysms'  type="text" name="sms_subscriber_firstName" value="<? echo $row['firstName'] ?>" size="40" /></td>
    </tr>
    <tr valign="top">
    <th scope="row"><label>Last Name</label></th>
    <td><input class='easysms'  type="text" name="sms_subscriber_lastName" value="<? echo $row['lastName'] ?>" size="40" /></td>
    </tr>
    <tr valign="top">
    <th scope="row"><label>Phone Number</label></th>
    <td><input class='easysms'  type="text" disabled="disabled" value="<? echo $row['phoneNumber']." (".$carrier['carrierName'].")" ?>" size="40" /></td>
    </tr>
    <tr valign="top">
    <th scope="row">SMS Count</th>
    <td><? echo $row['firstName'] ?> has been sent <b><? echo $row['msgCount'] ?></b> message(s) so far.</td>
    </tr>
    <tr valign="top">
    <th scope="row"><label>Notes</label></th>
    <td><textarea name="sms_subscriber_notes" cols="37" rows="5" /><? echo $row['notes'] ?></textarea></td>
    </tr> 
    </table>
    <p class="submit">
    <input class='easysms'  type="submit" name="sms_subscriber_edit" value="Save Changes" />
    </p>
    </form>
    
    <br /><br />
    
    <h2><? echo $row['firstName'] ?>'s Groups</h2>
    <form method="post">
    <table class="widefat">
    
    <thead>
    <tr class="thead">
	<th scope="col" class="check-column"></th>
        <th>Group</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody class="list:user user-list">
<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms_group_users WHERE user_id = '".$id."'");

    foreach($result as $results)
    {
    $sql = "SELECT * FROM easysms_groups WHERE ID = '".$results->group_id."'";
    $result1 = mysql_query($sql);
    $row = mysql_fetch_array($result1);
    $group_check = mysql_num_rows($result1);
    ?>
    <tr class="alternate">
        <th scope='row' class='check-column'><input class='easysms'  type='checkbox' name='subscriber_groups[]' class='subscriber' value='<? echo $row['ID'] ?>' /></th>
        <td><strong><? echo $row['groupName'] ?></strong></td>
        <td><? echo $row['groupDescription'] ?></td>
    </tr>
    <? } ?>
    </tbody>
    </table>
    <br />
    <br class="clear" />
    <?
    if (!$group_check == null)
    {
    ?>
    <input class='easysms'  type="submit" value="Remove From Group" name="remove_subscriber_group" class="button-secondary" />
    <? } ?>
    </form>
    
    <br /><br />
    <h2>Available Groups</h2>
    <form method="post">
    <table class="widefat">
    <thead>
    <tr class="thead">
	<th scope="col" class="check-column"></th>
        <th>Group</th>
        <th>Description</th>
        </tr>
    </thead>
    <tbody class="list:user user-list">
<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms_groups");
    foreach($result as $results)
    {
        $sql = "SELECT * FROM easysms_group_users WHERE user_id = '".$id."' AND group_id = '".$results->ID."'";
        $result1 = mysql_query($sql);
        $num_rows = mysql_num_rows($result1);       
        if($num_rows == 0){
        ?>
        <tr class="alternate">
            <th scope='row' class='check-column'><input class='easysms'  type='checkbox' name='subscriber_groups[]' class='subscriber' value='<? echo $results->ID ?>' /></th>
            <td><strong><? echo $results->groupName ?></strong></td>
            <td><? echo $results->groupDescription ?></td>
        </tr>
<?      global $group_check;
        $group_check = true;
        }
    }
  
?>
    </tbody>
    </table>
    <br />
    <br class="clear" />
    <?
    global $group_check;
    if ($group_check == true)
    {
    ?>
    <input class='easysms'  type="submit" value="Add To Group" name="add_subscriber_group" class="button-secondary" />
    <? } ?>
    
    </form>
    
    
    
    </div>
    <?
}

function sms_subscriber_delete($id)
{
    $sql = "SELECT * FROM easysms WHERE ID = '".$id."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    if(isset($_GET['confirmDelete']))
    {
        $sql = "DELETE FROM easysms WHERE ID = '".$id."'";
        mysql_query($sql);
        $sql = "DELETE FROM easysms_group_users WHERE user_id = '".$row['ID']."'";
        mysql_query($sql);
?>
    <div class="wrap">
    <h2>Subscriber Deleted!</h2>
    <p class='easysms_text'><a href="admin.php?page=easySMS_subscribers">Back to Subscribers</a></p>
    </div>
<?  }
    else
    {
    $sql = "SELECT * FROM easysms WHERE ID = '".$row['ID']."'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    ?>    
        <div class="wrap">
        <h2>Delete Subscriber</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_subscribers">Back to Subscribers</a></p>
        <table class="form-table">
        <tr valign="top">
        <td>
        <h1><a href="admin.php?page=easySMS_subscribers&delete=<? echo $row['ID'] ?>&confirmDelete=yes">Do you really want to delete <? echo $row['firstName']." ".$row['lastName'] ?>?</a></h1>
        </td>
        </tr>
        </table>
        </div>
    <? }
}


?>