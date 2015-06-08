<?php
	function Module_VerifySQLBackup($StatusFeed, $ServerName, $location, $name)
	{
		echo "----------------------------------------\n";
		echo "Verifying SQL Backup...\n";
		$errorcount = 0;
		$errors = "";
		
		$files = scandir($location);
		$totalfilecount = count($files);
		$filenumber = 0;
		$count = 0;
		
		for($i=0;$i<$totalfilecount;$i++)
		{
			if(strpos($files[$i], $name) !== false)
			{
				$filenumber = $i;
				$count++;
			}	
		}
		
		echo "File = " . $files[$filenumber] . "\n";
		echo "Total Files = " . $count . "\n";
		
		$underscore = strpos($files[$filenumber], "_");
		$backupyear = substr($files[$filenumber], $underscore+ 1, 4);
		$backupmonth = substr($files[$filenumber], $underscore + 5, 2);
		$backupday = substr($files[$filenumber], $underscore + 7, 2);		
		
		echo "Backup Year = " . $backupyear . "\n";		
		echo "Backup Month = " . $backupmonth . "\n";
		echo "Backup Day = " . $backupday . "\n";
		
		$curenttime = time();
		$currentyear = date('Y');
		$currentmonth = date('m');
		$currentday = date('d');
		
		echo "Backup Year = " . $currentyear . "\n";		
		echo "Backup Month = " . $currentmonth . "\n";
		echo "Backup Day = " . $currentday . "\n";
		
		if($backupyear != $currentyear or $currentmonth != $backupmonth or $backupday != $currentday)
		{
			$errorcount++;
			$errors = $errors . " Backup Date Incorrect! ";
		}
		
		if($count > 1)
		{
			$errorcount++;
			$errors = $errors . " Too Many Backup Files! ";		
		}
		
		if($count == 0)
		{
			$errorcount++;
			$errors = $errors . " Missing Backup File! ";		
		}
		
		
		if($errorcount == 0)
		{
			echo "No Errors\n" ;
		}
		else
		{
			echo "Errors are: " . $errors . "\n";
		
			echo "Adding RSS Item for SQL Backup \n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			  
			//Add elements to the feed item
			//Use wrapper functions to add common feed elements
			$newItem->setTitle('SQL Backup Error');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("Errors are: " . $errors);
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."SQLBackup" . time() . rand(), array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
	}
?>