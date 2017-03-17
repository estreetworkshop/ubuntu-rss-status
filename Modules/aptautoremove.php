<?php
	function Module_AptAutoRemove($StatusFeed, $ServerName)
	{
		echo "----------------------------------------\n";
		echo "Checking for Apt-get autoremove packages\n";
		$output = shell_exec("apt-get --dry-run autoremove | grep -Po '^Remv \K[^ ]+'");			
		$lines_arr = preg_split('/\n|\r/',$output);
        $num_newlines = count($lines_arr); 
        echo "There are " . ($num_newlines-1) . " packages to autoremove\n";
        
        if($num_newlines > 1)
        {
            echo "Auto-removing... \n";        
            shell_exec("apt-get -y autoremove");
        }
		
		if($num_newlines > 1)
		{
			echo "Adding RSS Item for AutoRemove\n";
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('Auto Removed Packages');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("Removed: <br>" . $output);
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."AptRemove" . time() . rand() ,array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
	}
?>