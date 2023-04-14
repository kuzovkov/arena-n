<?php

	define('FILENAME', 'order.txt');
	
	if ( isset( $_POST['data'] ) )
	{
		file_put_contents(FILENAME,$_POST['data']);
		echo "Заказ подтвержден";
	}
	else
	{
		echo "Заказ отклонен";
	}
	
	