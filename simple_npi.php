<?php
	
	require_once('filter.php');
	require_once('taxonomy.php');

	if(isset($argv[1])){
		$file = $argv[1];
	}else{
		$file = "npidata_20130513-20130519.csv";	
	}

	if(isset($argv[2])){
		$out_file = $argv[2];
	}else{
		$out_file = "simple_npi.csv";
	}

	if(!file_exists($file)){
		echo "I need the name of the NPPESS download csv file as input...\n";
		exit();

	}

	$taxonomies = array();
	$structure_map = array();
	$file_handle = fopen($file,"r");
	$structure = fgetcsv($file_handle, 100000, ",");
	foreach($structure as $id => $col_name){
		$parens = array ( '(', ')');
		$tmp = str_replace($parens,"",strtolower($col_name));
		$value = str_replace(' ','_',$tmp);
		$structure_map[$id] = $value;
	}

	$new_data_lines = array();

	while (($data_line = fgetcsv($file_handle, 100000, ",")) !== FALSE) {
//	$data_line = fgetcsv($data_handle, 100000, ",");// just get the one.
		$npi = $data_line['0'];
		if(strcmp($npi,'NPI')==0){
			//then this is the header record.
			continue;
		}


		$mapped_line = array();
		foreach($data_line as $id => $data){
			if(strlen($data) > 0){
				//create an array of fields => data
				//NOTE what is the equiv of mysql_real_escape_string in neo4j????
				$mapped_line[$structure_map[$id]] = $data;	

			}//ifstrelen
		}//foreach

		if(strlen($mapped_line['entity_type_code']) == 0){
			//then this NPI is now erased.
			continue;
		}

		$new_line = filter($mapped_line,$filter);
		$new_line['full_name'] = simple_name($mapped_line);
		$new_line['search_name'] = search_name($mapped_line);

		//var_export($new_line);

		$new_line['taxonomy_code'] = 'none';
		$new_line['taxonomy_desc'] = 'none';
		$current_tax_score = 5;
		for($i = 1; $i < 16 ; $i++){
			if(isset($mapped_line["healthcare_provider_taxonomy_code_$i"])){
				$this_tax = $mapped_line["healthcare_provider_taxonomy_code_$i"];
				if(isset($taxonomy[$this_tax])){
					if( $taxonomy[$this_tax]['priority'] < $current_tax_score){ //chose just one but choose the best one...
						$new_line['taxonomy_code'] = $this_tax;
						$new_line['taxonomy_desc'] = $taxonomy[$this_tax]['desc'];
					}
				}else{
				//	echo "$this_tax is missing \n";
				//nothing to be done...
				}
				
			}
		}

		$new_data_lines[] = $new_line;


	}

//	var_export($new_data_lines);

	$keys = array_keys($new_line);


	$fp = fopen($out_file,'w');

	fputcsv($fp,$keys);

	foreach($new_data_lines as $new_line){
		fputcsv($fp,$new_line);
	}	


function filter($mapped_line,$filter){

	$new_array = array();
	foreach($filter as $old_name => $new_name){

		if(isset($mapped_line[$old_name])){
			//then we map...
			$new_array[$new_name] = $mapped_line[$old_name];

		}else{
			$new_array[$new_name] = '';
		}

	}

	return($new_array);

}

function search_name($mapped_line){

	$name = '';
	if($mapped_line['entity_type_code'] == 1){
		//then this is a person...
		$name .= $mapped_line['provider_last_name_legal_name'] . " ";
	}else{
		$name .= $mapped_line['provider_organization_name_legal_business_name'];
	}

	return($name);

}

function simple_name($mapped_line){

	$name = '';
	if($mapped_line['entity_type_code'] == 1){
		//then this is a person...

		if(isset($mapped_line['provider_name_prefix_text'])){
			$name .= $mapped_line['provider_name_prefix_text'] . " ";
		}
		$name .= $mapped_line['provider_first_name'] . " ";
		if(isset($mapped_line['provider_middle_name'])){
			$name .= $mapped_line['provider_middle_name'] . " ";
		}
		$name .= $mapped_line['provider_last_name_legal_name'] . " ";
		if(isset($mapped_line['provider_name_prefix_text'])){
			$name .= $mapped_line['provider_credential_text'] . " ";
		}

	}else{

		$name .= $mapped_line['provider_organization_name_legal_business_name'];

	}


	return($name);

}

?>
