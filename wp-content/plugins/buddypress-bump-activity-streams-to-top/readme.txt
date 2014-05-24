=== Plugin Name ===
Contributors: davidgladwin
Donate link: http://gladwinput.com/found-my-code-useful/
Tags: buddypress, activity stream
Requires at least: PHP 5.2, WordPress 3.5.1 BuddyPress 1.5.1
Tested up to: PHP 5.5.5, WordPress 3.7.1, BuddyPress 1.8.1
Stable tag: 1.0.0

This plugin will "bump" an activity record to the top of the stream when activity comment reply is made.

== Description ==

This plugin adds new capability to Buddypress, so activity records are bumped to the top of a stream when a user comments in that activity.

It was originally based on the <a href="http://wordpress.org/plugins/buddypress-activity-stream-bump-to-top/">BuddyPress Activity Stream Bump to Top</a> plugin which has long since (2 years at time of writing) been left unsupported.

Huge thank you to the <a href="http://profiles.wordpress.org/nuprn1/">original author</a> - for the awesome plugin - hopefully I can support it far into the future.



= Related Links: = 

* <a href="http://gladwinput.com" title="Author's Site">Author's Site</a>
* <a href="http://gladwinput.com/buddypress-bumping-activity-streams-to-top-with-new-comments/">Bump Activity Streams To Top - About Page</a>

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate the plugin at the plugin administration page
3. Adjust settings via the Activity Bump admin page

== Frequently Asked Questions ==

= How does it work? =

When a new comment is posted to an activity record - this plugin will copy the original date_recorded to the activity_meta table. The main activity date_recorded is then overwritten with the last activity comment reply date.

== Changelog ==

= 1.0.0 =

* First build and upload.
