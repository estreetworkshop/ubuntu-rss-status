<?php
	function Module_AptCheck($StatusFeed, $ServerName)
	{
		echo "----------------------------------------\n";
		echo "Checking for updates...\n";
		$output = shell_exec("/usr/lib/update-notifier/apt-check --human-readable");
		$arr = explode("\n", $output);	
		$pos = strpos($arr[0], " ");
		$packageupdates = substr($arr[0], 0, $pos);
		$pos = strpos($arr[1], " ");
		$securityupdates = substr($arr[1], 0, $pos);

		echo $packageupdates . " package updates. \n";
		echo $securityupdates . " security updates. \n";
		
		if($packageupdates > 0 or  $securityupdates > 0)
		{
			echo "Adding RSS Item for Updates\n";
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('Updates Required');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription($packageupdates . " package updates.<br>". $securityupdates . " security updates.");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."AptCheck" . time() . rand() ,array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
	}
?>