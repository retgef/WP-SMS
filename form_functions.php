<script language="javascript" type="text/javascript">
<!-- 

function easysmsRegister(){
	var ajaxRequest;  
	try{
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_click').value = "One Moment Please";
	document.getElementById('easysms_click').disabled = true;

	var first = document.getElementById('first').value;
	var last = document.getElementById('last').value;
        var phone = document.getElementById('phone').value;
        var carrier = document.getElementById('carrier').value;
	var queryString = "?first=" + first + "&last=" + last + "&phone=" + phone + "&carrier=" + carrier + "&smsregister=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}

function easysmsConfirm(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_confirm').value = "Checking Confirmation";
	document.getElementById('easysms_confirm').disabled = true;
	document.getElementById('easysms_resend').disabled = true;
	document.getElementById('easysms_change').disabled = true;

	var cellcode = document.getElementById('cellcode').value;
	var phone = document.getElementById('phone').value;
        var smsconfirm = document.getElementById('smsconfirm').value;
	var queryString = "?cellcode=" + cellcode + "&phone=" + phone + "&smsconfirm=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}

function easysmsResend(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_resend').value = "Resending Code";
	document.getElementById('easysms_confirm').disabled = true;
	document.getElementById('easysms_resend').disabled = true;
	document.getElementById('easysms_change').disabled = true;

	var phone = document.getElementById('phone1').value;
        var smsresend = document.getElementById('smsresend').value;
	var queryString = "?phone=" + phone + "&smsresend=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}

function easysmsChange(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_change').value = "Deleting Number";
	document.getElementById('easysms_confirm').disabled = true;
	document.getElementById('easysms_resend').disabled = true;
	document.getElementById('easysms_change').disabled = true;

	var phone = document.getElementById('phone2').value;
        var smschange = document.getElementById('smsresend').value;
	var queryString = "?phone=" + phone + "&smschange=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}

function easysmsRetrieve(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_retrieve').value = "One Moment Please";
	document.getElementById('easysms_retrieve').disabled = true;
	document.getElementById('easysms_click').disabled = true;
	document.getElementById('easysms_manage').disabled = true;

	var smsretrieve = document.getElementById('smsretrieve').value;
	var queryString = "?smsretrieve=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}

function easysmsHome(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_home').value = "One Moment Please";
	document.getElementById('easysms_home').disabled = true;
	document.getElementById('easysms_resend').disabled = true;
	document.getElementById('easysms_unsubscribe').disabled = true;

	var smshome = document.getElementById('smshome').value;
	var queryString = "?smshome=true";
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}


function easysmsManage(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_manage').value = "One Moment Please";
	document.getElementById('easysms_manage').disabled = true;
	document.getElementById('easysms_click').disabled = true;
	document.getElementById('easysms_retrieve').disabled = true;

	var smsmanage = document.getElementById('smsmanage').value;
	var queryString = "?smsmanage=true";
	ajaxRequest.open("GET",  queryString, true);
	ajaxRequest.send(null); 
}

function easysmsUnsubscribe(){
	var ajaxRequest;  
	try{
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				
				alert("Your browser broke!");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('easysmsDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	document.getElementById('easysms_unsubscribe').value = "One Moment Please";
	document.getElementById('easysms_unsubscribe').disabled = true;

	var phone = document.getElementById('phone').value;
	var carrier = document.getElementById('carrier').value;
	var smsunsubscribe = document.getElementById('smsunsubscribe').value;
	var queryString = "?smsunsubscribe=true" + "&phone=" + phone + "&carrier=" + carrier;
	ajaxRequest.open("GET", queryString, true);
	ajaxRequest.send(null); 
}



//-->
</script>    

<?php



function easysm_confirm_form($phone)
{ ?>
      	<p class='easysms_text'>Please enter your verification code.</p>
	<form class='easysms'>
        <input class='easysms'  id="cellcode" type="text" maxlength="16" value=""/>
        <input type="hidden" id="phone" value="<? echo $phone ?>">
	<input type="hidden" id="smsconfirm" value="true">
   	<input class="easysms_button" type="button" name="easysms_confirm" id="easysms_confirm" onclick='easysmsConfirm()' value="Confirm" />
	</form>
	<form class="easysms_links">
	<input type="hidden" id="phone1" value="<? echo $phone ?>">
	<input type="hidden" id="smsresend" value="true">
	<input class="easysms_links" type="button" id="easysms_resend" onclick='easysmsResend()' value="Resend" />
	</form>
	<form class="easysms_links">
        <input type="hidden" id="phone2" value="<? echo $phone ?>">
	<input type="hidden" id="smschange" value="true">
	<input class="easysms_links" type="button" id="easysms_change" onclick='easysmsChange()' value="Change Number" />
	</form>
<?}

function easysm_retrieve_form()
{ ?>
      	<form class='easysms'>
	<label class="easysms">Phone Number</label>
        <input class='easysms' id="phone1" type="text" maxlength="16" />
        <input type="hidden" id="smsresend" value="true">
	<input type="hidden" id="easysms_confirm" value="true">
	<input type="hidden" id="easysms_change" value="true">
	<input type="hidden" id="smsresendst" value="<? echo $site ?>">
   	<input class="easysms_button" type="button" id="easysms_resend" onclick='easysmsResend()' value="Resend Code" />
	</form>
	<form class="easysms_links">
	<input type="hidden" id="smshome" value="true">
	<input type="hidden" id="easysms_unsubscribe">
	<input class="easysms_links" type="button" id="easysms_home" onclick='easysmsHome()' value="Go Back" />
	</form>
	
<?}

function easysm_manage_form()
{	?>
      	<form class='easysms'>
	<label class="easysms">Your Mobile Number</label>
      <input class='easysms'  id='phone' type="text" maxlength="15" value="">
        <label class="easysms">Your Mobile Carrier</label>
      <select class="easysms" id="carrier">
      <?
      if($carrier != null){
      global $wpdb;
      $result = $wpdb->get_results("SELECT * FROM easysms_carriers WHERE ID = '".$carrier."'");
      foreach($result as $results){
      ?>
      <option size=30 selected value="<? echo $results->ID ?>"><?echo $results->carrierName?></option>
      
      <?}}
      else{
      ?>
      <option size=30 selected value="notselected">Choose Your Carrier</option>
<?    }
      if ($_GET['carrier'] == "notselected"){ ?>
      <option size=30 selected value="notselected">Choose Your Carrier</option>
<?    }
      GLOBAL $wpdb;
      $result = $wpdb->get_results("SELECT * FROM easysms_carriers ORDER BY carrierName ASC");
      foreach($result as $results)
      {
	      echo "<option value=".$results->ID.">".$results->carrierName."</option>";
      }
?>    </select>
      
        <input type="hidden" id="smsunsubscribe" value="true">
	<input class="easysms_button" type="button" id="easysms_unsubscribe" onclick='easysmsUnsubscribe()' value="Unsubscribe" />
	</form>
	<form class="easysms_links">
	<input type="hidden" id="smshome" value="true">
	<input type="hidden" id="easysms_resend">
	<input class="easysms_links" type="button" id="easysms_home" onclick='easysmsHome()' value="Go Back" />
	</form>
<?}

function easysms_subscribe_form($first, $last, $phone, $carrier)
{
?>
      <form class='easysms'>
      <label class="easysms">First Name</label>
      <input class='easysms'  type="text" id='first' value="<? echo $first ?>">
      
      <label class="easysms">Last Name</label>
      <input class='easysms'  type="text" id='last' value="<? echo $last ?>" >
     
      <label class="easysms">Your Mobile Number</label>
      <input class='easysms'  id='phone' type="text" maxlength="15" value="<? echo $phone ?>"> 
        <label class="easysms">Your Mobile Carrier</label>
      <select class="easysms" id="carrier">
      <?
      if($carrier != null){
      global $wpdb;
      $result = $wpdb->get_results("SELECT * FROM easysms_carriers WHERE ID = '".$carrier."'");
      foreach($result as $results){
      ?>
      <option size=30 selected value="<? echo $results->ID ?>"><?echo $results->carrierName?></option>
      
      <?}}
      else{
      ?>
      <option size=30 selected value="notselected">Choose Your Carrier</option>
<?    }
      if ($_GET['carrier'] == "notselected"){ ?>
      <option size=30 selected value="notselected">Choose Your Carrier</option>
<?    }
      GLOBAL $wpdb;
      $result = $wpdb->get_results("SELECT * FROM easysms_carriers ORDER BY carrierName ASC");
      foreach($result as $results)
      {
	      echo "<option value=".$results->ID.">".$results->carrierName."</option>";
      }
?>    </select>
      <? $options = get_option('bf_easysms_widget_options');
      if ($options['termshide'] == "no")
      {
	echo "<p class='easysms_text'>".$options[terms]."</p>";
      } ?>
      
      <input class="easysms_button" type="button" id="easysms_click" onclick='easysmsRegister()' value="I Agree" />
      </form>
      
	<form class="easysms_links">
	<input type="hidden" id="smsretrieve" value="true">
	<input class="easysms_links" type="button" id="easysms_retrieve" onclick='easysmsRetrieve()' value="Resend Code" />
	</form>
	<form class="easysms_links">
	<input type="hidden" id="smsmanage" value="true">
	<input class="easysms_links" type="button" id="easysms_manage" onclick='easysmsManage()' value="Unsubscribe" />
	</form>
	

<?php
}
?>
