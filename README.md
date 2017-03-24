# ubuntu-rss-status

Generate a Status RSS Feed for your Ubuntu Server.  This was created so that issues with a virtualized Ubuntu server would show up on an RSS feed.  There are no protections on the feed, so this is meant for internal network use only.

# Prerequisites

Run the following command to get the required software to run ubuntu-rss-status

<b>Ubuntu 12.04, Ubuntu 14.04, Raspbian Wheezy, Raspbian Jessie</b>

`apt-get install apache2 php5 update-notifier-common git`

<b>Ubuntu 16.04</b>

`apt-get install apache2 php update-notifier-common git`

# Install

#### Download

Download into your html folder.

#### Configure server.php

Rename server.php.example to server.php.  Edit server.php to reflect your server settings.

#### Configure config.php

Rename config.php.example to config.php.  Uncomment and add in the modules you want to use.  You can run the modules multiple times (for example checking disk space on multiple hard drives).

#### Configure crontab

Add the createrss.php to your crontab.  I suggest running this once a day.  Old RSS items are cleared out of the XML file after running the command.  So your RSS feed reader must check for updates more often than you run the crontab. If you add this file it will run it once per day.

For 12.04 and Wheezy

`0  0    * * *   root    cd /var/www/rss && php createrss.php`

For 14.04 and Jessie

`0  0    * * *   root    cd /var/www/html/rss && php createrss.php`

#### Test Configuration

Run `php createrss.php` from the command line.  You can watch the output and see if there are any errors.

# Modules
#### aptcheck.php
* Check to see if there are any Ubuntu updates

#### aptupdate.php
* Run apt-get dist-ugprade

#### aptautoremove.php
* Run apt-get remove to remove any unused packages

#### backuppc.php
* Check to see if there are any hosts in BackupPC that are older than the specified limit

#### clamscan.php
* Scan directory for viruses

#### createsqlbackup.php
* Create a backup of an SQL Database

#### diskspace.php
* Check Disk Space

#### freshclam.php
* Update ClamScan Virus scanner

#### rebootcheck.php
* Check to see if a reboot is required

#### selfcheckupdate.php
* Update ubuntu-rss-status from github

#### verifysqlbackup.php
* Verify the SQL backup is valid

#### zpool.php
* Check for ZFS Zpool Errors

#### checksslcert.php
* Check for SSL Certificate expiration.  Must have openssl installed

