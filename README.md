# videosync
Videosynced player, created to watch movies synced in Tower Unite.
Pretty messy code :(

# Requirements:
- PHP 7+
- MariaDB/Mysql 10+

# Quick guide:
Create a new database and call it videosync, then import videosync_database.sql into this database.
Edit both files: inc/database.php and inc/dbfunctions.php and change <USERNAME> and <PASSWORD> to reflect the correct username and password for the database in following the line:

$this->dbconn = new PDO("mysql:dbname=videosync;host=localhost", "<USERNAME>","<PASSWORD>");
  
If you want to modify the password for the master account, go within your browser to domainwhereitisuploaded.com/path/to/videosync/createpassword.php?pw=<YOURNEWPASSWORD> (change <YOURNEWPASSWORD> to the password you want) Replace <HASH> with the hash from this url and update the password hash with the following mysql query: 

UPDATE `users` SET `password` = '<HASH>' WHERE `users`.`userid` = 1;

# Accessing:

Go to domainwhereitisuploaded.com/path/to/videosync/index.php default username is videosyncmaster and default password is Str0ngPassw0rd

# Create room

Once logged in, press Create Room, it will add a new room. When you click on GO it will open a new tab/window as Master. Click on copy link to get the client URL.

This URL can be entered in Tower Unite media player so everyone is getting synced. Once you place a link to the video in the master tab and press GO, it will sync up everyone and set the video to paused. Once starting play back, I recommend muting the master tab when you watch the video in Tower Unite.

Keep the master window open, as new clients joining would have to sync with master. Otherwise, they will start at the point where master left off.

# Video types:

Videos should be converted to webm format as unity or tower unite is restricted to limited amount of formats.

# Notes:
Functions may not work and needs to be changed. I do not have much time for this so it might take a while before it is added. Feel free to commit changes to help and improve.
Basic functions to make a room and host videos works, which was most important. Noticed deleting rooms did not work, and no option to change password from the UI.
