<?php
	echo 'Date: ' . date('d:m:Y H:i:s', time()) . '<br/>';
	$handle = fopen("/etc/php5/apache2/php.ini", "r");
	while (!feof($handle)) {
		$buffer = fgets($handle, 4096);
		echo $buffer . '<br/>';
	}
	fclose($handle);

	phpinfo();