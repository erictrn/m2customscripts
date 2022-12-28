<?php
$row = 1;
$csv301FileInput = '301_file.csv';
$csv301FileOutput = '301_file_out.php';
$urlArray = [];
$firstRowSkip = true;
$saleFile = false;

if(file_exists($csv301FileInput)) {
	if ( ( $handle = fopen( $csv301FileInput, "r" ) ) !== false ) {
		while ( ( $data = fgetcsv( $handle, 10000, "," ) ) !== false ) {

			if($firstRowSkip) {
				$firstRowSkip = false;
				continue;
			}

			if(count($data) > 1) {
				$urlFrom = str_replace('www.', '', str_replace('http://', '', $data[0]));
				$urlFrom = substr($urlFrom, strpos($urlFrom, '/'), strlen($urlFrom));

				$urlTo = str_replace('www.', '', str_replace('http://', '', $data[1]));
				$urlTo = substr($urlTo, strpos($urlTo, '/'), strlen($urlTo));

				/*$domainFrom = parse_url($urlFrom);
				$domainTo = parse_url($urlTo);


				if(strpos($urlFrom, 'urdetrsi24gl6.html') !== false) {
					print_r($domainTo);die(__FILE__ . ' - ' . __LINE__);
				}


				if(isset($domainFrom['scheme'])) {
					unset( $domainFrom['scheme'] );
				}
				if(isset($domainFrom['host'])) {
					unset( $domainFrom['host'] );
				}
				if(isset($domainTo['scheme'])) {
					unset( $domainTo['scheme'] );
				}
				if(isset($domainTo['host'])) {
					unset( $domainTo['host'] );
				}
				$finalUrlFrom = implode('/', $domainFrom);
				$finalUrlTo = implode('/', $domainTo);*/

				$urlArray[$urlFrom] = $urlTo;

			}
		}
		fclose( $handle );
	}

	if(count($urlArray)) {
		$output = '<?php' . "\n";
		$output .= '$urls_redirect = array(' . "\n";
		foreach ($urlArray as $from => $to) {
			$output .= "\t" . '"' . $from . '" ' . "\t\t" . '=>' . "\t" . ' "' . $to . '",' . "\n";
		}
		$output .= ');' . "\n";

		if($saleFile) {
			file_put_contents( $csv301FileOutput, $output );
			echo "File $csv301FileOutput successfully created!";
		}
		else {
			echo $output;
		}
	}

	//print_r($urlArray);die(__FILE__ . ' - ' . __LINE__);
}
else {
	echo '<h1>301 CSV file not found. Please put it in the same folder with this script!</h1>';
}