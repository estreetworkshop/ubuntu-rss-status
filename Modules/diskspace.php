<?php
	function Module_CheckDiskSpace($StatusFeed, $ServerName, $mount, $space)
	{
		echo "----------------------------------------\n";
		echo "Checking Disk Space on " . $mount . "\n";
		$total = disk_total_space($mount);
		$free = disk_free_space($mount);
		$used = round(($total-$free)/$total*100, 0);		
		echo "Used = ".$used."%\n";
	if($used > $space)
	{
		echo "Adding RSS Item for Disk Space\n";
		//Create an empty FeedItem
		$newItem = $StatusFeed->createNewItem();
		$newItem->setTitle('Disk Space Low');
		$newItem->setLink("");
		$newItem->setDate(time());
		$newItem->setDescription("Disk space at " . $used ."% on " . $mount);
		$newItem->addElement('author', $ServerName);
		$newItem->addElement('guid', $ServerName ."DiskSpace" . time() . rand(), array('isPermaLink'=>'true'));
		  
		//Now add the feed item
		$StatusFeed->addItem($newItem);
	}		
	}
?>