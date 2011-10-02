=== EasySMS ===
Contributors: misternifty
Tags: ajax, sms, txt, messaging, mobile, subscribe, widget, form, text, cell, phone, broadcast, communicate, groups, carriers, text message, subscribe, unsubscribe, easysms, international, post, category, group
Requires at least: 2.8
Tested up to: 2.8
Stable tag: 2.0.7.2

EasySMS provides an easy way for readers to subscribe to SMS updates and for admins to send SMS messages to groups. Auto SMS with post publishing.

== Description ==

ESMS message your readers and broadcast a new post to user cell phones.  User group organization.  Add custom carriers.  This plugin is great for organizations or churches to stay in touch with their employees, volunteers, or constituents. 

Features:

*   Owner Verification of cell phones with unsubscribe feature
*   AJAX sidebar widget form with custom title and terms of agreement.
*   Subscriber groups
*   Track how many SMS message have been sent to each subscriber.
*   Auto-notification of new posts to subscribers (optional)
*   Custom text messages from admins only
*   Message preview before sending SMS
*   80 default carriers
*   Delete/Add/Edit and Carriers
*   Most international carriers supported!
*   Edit/Delete Subscribers
*   WP Administration compatible interface.
*   Stats snapshot on dashboard.
*   New subscriber notification. (optional)
*   Embeddable Form using [easysms] on any post or page.

Future Features:

*   Personalized SMS messages.
*   Public groups.
*   Manually confirm numbers.
*   Bulk actions for carriers and subscribers.

Changelog:

*   10/10/09 - Widget upgraded to WP 2.8 Widget API and combined in original plugin. Widget TOS depracated due to public request.
*   6/10/09 - Post publish fixed for auto SMS only on publish, not on update.
*   1/13/09 - AJAX fixed for all platforms. Post publish fixed.
*   12/23/08 - Fixed AJAX form to work on WP not hosted in root.
*   12/23/08 - Fixed CSS bugs. Added Style tab to edit CSS from WP admin panel.
*   12/21/08 - Added AJAX sidebar widget and embed form.  Hide terms of use option.
*   12/12/08 - Rearranged entire interface with EasySMS as its own tab.  Added groups feature.  Added Carrier/Groups/Subscriber tables for easy editing adding, and deleting. Created a sidebar widget form.  Conversion function to convert previously registered subscribers to new easysms db table.
*   11/04/08 - Moved the message center to the "Write" tab and the subscription to the profile tab. Fixed logout bug.



Copyright 2008 [Mister Nifty](http://www.misternifty.com/easysms/ "Mister Nifty")

== Installation ==

1. Upload the `easysms` folder to the `../wp-content/plugins/` directory
1. Activate the EasySMS through the 'Plugins' menu in WordPress
1. Activate the EasySMS sidebar widget.
1. Set your widget preferences after adding the sidebar widget.
1. Set your preferences under EasySMS -> Settings
1. Users can subscribe via the sidebar on your website.
1. If you want the form to appear on a page simple type [easysms] and the form will be embedded on that page or post.
1. Insert `<?php do_action('easysms_form'); ?>` into your template.
1. To send a TXT message, click the Write tab or go to the EasySMS tab.

== Frequently Asked Questions ==

= Can I import phone numbers into EasySMS? =

No, because that is illegal.  A person must subscribe to SMS updates because they might incur charges from their carrier.  If you add them without their consent, they could possibly come back on you with litigation for the charges and hassle.

= Can any user send a txt message from the dashboard? =

No, only administrators will see the messaging center.

= When do users get notified of a post? =

When you publish a post or save a published post if the post publish option is selected under EasySMS -> Settings

= Can a user unsubscribe? =

Yes, a user can unsubscribe at their will via the sidebar widget.

= Can I group subscribers? =

Yes, simply click on the EasySMS tab and click groups, or edit an individual subscriber to add them to groups.s

== Screenshots ==

1. Sidebar Widget Form
2. Send a Message
3. Carriers Table
4. Groups Table
5. Subscriber Groups
6. Settings


