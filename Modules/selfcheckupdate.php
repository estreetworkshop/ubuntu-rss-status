<?php
	function Module_SelfCheckUpdate($StatusFeed, $ServerName, $Directory, $Update)
	{
		echo "----------------------------------------\n";				
		echo "Checking to see if update required...\n";
		// Update Git
		exec("cd ". $Directory. " && git remote update", $output, $result);
		// Get Installed Revision Number		
		exec("cd ". $Directory. " && git rev-parse @{0}", $output, $result);
		$CurrentRev = $output[0];		
		echo "Current=". $CurrentRev ."\n";
		// Get Latest Revision Number
		exec("cd ". $Directory. " && git rev-parse @{u}", $output, $result);
		$RemoteRev = $output[0];		
		echo "Remote=". $RemoteRev ."\n";
		
		
		/*if (file_exists("/var/run/reboot-required") === true)
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
		}*/
	}
?>