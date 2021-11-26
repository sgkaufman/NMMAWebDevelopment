//<?php
//require_once(__DIR__ . 'calendar/classes/tc_calendar.php');
//?>
<!DOCTYPE html>
<html>
  <head>
    <title>New Mexico Meteor Array</title>
    <script language="javascript" src="calendar/calendar.js"></script>
    <link href="calendar/calendar.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <h1>The New Mexico Meteor Array</h1>
    <form id="form1" name="form1" method="post" action="test_calendar_value.php">
      <table border="0" cellspacing="0" cellpadding="2">
	<tr>
	  <td>Date :</td>
	  <td>
	    <?php

     // Form Variables
     //$day=$_POST['day'];
     //$month=$_POST['month'];
     //$year=$_POST['year'];
     phpinfo();

     //echo "Date supplied: <br />";
     //echo 'Month: '.htmlspecialchars($month).'<br />';
     //echo 'Day: '.htmlspecialchars($day).'<br />';
	    //echo 'Year: '.htmlspecialchars($year).'<br />';

	    $myCalendar = new tc_calendar("NMMA_date", true, false);
	    $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	    $myCalendar->setPath("calendar/");
	    $myCalendar->setYearInterval(2000, 2015);
	    $myCalendar->dateAllow('2008-05-13', '2010-03-01');
	    $myCalendar->setDateFormat('j F Y');
$myCalendar->writeScript();
	    ?></td>
	  <td><input type="button" name="button" id="button" value="Check the value" onclick="javascript:alert(this.form.date5.value);" />
	  </td>
	</tr>
      </table>
      <p>
	<?php
	 echo("<p>the date value from getDate() at construct time = ".$myCalendar->getDate()."</p>");
?>
	<input type="submit" name="Submit" value="Submit" />
      </p>
    </form>

    <?php
	$station_captions = array(
            'US0001'=>'Albuquerque South Valley, P. Eschman, Az:350°',
            'US0002'=>'Albuquerque South Valley, P. Eschman, Az:180',
            'US000A'=>'Belen, W. Wallace, Az:20°',
            'US0008'=>'Los Lunas, S. Welch, Az:30°',
            'US0006'=>'Albuquerque NE, S. Kaufman, Az:49°',
            'US000C'=> 'Magdalena, J. Briggs, Az:68°',
            'US0003'=>'Socorro, B. Greschke, Az:71°',
            'US000H'=>'Quemado, T. Havens, Az:85°',
            'US000E'=>'Albuquerque South Valley, P. Eschman, Az:88°',
            'US000N'=>'Albuquerque NE, S. Kaufman, Az:109°',
            'US000M'=>'Edgewood, J. Seargeant, Az:145°',
            'US0005'=>'Edgewood, J. Seargeant, Az:173°',
            'US001L'=>'Creede CO, D. Robinson, Az:183°',
            'US0009'=>'Los Lunas, S. Welch, Az:195°',
            'US0004'=>'Santa Fe, R. James, Az:211°',
            'US000G'=>'GNTO, Az:226°',
            'US000R'=>'Los Lunas, S. Welch, Az:265°',
            'US000P'=>'Albuquerque N, B. Hufnagel, Az:281°',
            'US000D'=>'Albuquerque, J. Fordice, Az:282°',
            'US000L'=>'Santa Fe, G. Mroz, Az:287°',
            'US000K'=>'Socorro, B. Greschke, Az:327°',
            'US000J'=>'Magdalena, E. Toops, Az:343°',
            'US0007'=>'Albuquerque N, B. Hufnagel, Az:358°'
            );

      $station_names = array (
            'US0001', 'US0002', 'US000A', 'US0008', 'US0006', 'US000C',
            'US0003', 'US000H', 'US000E', 'US000N', 'US000M', 'US0005',
            'US001L', 'US0009', 'US0004', 'US000G', 'US000R', 'US000P',
            'US000D', 'US000L', 'US000K', 'US000J', 'US0007'
      );
      
      $station_azimuths = array (
    'US0001'=>350, 'US0002'=>180, 'US0003'=>71,  'US0004'=>211,
            'US0005'=>173, 'US0006'=>49,  'US0007'=>358, 'US0009'=>195, 'US000A'=>20,  'US000C'=>68,  'US000D'=>282, 'US000E'=>88,
            'US000G'=>226, 'US000H'=>85,  'US000J'=>343, 'US000K'=>327, 'US000L'=>287, 'US000M'=>145, 'US000N'=>109, 'US000P'=>281,
            'US000R'=>265, 'US001L'=>183 
            );
      
      asort($station_azimuths);
      
      echo "<h2 align=CENTER>";
      
      foreach ($station_captions as $station => $caption) {
      echo $station.": ".$caption."<br />";
//      $station_meteor_image_file=
      echo "<image src=".$station_meteor_image_file."></br \>";
      }
    ?>

  </body>

</html>
