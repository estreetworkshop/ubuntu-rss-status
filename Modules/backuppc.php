<?php

	function Module_BackupPC($StatusFeed, $ServerName, $BackupPCURL, $username, $password, $OlderThan)
	{
		$ch = curl_init();
		$timeout = 5;


		curl_setopt($ch, CURLOPT_URL, $BackupPCURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

		$html = curl_exec($ch);
		curl_close($ch);

		# Create a DOM parser object
		$doc = new DOMDocument();

		# Parse the HTML from Google.
		# The @ before the method call suppresses any warnings that
		# loadHTML might throw because of invalid HTML in the page.
		@$doc->loadHTML($html);

		$doc->preserveWhiteSpace = false;


		$tables = $doc ->getElementsByTagName('table');
		$table = $tables->item(0);//takes the first table in dom

		foreach ($table->childNodes as $tr)
		{
			$count = 0;
			foreach ($tr->childNodes as $td)
			{	  
				$count++;
				if ($td->nodeName == 'td')
				{
					if($count == 1)	  
						$host = $td->nodeValue;
					else if($count == 3)
						$user = $td->nodeValue;
					else if($count == 5)
						$numfull = $td->nodeValue;
					else if($count == 7)
						$fullage = $td->nodeValue;			
					else if($count == 9)
						$fullsize = $td->nodeValue;
					else if($count == 11)
						$speed = $td->nodeValue;
					else if($count == 13)
						$numinc = $td->nodeValue;	
					else if($count == 15)
						$incage = $td->nodeValue;	
					else if($count == 17)
						$lastbackup = $td->nodeValue;	
					else if($count == 19)
						$state = $td->nodeValue;	
					else if($count == 21)
						$xfererrors = $td->nodeValue;	
					else if($count == 23)
						$lastattempt = $td->nodeValue;						
				}		
			}
			$Hosts[] = array(
				'host'        => $host,
				'user'        => $user,
				'numfull'     => $numfull,
				'fullage'     => $fullage,
				'fullsize'    => $fullsize,
				'speed'       => $speed,
				'numinc'      => $numinc,
				'incage'      => $incage,
				'lastbackup'  => $lastbackup,
				'state'       => $state,
				'xfererrors'  => $xfererrors,
				'lastattempt' => $lastattempt
			);
		}


		foreach($Hosts as $id)
		{
			echo "Host:" . $id['host'];
			if($id['lastbackup'] > $OlderThan)
			{
				echo ":Too Old!\n";
											
				//Create an empty FeedItem
				$newItem = $StatusFeed->createNewItem();
				  
				//Add elements to the feed item
				//Use wrapper functions to add common feed elements
				$newItem->setTitle('BackupPC - '. $id['host']."'s backup is ".$id['lastbackup']. " days old");
				$newItem->setLink("");
				$newItem->setDate(time());
				$newItem->setDescription("BackupPC Host has old backup file");
				$newItem->addElement('author', $ServerName);
				$newItem->addElement('guid', $ServerName ."BackupPC" . time() . rand(), array('isPermaLink'=>'true'));
				  
				//Now add the feed item
				$StatusFeed->addItem($newItem);
			}				
			else
				echo ":Fine\n";

		}
	}
	

?>
