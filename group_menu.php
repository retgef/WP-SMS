<?php

if(isset($_GET['edit']))
{
    sms_group_edit($_GET['edit']);
}
elseif(isset($_GET['delete']))
{
    sms_group_delete($_GET['delete']);
}
elseif(isset($_GET['add']))
{
    sms_group_add();
}

elseif(isset($_GET['manage']))
{
    
    sms_group_manage($_GET['manage']);
    
}

else
{
    sms_group_table();    
}

function shortdesc($text) {
    $chars = 50;
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text." ...";
    return $text;
}



function sms_group_table()
{
?>
<div class=wrap>
<h2>EasySMS Groups</h2>
<p class='easysms_text'><a href="admin.php?page=easySMS_groups&add=true">Add A Group</a></p>
<table class="widefat">
<thead>
<tr class="thead">
	<th>Group</th>
	<th>Description</th>
        <th>Subscribers</th>
        <th></th>
        <th></th>
        <th></th>
</tr>
</thead>
<tbody class="list:user user-list">

<?
GLOBAL $wpdb;
$result = $wpdb->get_results("SELECT * FROM easysms_groups ORDER BY groupName ASC");

foreach($result as $results)
{
    $sql = "SELECT * FROM easysms_group_users WHERE group_id = '".$results->ID."'";
    $result1 = mysql_query($sql);
    $num_rows = mysql_num_rows($result1);
    if($num_rows == 0){$num_rows = 'None';}
    ?>
    <tr class="alternate">
        <td><strong><? echo $results->groupName ?></strong></td>
        <td><? echo shortdesc($results->groupDescription) ?></td>
        <td><? echo $num_rows ?></td>
        <td><a href="admin.php?page=easySMS_groups&manage=<? echo $results->ID ?>">Manage</a></td>
        <td><a href="admin.php?page=easySMS_groups&edit=<? echo $results->ID ?>">Edit</a></td>
        <td><a href="admin.php?page=easySMS_groups&delete=<? echo $results->ID ?>">Delete</a></td>
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

function sms_group_add()
{
        
    if(isset($_POST['sms_group_add']))
    {
        $sql = "SELECT * FROM easysms_groups WHERE groupName = '".$_POST['sms_group_name']."'";
        $result = mysql_query($sql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0 && $_POST['sms_group_name'] != null){
        $sql = "INSERT INTO easysms_groups (groupName, groupDescription) VALUES ('".$_POST['sms_group_name']."', '".$_POST['sms_group_description']."')";
        mysql_query($sql);
        $sql = "SELECT * FROM easysms_groups WHERE groupName = '".$_POST['sms_group_name']."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $group_update = "<br />Group Added! -  <a href='admin.php?page=easySMS_groups&manage=".$row['ID']."'>Manage ".$_POST['sms_group_name']."</a><br />";
        }
        if($num_rows != 0)
        {
            $group_update = "<br /><font color='red'><b>That group name is already taken!</b></font><br />";
        }
        if($_POST['sms_group_name'] == null)
        {
            $group_update = "<br /><font color='red'><b>Please enter a group name!</b></font><br />";
        }
    }
      
    ?>
   <div class="wrap">
	<h2>Add Group</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_groups">Back to Groups</a></p>
        <? echo $group_update ?>
	<table class="form-table">
	<? easysms_update_options() ?>
	<form method="post">
	<tr valign="top">
	<th scope="row"><label for="sms_group_name">Name</label></th>
	<td><input class='easysms'  type="text" name="sms_group_name" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_group_description">Description</label></th>
	<td><textarea cols="37" rows="5" name="sms_group_description" /></textarea></td>
	</tr>
	</table>
	<p class="submit">
	<input class='easysms'  type="submit" name="sms_group_add" value="Add group" />
	</p>
	</form>
	</div>
<? }


function sms_group_edit($id)
{

    
    if(isset($_POST['sms_group_edit']))
    {
        $sql = "UPDATE easysms_groups SET groupName = '".$_POST['sms_group_name']."', groupDescription = '".$_POST['sms_group_email']."' WHERE ID = '".$_GET['edit']."' ";
        mysql_query($sql);
        $group_update = "<br />Update Successful!<br />";
    }
    
    
    $sql = "SELECT * FROM easysms_groups WHERE ID = '".$id."'ORDER BY groupName ASC";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    $sql = "SELECT * FROM easysms_group_users WHERE group_id = '".$row['ID']."'";
    $result1 = mysql_query($sql);
    $num_rows = mysql_num_rows($result1);
       
    ?>
   <div class="wrap">
	<h2>Edit Group</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_groups">Back to Groups</a></p>
        <? echo $group_update ?>
	<table class="form-table">
	<? easysms_update_options() ?>
	<form method="post">
	<tr valign="top">
	<th scope="row"><label for="sms_group_name">Group</label></th>
	<td><input class='easysms'  type="text" name="sms_group_name" value="<? echo $row['groupName'] ?>" size="40" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="sms_group_email">Description</label></th>
	<td><textarea cols="37" rows="5" name="sms_group_email" /><? echo $row['groupDescription'] ?></textarea></td>
	</tr>
        <tr valign="top">
	<?
        if(!$num_rows == 0)
        { ?>
        <th scope="row"></th>
        <td><? echo $num_rows ?> subscriber(s) in this group.</td>
	<? } ?>
        </tr>
	</table>
	<p class="submit">
	<input class='easysms'  type="submit" name="sms_group_edit" value="Save Changes" />
	</p>
	</form>
	</div> 
<? }

function sms_group_delete($id)
{
    $sql = "SELECT * FROM easysms_groups WHERE ID = '".$id."'ORDER BY groupName ASC";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    
    if(isset($_GET['confirmDelete']))
    {
        $sql = "DELETE FROM easysms_groups WHERE ID = '".$id."'";
        mysql_query($sql);
        $sql = "DELETE FROM easysms_group_users WHERE group_id = '".$row['ID']."'";
        mysql_query($sql);
?>
    <div class="wrap">
    <h2>Group Deleted!</h2>
    <p class='easysms_text'><a href="admin.php?page=easySMS_groups">Back to Groups</a></p>
    </div>
<?  }
    else
    {
    $sql = "SELECT * FROM easysms_group_users WHERE group_id = '".$row['ID']."'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    ?>    
        <div class="wrap">
        <h2>Delete Group</h2>
        <p class='easysms_text'><a href="admin.php?page=easySMS_groups">Back to Groups</a></p>
        <table class="form-table">
        <tr valign="top">
        <td>
        <h1><a href="admin.php?page=easySMS_groups&delete=<? echo $row['ID'] ?>&confirmDelete=yes">Do you really want to delete <? echo $row['groupName'] ?>?</a></h1>
        <h3> <? echo $num_rows ?> subscriber(s) in this group.</h3>  
        </td>
        </tr>
        </table>
        </div>
    <? }
}

function sms_group_manage($id)
{
    if (isset($_POST['remove_group_user']))
    {
        $easysms_users = $_POST['group_users'];
        foreach ($easysms_users as $easysms_user)
        {
            $sql = "DELETE from easysms_group_users WHERE user_id = '".$easysms_user."' AND group_id = '".$id."'";
            mysql_query($sql);
        }     
        $remove_users = "<br />Users Removed Successfully!<br />";
    }
    if (isset($_GET['delete_user']))
    {
        $sql = "DELETE from easysms_group_users WHERE user_id = '".$_GET['delete_user']."' AND group_id = '".$id."'";
        mysql_query($sql);  
        $remove_users = "<br />User Removed Successfully!<br />";
    }
    if (isset($_POST['add_group_user']))
    {
        $easysms_users = $_POST['group_users'];
        foreach ($easysms_users as $easysms_user)
        {
            $sql = "INSERT INTO easysms_group_users (user_id, group_id) VALUES ('$easysms_user', '$id')";
            mysql_query($sql);
        }     
        $remove_users = "<br />Users Added Successfully!<br />";
    }
    if (isset($_GET['add_user']))
    {
        $sql = "INSERT INTO easysms_group_users (user_id, group_id) VALUES ('".$_GET['add_user']."', '$id')";
        mysql_query($sql);  
        $remove_users = "<br />User Added Successfully!<br />";
    }
    
    $sql = "SELECT * FROM easysms_groups WHERE ID = '".$id."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
?>
    <div class=wrap>
    <h2>Manage Group</h2>
    <? echo $remove_users; ?>
    <p class='easysms_text'><a href="admin.php?page=easySMS_groups">Back to Groups</a></p>
    <div class="tablenav">
    <font size=3 color=#555><b><? echo $row['groupName'] ?></b>:</font> <font size=2><i><? echo $row['groupDescription'] ?></i></font>
    </div>
    <br />
    <h2>In This Group</h2>
    <form method="post">
    <table class="widefat">
    
    <thead>
    <tr class="thead">
	<th scope="col" class="check-column"></th>
        <th>Name</th>
        <th>Phone Number</th>
    </tr>
    </thead>
    <tbody class="list:user user-list">
<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms_group_users WHERE group_id = '".$id."'");

    foreach($result as $results)
    {
    $sql = "SELECT * FROM easysms WHERE ID = '".$results->user_id."' AND confirm = 'yes'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    global $group_check;
    $group_check = mysql_num_rows($result);
    ?>
    <tr>
        <th scope='row' class='check-column'><input class='easysms'  type='checkbox' name='group_users[]' class='subscriber' value='<? echo $row['ID'] ?>' /></th>
        <td><strong><? echo $row['firstName']." ".$row['lastName'] ?></strong></td>
        <td><? echo $row['phoneNumber'] ?></td>
    </tr>
    <? } ?>
    </tbody>
    </table>
    <br class="clear" />
    <?
    if (!$group_check == null)
    {
    ?>
    <input class='easysms'  type="submit" value="Remove From Group" name="remove_group_user" class="button-secondary" />
    <? } ?>
    </form>
    
    <br /><br />
    <h2>Not In This Group</h2>
    <form method="post">
    <table class="widefat">
    <thead>
    <tr class="thead">
	<th scope="col" class="check-column"></th>
        <th>Name</th>
        <th>Phone Number</th>
    </tr>
    </thead>
    <tbody class="list:user user-list">
<?
    GLOBAL $wpdb;
    $result = $wpdb->get_results("SELECT * FROM easysms where confirm = 'yes'");

    foreach($result as $results)
    {
        $sql = "SELECT * FROM easysms_group_users WHERE user_id = '".$results->ID."' AND group_id = '".$id."'";
        $result1 = mysql_query($sql);
        $num_rows = mysql_num_rows($result1);
        if($num_rows == 0){
        ?>
        <tr class="alternate">
            <th scope='row' class='check-column'><input class='easysms'  type='checkbox' name='group_users[]' class='subscriber' value='<? echo $results->ID ?>' /></th>
            <td><strong><? echo $results->firstName." ".$results->lastName ?></strong></td>
            <td><? echo $results->phoneNumber ?></td>
        </tr>
<?      global $group_check1;
        $group_check1 = true;
        }
    }
  
?>
    </tbody>
    </table>
    <br class="clear" />
    <?
    global $group_check1;
    if ($group_check1 == true)
    {
    ?>
    <input class='easysms'  type="submit" value="Add To Group" name="add_group_user" class="button-secondary" />
    <? } ?>
    </form>
    
    
    
    </div>
<? } ?>