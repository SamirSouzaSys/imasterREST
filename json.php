<?php
	//Uma simples saída JSON
	$object = new stdclass();
	$object->mensagem = "Hello World!";
	echo json_encode($object);
	?>