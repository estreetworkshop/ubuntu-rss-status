<?php
	function Module_AptUpdate($StatusFeed, $ServerName)
	{
		echo "----------------------------------------\n";
		echo "Running Apt-get update\n";
		$output = shell_exec("apt-get update");		
		echo "Checking for updates...\n";		
		$output = shell_exec("/usr/lib/update-notifier/apt-check --human-readable");
		//$output = "0 fds\n1 fd\n";
		$arr = explode("\n", $output);	
		$pos = strpos($arr[0], " ");
		$packageupdates = substr($arr[0], 0, $pos);
		$pos = strpos($arr[1], " ");
		$securityupdates = substr($arr[1], 0, $pos);

		echo $packageupdates . " package updates. \n";
		echo $securityupdates . " security updates. \n";		
		
		if($packageupdates > 0 or  $securityupdates > 0)
		{
			echo "There are updates to install...\n";
			echo "Running Apt-get dist-upgrade\n";
			$output = shell_exec("apt-get dist-upgrade -y");
		
			echo "Adding RSS Item for Installed Updates\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('Installed Updates');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("Installed " . $packageupdates . " package updates.<br>". $securityupdates . " security updates.");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."AptUpdate" . time() . rand() ,array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
		else
		{
			echo "There are no updates to install.\n";
		}
	}
?>