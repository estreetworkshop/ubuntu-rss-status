<?php
	function Module_SelfCheckUpdate($StatusFeed, $ServerName, $Directory, $Update)
	{
		echo "----------------------------------------\n";				
		echo "Checking to see if update required...\n";
		// Update Git
		exec("cd ". $Directory. " && git remote update", $output, $result);
		
		// Get Installed Revision Number		
		exec("cd ". $Directory. " && git rev-parse @{0}", $output, $result);
		$CurrentRev = $output[1];		
		echo "Current=". $CurrentRev ."\n";
		
		// Get Latest Revision Number
		exec("cd ". $Directory. " && git rev-parse @{u}", $output, $result);
		$RemoteRev = $output[2];		
		echo "Remote=". $RemoteRev ."\n";
		
		if($CurrentRev === $RemoteRev)
		{
			echo "Version Already Up to date\n";
		}
		else
		{
			if($Update == false)
			{
				echo "Adding RSS Item to prompt update\n";
				//Create an empty FeedItem
				$newItem = $StatusFeed->createNewItem();
				$newItem->setTitle('Need to run git pull on rss feed');
				$newItem->setLink("");
				$newItem->setDate(time());
				$newItem->setDescription("RSS Feed Software Out of Date");
				$newItem->addElement('author', $ServerName);
				$newItem->addElement('guid', $ServerName ."SelfCheck" . time() . rand() ,array('isPermaLink'=>'true'));
				  
				//Now add the feed item
				$StatusFeed->addItem($newItem);				
			}
			else
			{
				exec("cd ". $Directory. " && git fetch origin master", $output, $result);
				exec("cd ". $Directory. " && git reset --hard FETCH_HEAD", $output, $result);
				
				echo "Adding RSS Item for installed update\n";
				//Create an empty FeedItem
				$newItem = $StatusFeed->createNewItem();
				$newItem->setTitle('RSS Feed Software has been updated to newest version');
				$newItem->setLink("");
				$newItem->setDate(time());
				$newItem->setDescription("Updated");
				$newItem->addElement('author', $ServerName);
				$newItem->addElement('guid', $ServerName ."SelfCheck" . time() . rand() ,array('isPermaLink'=>'true'));
				  
				//Now add the feed item
				$StatusFeed->addItem($newItem);
			}
		}
		
		
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