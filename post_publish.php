<?php
function easysmspost($post_ID){
	$postpub = get_option('sms_publish_post');
	if ($postpub == "yes"){
		$the_post = get_post($post_ID);
		if($the_post->post_date_gmt == $the_post->post_modified_gmt)
		{
			$title = stripslashes($the_post['Title']);
			$sql  = "SELECT * FROM easysms WHERE confirm = 'yes'";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);		
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
				$sql = "SELECT * from easysms_carriers WHERE ID = '".$row[carrierEmail]."'";
				$result1 = mysql_query($sql);
				while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
					$from = "From: ". get_option('sms_from_name') . " <" . get_option('sms_from_email') . ">\r\n";
					$subject = "New post at ".get_bloginfo('name')." ";
					$message = $title." - Visit ".get_bloginfo('url');
					$to = $row['phoneNumber']."@".$row1["carrierEmail"];
					mail($to, $subject, $message, $from);
				}
			}
		}
		return $post_ID;
	}
	
}
?>