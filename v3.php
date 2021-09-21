<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
//$handle = fopen('tmp/inputfile.txt', 'r');

$files = glob(dirname(__FILE__).'/tmp/*.txt');
$files = array_combine($files, array_map('filectime', $files));
arsort($files);

function noBullshit($val){
	//return trim($val) ? $val : false;
	if(!$val || $val == '_') {
		return false;
	} else {
		return true;
	}
}

?>

<html>
<head>
	<title>Text to HTML Table</title>

	<!-- CSS only -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<!-- JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>	
</head>
<body>
	<div class="container-fluid">
	<?php

		foreach ($files as $filename => $timestamp) {

			//$filepath = 'tmp/'.basename(key($files));
			$filepath = 'tmp/'.basename($filename);
			//echo $filepath.'<br>';

			$handle = fopen($filepath, 'r');

			if($handle) {

				$title = '';
				$ms = '';
				$tablebody = array();

				for ($i = 1; !feof($handle); $i++) {

					$line = trim(fgets($handle));

					if(!$line) continue; // skip the line if it is blank. error fix

					if($i == 1) {

						//$tmp = array_filter(explode(' ', explode(':', $line)[0]));

						//unset($tmp[count($tmp) - 1]);
						
						//$tmp = array_slice(array_filter(preg_split("/[\s]+/", $line), "noBullshit"), 0, 4);
						$tmp = array_values(array_filter(preg_split("/[\s]+/", $line), "noBullshit"));

						$msKey = array_search('m/s', $tmp);

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

						//foreach($tmp as $k => $v){
						//	$title .= $v.' ';
						//}

						continue; 	// this is required to block executing the $tablebody[] statement (for line 1)

					}

					$tablebody[] = explode("\t", $line);

				}

				fclose($handle);

				?>
						<h1><?=str_replace('_', ' ', $title).' ( '.$ms.' )'?></h1>
						<table class="table">
							<tr>
								<th scope="col">Place</th>
								<th scope="col">Lane</th>
								<th scope="col">Performance</th>
							</tr>
							<?php foreach($tablebody as $row): ?>
								<tr>
									<td><?=$row[0]?></td>
									<td><?=$row[1]?></td>
									<td><?=$row[2]?></td>
								</tr>
							<?php endforeach; ?>
						</table>						
				<?php

			}
		}

	?>		

	</div>
</body>
</html>