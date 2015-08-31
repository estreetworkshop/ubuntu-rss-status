# ubuntu-rss-status

Generate a Status RSS Feed for your Ubuntu Server.  This was created so that issues with a virtualized Ubuntu server would show up on an RSS feed.  There are no protections on the feed, so this is meant for internal network use only.

# Prerequisites

Run the following command to get the required software to run ubuntu-rss-status

`apt-get install apache2 php5 update-notifier-common git`

This has been tested on Ubuntu 12.04 and 14.04 and on Raspberry Pi Wheezy

# Install

#### Download

Download into your html folder.

#### Configure server.php

Rename server.php.example to server.php.  Edit server.php to reflect your server settings.

#### Configure config.php

Rename config.php.example to config.php.  Uncomment and add in the modules you want to use.  You can run the modules multiple times (for example checking disk space on multiple hard drives).

#### Configure crontab

Add the createrss.php to your crontab.  I suggest running this once a day.  Old RSS items are cleared out of the XML file after running the command.  So your RSS feed reader must check for updates more often than you run the crontab. 

#### Test Configuration

Run `php createrss.php` from the command line.  You can watch the output and see if there are any errors.

# Modules
* Check to see if a reboot is required
* Check to see if there are any updates
* Automatically isntall any updates
* Check for ZFS Zpool Errors
