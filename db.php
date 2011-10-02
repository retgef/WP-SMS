<?php

function add_easysms_user($fn, $ln, $phone, $ce, $randomcode, $confirm)
{
    $sql = "INSERT INTO easysms (firstName, lastName, phoneNumber, carrierEmail, randomCode, confirm, msgCount) VALUES ('".$fn."', '".$ln."', '".$phone."', '".$ce."', '".$randomcode."', '".$confirm."', '0')";
    mysql_query($sql) or die ("Query failed: " . mysql_error());
}

function easysms_delete_user($user)
{
	$sql = "DELETE FROM easysms WHERE phoneNumber = '".$user."'";
	mysql_query($sql);
}

if(!mysql_num_rows(mysql_query("SHOW TABLES LIKE 'easysms'")))
{
$i = "CREATE TABLE easysms
( 
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
firstName varchar(25),
lastName varchar(25),
phoneNumber varchar(25),
carrierEmail varchar(25),
randomCode varchar(4),
confirm varchar(3),
msgCount int,
notes tinytext
)";
mysql_query($i);
$i = "CREATE TABLE easysms_groups
( 
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
groupName varchar(25),
groupDescription tinytext
)";
mysql_query($i);
$i = "CREATE TABLE easysms_carriers
( 
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
carrierName varchar(25),
carrierEmail varchar(45)
)";
mysql_query($i);
$i = "CREATE TABLE easysms_group_users
( 
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
user_id int,
group_id int
)";
mysql_query($i);
function add_carrier($name, $email)
{
    $i = "INSERT INTO easysms_carriers (carrierName, carrierEmail) VALUES ('".$name."', '".$email."')";
    mysql_query($i);
}
$sms_message = "New Message From ".get_bloginfo('name');
require_once(ABSPATH."wp-content/plugins/easysms/carriers.php");
add_option("sms_from_email", get_bloginfo('admin_email'), '', 'yes');
add_option("sms_from_name", get_bloginfo('name'), '', 'yes');
add_option("sms_default_subject", $sms_message, '', 'yes');
add_option("sms_new_notify", 'yes', '', 'yes');
add_option("sms_publish_post", 'yes', '', 'yes');
add_option("sms_new_notify_email", get_bloginfo('admin_email'), '', 'yes');

$options = array('termshide' => 'no', 'title' => 'Subscribe to SMS', 'class' => 'easysms_widget', 'terms' => "By confirming my cell number, I agree that I am responsible for all of my carrier text messaging charges.");
update_option('bf_easysms_widget_options', $options);


// Convert all preexisting users to new DB schema

global $wpdb;
$cellemails = $wpdb->get_results("SELECT * FROM `wp_usermeta` WHERE `meta_key` = 'cellemail'");
foreach($cellemails as $cellemail)
{
        $lastnames = $wpdb->get_results("SELECT * FROM `wp_usermeta` WHERE `user_id` = '".$cellemail->user_id."' AND `meta_key` = 'last_name'");
        foreach($lastnames as $lastname)
        {
            $firstnames = $wpdb->get_results("SELECT * FROM `wp_usermeta` WHERE `user_id` = '".$cellemail->user_id."' AND `meta_key` = 'first_name'");
            foreach($firstnames as $firstname)
            {
                $cellconfirm = $wpdb->get_results("SELECT * FROM `wp_usermeta` WHERE `user_id` = '".$cellemail->user_id."' AND `meta_key` = 'cellconfirm'");
                foreach($cellconfirm as $cellconfirmed)
                {
                    $explode = explode("@",$cellemail->meta_value);
		    $sql = "SELECT * FROM easysms_carriers WHERE carrierEmail = '".$explode[1]."'";
		    $result = mysql_query($sql);
		    $row = mysql_fetch_array($result);
		    $carrier = $row['ID'];
                    $random = substr(str_shuffle('0123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ'), 0, 4);
                    add_easysms_user($firstname->meta_value, $lastname->meta_value, $explode[0], $carrier, $random, $cellconfirmed->meta_value);
                }
            }
        }
    
}
mysql_query("DELETE FROM wp_usermeta WHERE meta_key = 'cellemail'");
mysql_query("DELETE FROM wp_usermeta WHERE meta_key = 'cellconfirm'");
mysql_query("DELETE FROM wp_usermeta WHERE meta_key = 'cellcode'");
mysql_query("DELETE FROM wp_usermeta WHERE meta_key = 'cellnumber'");
mysql_query("DELETE FROM wp_usermeta WHERE meta_key = 'easysms'");



}
?>