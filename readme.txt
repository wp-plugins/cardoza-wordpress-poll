=== Cardoza Worpress Poll ===
Contributors: Vinoj Cardoza
Tags: poll, cardoza, vote, widget, booth, polls, polling
Requires at least: 3.0
Tested up to: 3.3
Stable tag: trunk
License: GPLv2 or later

Cardoza Wordpress Poll is completely ajax powered polling system. This poll plugin supports both single and multiple selection of answers.

== Description ==
This poll is developed using MVC framework which uses both ajax and jquery.

1. You have options to display more than 1 poll in the widget area.
2. You can specify how many polls to be displayed in the archive page.

= Version 0.4 (New Features) =
* Poll archive page displays the poll id, poll duration and poll status (Suggested by : Bill Ford, Founder of JoshuaTreeStar.com)
* New option 'View Result' added to the 'Manage Polls' page to enable the administrator to see the poll results from Wordpress backend (Suggested by: Amber).
* See Previous Polls changes to See polls & results

= Note =
1. If you find any bugs, please report in the following link, so that it will be fixed as quick as possible.
2. If you think any feature adding to this plugin can improve its features, please recommend it in the following link.
3. You can add any poll into your post or page by using the shortcode. For information how to do it, please go to Frequently asked questions.

= Donations =

Hello guys,I spent most of my free time creating, updating, maintaining and supporting these plugins, 
if you really love my plugins and could spare me a couple of bucks, I will really appericiate it. To donate visit
my site http://fingerfish.com. If not feel free to use it without any obligations.

For more visit: http://fingerfish.com/cardoza-wordpress-poll/

== Installation ==

1. Download the plugin.
2. Upload to your blog (/wp-content/plugins/).
3. Activate it.
4. Click the Appearance menu and click the Cardoza Poll.
6. Fill in the options.
a. Create new poll by clicking Add new poll.
b. You can setup the widget options by clicking 'Widget Options'.
c. Poll options should be filled and saved before starting to display the first poll.
d. Use 'Manage polls' to edit and delete polls.
7. Then go to widget and drag and drop Cardoza's Wordpress Poll in the area you want to display the plugin.

Important Note: It is mandatory to save all the mandatory field options in this plugin.

= Creating archive poll page =
1. Go to WP-Admin -> Pages -> Add New.
2. Type any title you like in the post's title area and paste the following shortcode in the page content [cardoza_wp_poll_archive]
3. WordPress will generate the link to the page. Copy the link.
4. Go to poll options in 'Cardoza Poll'
5. Click the Poll options tab.
6. Paste the archive page link in 'Poll archive URL'.
7. Save the options.

You're done!

Uninstalling is as simple as deactivating the plugin.

== Screenshots ==

1. screenshot-1.gif
2. screenshot-2.gif
3. screenshot-3.gif
4. screenshot-4.gif
5. screenshot-5.gif
6. screenshot-6.gif

== Frequently Asked Questions ==

= How do I display a particular poll in a page or post? =
Its very simple to add poll in any page or post in your site.

1. The shortcode for displaying the poll is as simple as copying the following code and paste it in your post or page.
[cardoza_wp_poll id=poll_id]

poll_id - this the ID of the poll which you can find it on the 'Manage Polls' of your poll plugin page.

For eg: If I want to display the poll where the ID is 19 then the shortcode will be
[cardoza_wp_poll id=19]

That's it. Check your page or post now.

= How do I check the results without polling myself? =
1. Go to Polls in your Wordpress backend.
2. Click the Manage Polls tab.
3. Now you can see the list of polls.
4. The last colum of the table will have a button 'View Result'.
5. Click 'View Result'.
6. Once clicked it will display the poll result.

if you have any queries post it at http://fingerfish.com/cardoza-wordpress-poll

== Change Log ==

= Version 0.4 (released 20-02-2012) =
* Poll archive page displays the poll id, poll duration and status (Credit: Bill Ford, Founder of JoshuaTreeStar.com)
* See Previous Polls changes to See polls & results
* New option 'View Result' added to the 'Manage Polls' page to enable the administrator to see the poll results from Wordpress backend.

= Version 0.3 (released 17-02-2012) =
* New feature added - Shortcode can be added on any page or post to display a particular poll.
* Minor-bug for displaying poll results as soon as voted fixed.

= Version 0.2 (released 15-02-2012) =
* Pagination on the archive poll page validated.
* A seperate function file created to manipulate the front end functions.

