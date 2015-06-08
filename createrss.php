<?php
	include("server.php");
	include("FeedWriter/FeedTypes.php");
	
	foreach (glob("Modules/*.php") as $filename)
	{
		include $filename;
	}
	//include("Modules/diskspace.php");
	//include("Modules/aptcheck.php");	
  
	//Creating an instance of RSS2FeedWriter class. 
	//The constant RSS2 is passed to mention the version
	$StatusFeed   = new RSS2FeedWriter();
	
	$StatusFeed->setTitle($ServerName);
	$StatusFeed->setLink($ServerRSSLink . "status.xml");
	$StatusFeed->setDescription($ServerDescription);
	//$StatusFeed->setImage('Status Feed',$ServerRSSLink . "status.xml",$ServerRSSLink . "error.jpg");
	
	//Use core setChannelElement() function for other optional channels
	$StatusFeed->setChannelElement('language', 'en-us');
	$StatusFeed->setChannelElement('pubDate', date(DATE_RSS, time()));
	  	
	echo "----------------------------------------\n";
	echo "Checking Lock File...";
	if(!file_exists("createrss.lock"))
	{
		// If No Lock File
		echo "No Lock File...\n";
		exec("touch createrss.lock");
		echo "Lock File Created\n\r";
		
		
		include("config.php");
		echo "----------------------------------------\n";
		echo "Removing Lock File\n";
		exec("rm createrss.lock");
	}
	else
	{
		echo "Lock File Exists!\n\r";
		echo "Adding RSS Item for Stuck Lock File\n";
		$newItem = $StatusFeed->createNewItem();
		$newItem->setTitle('Stuck Lock File');
		$newItem->setLink("");
		$newItem->setDate(time());
		$newItem->setDescription("Lock File Exists.");
		$newItem->addElement('author', $ServerName);
		$newItem->addElement('guid', $ServerName ."StuckLock" . time() . rand() ,array('isPermaLink'=>'true'));
			  
		//Now add the feed item
		$StatusFeed->addItem($newItem);
	}		
	echo "----------------------------------------\n";
	
	fclose(STDOUT);
	$STDOUT = fopen("status.xml", 'wb');  
	$StatusFeed->generateFeed();
	
?>
