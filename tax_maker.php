<?php
	
	require_once('filter.php');

	$file = "taxonomycode.csv";

	$priority = 3;
	$tax_array = array();
	$file_handle = fopen($file,"r");
	while (($data_line = fgetcsv($file_handle, 100000, ",")) !== FALSE) {
//	$data_line = fgetcsv($data_handle, 100000, ",");// just get the one.
		$code = $data_line['0'];
		$desc = $data_line['1'];

		if(strcmp(strtolower($desc),strtolower('NULL')) == 0){
			$desc = $code;
		}

		$temp = array(
			'desc' => $desc,
			'priority' => $priority,
			);
		
		$tax_array[$code] = $temp;
		
	}

	echo "<?php \n\n\n \$taxonomy = ";
	var_export($tax_array);
	echo ";\n\n ?>";

?>
