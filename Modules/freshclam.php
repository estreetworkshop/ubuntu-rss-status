<?php
	function Module_FreshClam($StatusFeed, $ServerName)
	{
		echo "----------------------------------------\n";
		echo "Updating ClamAV...";
		echo "Stopping ClavAV\n";		
		exec("/etc/init.d/clamav-freshclam stop");

		exec("freshclam", $output, $result);
		echo "Result = " . $result . " (0=Good)\n";
		echo "Starting ClavAV\n";
		exec("/etc/init.d/clamav-freshclam start");
		
		if( $result !== 0) 
		{
			echo "Adding RSS Item FreshClam Update Fail\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('FreshClam Update Failed!');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("FreshClam Update Failed");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."FreshClam" . time() . rand(), array('isPermaLink'=>'true'));
			$StatusFeed->addItem($newItem);
		}
		
	}
?>
