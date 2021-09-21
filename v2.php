<?php
//$handle = fopen('tmp/inputfile.txt', 'r');

$files = glob(dirname(__FILE__).'/tmp/*.txt');
$files = array_combine($files, array_map('filectime', $files));
arsort($files);

$filepath = 'tmp/'.basename(key($files));

$handle = fopen($filepath, 'r');

if($handle) {

	$title = '';
	$tablebody = array();

	for ($i = 1; !feof($handle); $i++) {

		$line = fgets($handle);

		if($i == 1) {

			$tmp = array_filter(explode(' ', explode(':', $line)[0]));

			unset($tmp[count($tmp) - 1]);

			foreach($tmp as $val){
				$title .= $val;
			}

			continue;

		}

		$tablebody[] = explode("\t", $line);

	}

	fclose($handle);

}

?>

<html>
<head>
	<title>Text to HTML Table</title>
</head>
<body>
	<div class="wrapper">
		<h3><?=str_replace('_', ' ', $title)?></h3>
		<table>
			<tr>
				<th>Place</th>
				<th>Lane</th>
				<th>Performance</th>
			</tr>
			<?php foreach($tablebody as $row): ?>
				<tr>
					<td><?=$row[0]?></td>
					<td><?=$row[1]?></td>
					<td><?=$row[2]?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</body>
</html>