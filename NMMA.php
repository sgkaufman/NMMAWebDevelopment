<?php
echo <<<_END
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<title>The New Mexico Meteor Array</title>
</head>
<body bgcolor="silver">
<H2 ALIGN=CENTER> The New Mexico Meteor Array: Citizen Science Collecting Meteor Data<BR>
for the Global Meteor Network (GMN), using the Raspberry Meteor System (RMS).<BR>
Stations 01 + 02 form the Albuquerque Zenith reference, then sorted by Station Azimuth.<BR><BR>

<a href="NMMA_Captured.php"> View stacks of all images captured throughout the night</a> <BR><BR>
<a href="NMMA_Calib.php"> View Astrometric and Photometric Calibration plots</a> <BR><BR>
<br><br>
<hr style="width:100%;text-align:left;margin-left:0">
_END;

?>

<?php
// Variables used throughout
$dy = date("d");
$mo = date("m");
$yr = date("Y");
$dir_str = "uploads/" . $yr . "/" . $mo . "/" . $dy;
//echo $dir_str;
$status=chdir($dir_str);
//var_dump($status);
//echo "\n";
$date_str = date("Ymd");

// Test the directory
$i = 0;
$glob_str = "*" . $date_str . "*.jpg";
//echo $glob_str;
foreach (glob($glob_str) as $filename) {
    $filenames[$i] = $filename;
    $i++;
}
//var_dump($filenames);
// end test of directory

$stations = array("US0001, Albuquerque South Valley, P. Eschman, Az:350",
			"US0002, Albuquerque South Valley, P. Eschman, Az:180",
			"US000A, Belen, W. Wallace, Az:20",
			"US0008, Los Lunas, S. Welch, Az:30",
			"US000K, Socorro, B. Greschke, Az:40",
			"US0006, Albuquerque NE, S. Kaufman, Az:49",
			"US000C, Magdalena, J. Briggs, Az:68",
			"US000H, Quemado, T. Havens, Az:85",
			"US000E, Albuquerque South Valley, P. Eschman, Az:88",
			"US000N, Albuquerque NE, S. Kaufman, Az:109",
			"US000M, Edgewood, J. Seargeant, Az:145",
			"US0005, Edgewood, J. Seargeant, Az:173",
			"US001L, Creede CO, D. Robinson, Az:183",
			"US0009, Los Lunas, S. Welch, Az:195",
			"US0004, Santa Fe, R. James, Az:211",
			"US000G, GNTO, Az:226",
			"US000R, Los Lunas, S. Welch, Az:265",
			"US000P, Albuquerque N, B. Hufnagel, Az:281",
			"US000D, Albuquerque, J. Fordice, Az:282",
			"US000L, Santa Fe, G. Mroz, Az:287",
			"US0003, Socorro, B. Greschke, Az:318",
			"US000J, Magdalena, E. Toops, Az:343",
			"US001P, Taos, J. Shaffer, Az:357",
			"US0007, Albuquerque N, B. Hufnagel, Az:358"
			);

foreach ($stations as $station) {
	printf ("<h2 align=center>%s&deg</h2>\n", $station); 
	$st = substr($station, 0, 6);
	$glob_str = $st . "*" . "meteors*" . ".jpg";
	//echo $glob_str;
	$fn = glob($glob_str);
	//var_dump($fn);
	$fn=$fn[0];
	echo "<p align=center><small><caption> file: $fn</caption></small></p>";
	$img = $dir_str . "/" . $fn;
	echo "<IMG align=center SRC= " . $img . "><BR><BR><hr style=width:100%;text-align:left;margin-left:0>";
}

?>
</body>
</html>
