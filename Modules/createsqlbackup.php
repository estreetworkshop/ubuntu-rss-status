<?php
	function Module_CreateSQLBackup($StatusFeed, $ServerName, $location, $dbname, $dbuser, $dbpass)
	{
		echo "----------------------------------------\n";
		echo "Create SQL Backup...\n";
		shell_exec("rm ". $location ."/*.bak");
		exec("mysqldump --lock-tables -h localhost -u " . $dbuser . " -p". $dbpass. " " . $dbname . " > ". $location . "/".$dbname."-sqlbkp_`date +\"%Y%m%d\"`.bak 2>&1", $output, $ret);
		
		if( $ret !== 0 )
		{		
			echo "Adding RSS Item for SQL Backup Error\n";
			//Create an empty FeedItem
			$newItem = $StatusFeed->createNewItem();
			  
			//Add elements to the feed item
			//Use wrapper functions to add common feed elements
			$newItem->setTitle('SQL Backup Error');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("SQL Backup Error");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."SQLBackup" . time() . rand(), array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
		else			
		{
			echo "No SQL Error\n";
			
		}
	}
?>
