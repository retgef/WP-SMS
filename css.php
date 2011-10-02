<?php  
function easysms_editcss()
{

$real_file = ABSPATH."/wp-content/plugins/easysms/style.css";
	
if (isset($_POST['updatecss'])) {
	
	if ( !current_user_can('edit_themes') )
	wp_die('<p class=easysms_text>'.__('You do not have sufficient permissions to edit templates for this blog.').'</p>');

	$newcontent = stripslashes($_POST['newcontent']);

	if (is_writeable($real_file)) {
		$f = fopen($real_file, 'w+');
		fwrite($f, $newcontent);

		fclose($f);
		$messagetext = '<font color="#303030">'.__('CSS file successfully updated','nggallery').'</font>';
	}
}


if (!is_file($real_file))
	$error = 1;

if (!$error && filesize($real_file) > 0) {
	$f = fopen($real_file, 'r');
	$content = fread($f, filesize($real_file));
	$content = htmlspecialchars($content); 
}

// message window
if(!empty($messagetext)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p class=easysms_text>'.$messagetext.'</p></div>'; }
	
?>		


<div class="wrap"> 
    <h2>EasySMS CSS</h2>

		
	
	<?php
	if (!$error) {
	?>
	<form name="template" id="template" method="post">
		 <div><textarea cols="140" rows="25" name="newcontent" id="newcontent" tabindex="1"><?php echo $content ?></textarea>
		 <input class='easysms'  type="hidden" name="updatecss" value="updatecss" />
		 <input class='easysms'  type="hidden" name="file" value="<?php echo $file_show ?>" />
		 </div>
<?php if ( is_writeable($real_file) ) : ?>
	<p class="submit">
<?php
	echo "<input class='easysms'  type='submit' name='submit' value='	" . __('Update File &raquo;') . "' tabindex='2' />";
?>
</p>
<?php else : ?>
<p class='easysms_text'><em><?php _e('If this file were writable you could edit it.'); ?></em></p>
<?php endif; ?>
	</form>
	<?php
	} else {
		echo '<div class="error"><p class=easysms_text>' . __('Oops, no such file exists! Double check the name and try again, merci.') . '</p></div>';
	}
	?>

	
<?php
	
	
 
}
?>