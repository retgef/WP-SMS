
<div class="wrap">
    

    <h2>EasySMS Dashboard</h2>
    <img src="../wp-content/plugins/easysms/images/logo.png">
    <h3>Quick Links</h3>
    <ol>
    <li class="easysms_dash_links"><a href=admin.php?page=easySMS_send>Send A Message</a></li>
    <li class="easysms_dash_links"><a href=admin.php?page=easySMS_settings>Settings</a></li>
    <li class="easysms_dash_links"><a href=admin.php?page=easySMS_subscribers>Subscribers</a></li>
    <li class="easysms_dash_links"><a href=admin.php?page=easySMS_groups>Groups</a></li>
    <li class="easysms_dash_links"><a href=admin.php?page=easySMS_carriers>Carriers</a></li>
    </ol>
    
    
    <h3>Stats</h3>
    <ol>
<?
    global $wpdb;
    $result = $wpdb->get_results("SELECT msgCount FROM easysms");
    foreach($result as $results)
    {
        global $sms_msgCount;
        $sms_msgCount = $sms_msgCount + $results->msgCount;
    }
?>
    <li class="easysms_dash_links"><? global $sms_msgCount; if($sms_msgCount == null) { $sms_msgCount = 0; echo $sms_msgCount; } else { echo $sms_msgCount; } ?> SMS Message(s) Sent</li> 

<?
    global $wpdb;
    $wpdb->query("SELECT ID FROM easysms WHERE confirm = 'yes'");
    $sms_confirmed = $wpdb->num_rows;
?>
    <li class="easysms_dash_links"><? echo $sms_confirmed ?> Confirmed Subscriber(s)</li>

<?
    global $wpdb;
    $wpdb->query("SELECT ID FROM easysms WHERE confirm = 'no'");
    $sms_unconfirmed = $wpdb->num_rows;
?>
    <li class="easysms_dash_links"><? echo $sms_unconfirmed ?> Unconfirmed Subscriber(s)</li>

<?
    global $wpdb;
    $wpdb->query("SELECT ID FROM easysms_groups");
    $groups = $wpdb->num_rows;
?>
    <li class="easysms_dash_links"><? echo $groups ?> Group(s)</li>    

<?
    global $wpdb;
    $wpdb->query("SELECT ID FROM easysms_carriers");
    $carriers = $wpdb->num_rows;
?>
    <li class="easysms_dash_links"><? echo $carriers ?> Carrier(s)</li>    

    </ol>
          
        
    <h3>Features</h3>
    <i>
    <ol>
    <li class="easysms_dash">Easily send mass SMS messages to your readers.</li>
    <li class="easysms_dash">Create groups and send SMS messages to those groups.</li>
    <li class="easysms_dash">Automatically send SMS with new post.</li>
    <li class="easysms_dash">Add/Delete your own carriers.</li>
    <li class="easysms_dash">Add/Delete subscribers.</li>
    <li class="easysms_dash">Owner cell verification at signup.</li>
    <li class="easysms_dash">Users can unsubscribe at any time.</li>
    <li class="easysms_dash">Sidebar widget form.</li>
    <li class="easysms_dash">Embed the subscribe form on any page using [easysms].</li>
    </ol></i>
    
    
    <h3>Support</h3>
    <ul>
    <li><a href="http://www.wordpress.org/extend/plugins/easysms/">Documentation</a></li>
    <li><a href="http://www.misternifty.com/easysms/">EasySMS Home</a></li>
    <li><a href="http://www.misternifty.com/contact-me/">Contact Me</a></li>
    </ul>
    
    <h3>Donate</h3>
    <p class='easysms_text'>EasySMS is free and is created to better the WordPress community. If you like EasySMS consider donating to its further development.</p>
        <form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/668979632525808" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm">
    <table cellpadding="5" cellspacing="0" width="1%">
        <tr>
            <td align="right" width="1%">
                <select name="item_selection_1">
                    <option value="1">$1.00 - Buy me a soda.</option>
                    <option value="2">$5.00 - Buy me fast food.</option>
                    <option value="3">$10.00 - Buy me real food.</option>
                    <option value="4">$20.00 - Buy me some gas.</option>
                </select>
                <input name="item_option_name_1" type="hidden" value="Buy me a soda."/>
                <input name="item_option_price_1" type="hidden" value="1.0"/>
                <input name="item_option_description_1" type="hidden" value=""/>
                <input name="item_option_quantity_1" type="hidden" value="1"/>
                <input name="item_option_currency_1" type="hidden" value="USD"/>
                <input name="item_option_name_2" type="hidden" value="Buy me fast food."/>
                <input name="item_option_price_2" type="hidden" value="5.0"/>
                <input name="item_option_description_2" type="hidden" value=""/>
                <input name="item_option_quantity_2" type="hidden" value="1"/>
                <input name="item_option_currency_2" type="hidden" value="USD"/>
                <input name="item_option_name_3" type="hidden" value="Buy me real food."/>
                <input name="item_option_price_3" type="hidden" value="10.0"/>
                <input name="item_option_description_3" type="hidden" value=""/>
                <input name="item_option_quantity_3" type="hidden" value="1"/>
                <input name="item_option_currency_3" type="hidden" value="USD"/>
                <input name="item_option_name_4" type="hidden" value="Buy me some gas."/>
                <input name="item_option_price_4" type="hidden" value="20.0"/>
                <input name="item_option_description_4" type="hidden" value=""/>
                <input name="item_option_quantity_4" type="hidden" value="1"/>
                <input name="item_option_currency_4" type="hidden" value="USD"/>
            </td>
            <td align="left" width="1%">
                <input alt="" src="../wp-content/plugins/easysms/images/contribute.jpg" type="image"/>
            </td>
        </tr>
    </table>
</form>

<p class='easysms_text'>&copy; 2008-2009 Brian Fegter - Slick Intermedia</p>
    
</div>