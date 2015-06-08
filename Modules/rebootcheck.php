<?php
	function Module_RebootCheck($StatusFeed, $ServerName)
	{
		echo "----------------------------------------\n";
		echo "Checking to see if reboot required...\n";
		
		if (file_exists("/var/run/reboot-required") === true)
		{
			echo "Adding RSS Item for Reboot\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('Reboot Required');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("Reboot Required");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."RebootCheck" . time() . rand() ,array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
	}
?>