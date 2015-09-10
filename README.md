Simple CMS v0.1

=================================

This is built as a simple CMS to use with small or one page websites.
Fully commented for you to learn

This is designed to be simple for people new to php or needing a simple solution package

How to use it:

 - Make a new database (note the database name user, password and host)
 - Add those details into the /admin/config.php
 - run the db.sql in your phpMyAdmin or command line
 - upload the site to your hosting
 - go to yourwebsite.com/admin and log in with username:demo and password:demo
 - using the users tab create a new secure log on and remove the demo log on
 
 You are now free to write your own site in index.php. Put all your webcode where prompted.
 To pull text from the database create it in the /admin UI and in your index code use <?php echo $r[x]; ?> where x is equal to the ID available in the /admin ui. There is some simple code already in the index.php you can use as reference for functionality

if you have any questions or requests fire a message at: me@simonharris.co


Planned updates (no order announced):
- full form validation in admin panel
- privilidge levels for users
- consider the options for multipage websites e.g. one table per page or linear array
- uploading and modifying of pictures
- brute force protection for login
- improve clarity of formatting of the input fields