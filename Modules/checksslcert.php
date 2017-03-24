<?php
	function Module_CheckSSLCert($StatusFeed, $ServerName, $CertLocation, $ExpireDays)
	{
		echo "----------------------------------------\n";
		
        $output = shell_exec("openssl x509 -noout -subject -in ". $CertLocation);
        $domain  = substr($output, strpos($output, "/CN=")+4);
        $domain = substr($domain, 0, strlen($domain) -1);
        echo "Checking Cert for ".$domain."...\n";
        
		$output = shell_exec("openssl x509 -noout -dates -in ". $CertLocation);			
		$formatted = substr($output, strpos($output, "notAfter=")+9);
        $formatted = substr($formatted, 0, strlen($formatted) -1);
        $date = date_create_from_format('M d H:i:s Y T', $formatted);
        
        echo "          Expires : " . date_format($date, 'M d H:i:s Y T'). "\n";
              
        $now = new DateTime(); // or your date as well

        $diff = $date->diff($now)->format("%a");

        echo "Days until Expire : " . $diff . "\n";
        
		if($diff < $ExpireDays)
		{
			echo "Adding RSS Item for Expiring SSL\n";
			$newItem = $StatusFeed->createNewItem();
			$newItem->setTitle('SSL Expiring Soon');
			$newItem->setLink("");
			$newItem->setDate(time());
			$newItem->setDescription("SSL Cert for " . $domain . " expires in " . $diff . " days");
			$newItem->addElement('author', $ServerName);
			$newItem->addElement('guid', $ServerName ."checksslcert" . time() . rand() ,array('isPermaLink'=>'true'));
			  
			//Now add the feed item
			$StatusFeed->addItem($newItem);
		}
	}
?>