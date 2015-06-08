<?php
	function Module_ZpoolStatus($StatusFeed, $ServerName, $mount)
	{
		echo "----------------------------------------\n";
		echo "Zpool Status...\n";
		$output = shell_exec("zpool status " . $mount);
		
		if( (strpos($output, "DEGRADED") !== false) or 
			(strpos($output, "FAULTED") !== false) or 
			(strpos($output, "OFFLINE") !== false) or 
			(strpos($output, "UNAVAIL") !== false) or 
			(strpos($output, "action") !== false) or 
			(strpos($output, "ERROR") !== false) or 
			(strpos($output, "REMOVED") !== false)) 		
		{
			echo "Adding RSS Item for Degraded Zpool\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('DEGRADED ZPOOL!');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("DEGRADED ZPOOL on " . $mount);
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."ZpoolStatus" . time() . rand(), array('isPermaLink'=>'true'));
			$StatusFeed->addItem($newItem);
		}
	}
?>