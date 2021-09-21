<?php
//$handle = fopen('tmp/inputfile.txt', 'r');

function noEmpty($val){
	//return trim($val) ? $val : false;
	if(!$val || $val == '_') {
		return false;
	} else {
		return true;
	}
}

$files = glob(dirname(__FILE__).'/tmp/*.txt');
$files = array_combine($files, array_map('filectime', $files));
arsort($files);


		foreach ($files as $filename => $timestamp) {

			//$filepath = 'tmp/'.basename(key($files));
			$filepath = 'tmp/'.basename($filename);
			//echo $filepath.'<br>';

			$handle = fopen($filepath, 'r');

			if($handle) {

				//$title = '';
				//$ms

				for ($i = 1; !feof($handle); $i++) {

					$line = fgets($handle);

					if($i == 1) {

						//$tmp = array_filter(explode(' ', explode(':', $line)[0]));
						
						//$tmp = array_values(array_filter(explode(' ', $line), "noEmpty"));

						$tmp = array_values(array_filter(preg_split("/[\s]+/", $line), "noEmpty"));

						$ms = '';
						$title = '';
						$msKey = array_search('m/s', $tmp);
						//unset($tmp[count($tmp) - 1]);
						
						if (!in_array($tmp[1], array('Men','Women'))) {
							
							for ($x = 4; $x <= $msKey; $x++) {
								$ms .= $tmp[$x].' ';
							}

							for ($y = 0; $y <= 3; $y++) {
								$title .= $tmp[$y].' ';
							}

						} else {

							for($x = 3; $x <= $msKey; $x++){
								$ms .= $tmp[$x].' ';
							}

							for ($y = 0; $y <= 2; $y++) {
								$title .= $tmp[$y].' ';
							}							

						}

						//continue;
						
						//echo '<pre>';
						//print_r($tmp);
						//echo '</pre>';
						//echo '<br><br>';
						echo 'title: '.$title.'<br>';
						echo 'ms: '.$ms.'<br>--------------<br>';

					}

				}

				fclose($handle);

			}
		}