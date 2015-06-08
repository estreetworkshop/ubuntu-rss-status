<?php
	function Module_ClamScan($StatusFeed, $ServerName, $Directory, $ScanName)
	{
		echo "----------------------------------------\n";
		echo "Running Virus Check...\n";		
		exec("clamscan -i -l /var/log/ClamScan-".$ScanName.".log -r " . $Directory, $output, $result);
		echo "Result = " . $result . " (0=Good)\n";
		
		if( $result !== 0) 
		{
			echo "Adding RSS Item ClamScan Virus\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('ClamScan Found Virus!');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("ClamScan Found Virus in ".$Directory);
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."ClamScan" . time() . rand(), array('isPermaLink'=>'true'));
			$StatusFeed->addItem($newItem);
		}
		
	}
?>