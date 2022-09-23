<?php
require_once 'login.php';

     // Usage: curl -v -F "upload=@/home/pi/RMS_data/ArchivedFiles/US000N_20220105_003458_980194/US000N_20220105_003458_980194_stack_61_meteors.jpg" 
     //                    http://nm-meteors.net/test-upload-bh.php
     // uploads to /var/www/html on NM Server (where this script sits)
     // Bluehost root directory is public_html/ on Bluehost (where this script sits)
     
     // The uploaded file is indexed as the first index "upload" in $_FILES because the 
     // file uploaded is begun with "upload=@<filename>" 
     // in the curl command.
     
     function parse_filename ($filename) {
          // Returns the year, month, and day of the filename,
          // and the stripped-down filename without the millisecond
          // parts of the name.
          // A 4-member array is returned: 
          //        1. stripped filename
          //        2. Year
          //        3. Month
          //        4. Day
          $pieces = explode("_", $filename, 5);
          $station_name = $pieces[0];
          $date = $pieces[1];
          $yr = substr($date, 0, 4);
          $mo = substr($date, 4, 2);
          $dy = substr($date, 6, 2);
          $new_name = implode("_", array($station_name, $date, $pieces[4]));
          //var_dump($pieces);
          return array($new_name, $yr, $mo, $dy);
     }
     
     print "Contents of POST array\n";
     //var_dump($_POST);
     $upload_type = $_POST["type"];
     printf( "Upload type: %s\n", $upload_type );
     $upload_date = $_POST["date_str"];
     printf ("upload date_str is %s\n", $upload_date);
     $uploads_dir = 'uploads/';

     $tn = $_FILES['upload']['tmp_name'];
     $fn = $_FILES['upload']['name'];
     $er = $_FILES['upload']['error'];
     print "tmp_name is $tn\n";
     print "name is $fn\n\n";
     echo "SERVER FILE UPLOAD - \n";
     print "Upload error code: $er\n\n";
     
     switch ($upload_type)
     {
          case "FITS_COUNT":
               $nfn = $fn;
               $yr = substr($upload_date, 0, 4);
               $mo = substr($upload_date, 4, 2);
               $dy = substr($upload_date, 6, 2);
               print "FITS_COUNT!\n";
               break;
          case "IMAGE":
               $parsed = parse_filename($fn);
               //var_dump($parsed);
               $nfn = $parsed[0];
               $yr = $parsed[1];
               $mo = $parsed[2];
               $dy = $parsed[3];
               break;
          default:
               print "No upload_type specified";
               exit();
          }
          
     // Verify the values returned by parse_filename for image types,
     // and put the file in the appropriate subdirectory.

     if (($upload_type == "FITS_COUNT") ||
          ((strlen($yr) == 4 && strlen($mo) == 2 && strlen($dy) == 2
          && $mo >= 1 && $mo <= 12 
          && $dy >= 1 && $dy <= 31) )) {
          print "New filename is $nfn\n";
               // Create directories as needed
               if (!is_dir($uploads_dir . $yr)) {
                    printf ("Directory %s does not exist - creating ...\n", 
                              $uploads_dir . $yr);
                    $status = mkdir($uploads_dir . $yr, 0755);
               }
               if (!is_dir($uploads_dir . $yr . "/" . $mo)) {
                    printf ("Directory %s does not exist - creating ...\n", 
                              $uploads_dir . $yr . "/" . $mo);
                    $status = mkdir($uploads_dir . $yr . "/" . $mo, 0755);
               }
               if (!is_dir($uploads_dir . $yr . "/" . $mo . "/" . $dy)) {
                    printf ("Directory %s does not exist - creating ...\n", 
                              $uploads_dir . $yr . "/" . $mo . "/" . $dy);
                    $status = mkdir($uploads_dir . $yr . "/" . $mo . "/" . $dy, 
                              0755);
               }
               
               $destination = $uploads_dir . $yr ."/" . $mo . "/" . $dy . "/". $nfn;
               print "file destination: $destination\n";
               $move = move_uploaded_file($_FILES["upload"]['tmp_name'], $destination); 
               printf ("file move result: %b\n", $move);
          }
/*
     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
     $conn = mysqli_connect($hn, $un, $pw, $db);
	if (mysqli_connect_errno()) {
          printf ("Oh blat - Fatal db connection Error - %s\n", 
                    mysqli_connect_error);
          exit();
     }
     else {
          print "Logged into database successfully\n";
     }
          // We are connected to database nmmeteo1_NMMA
          $query  = "INSERT INTO `stations` (`name`, `latitude`, 
                              `longitude`, `elevation`, `owner`, 
                              `azimuth`, `altitude`)
                         VALUES ('US0006', 35.147217, -106.505583,
                  typetype=IMAGE"             1826.389,'Stephen G Kaufman',
                              43.152, 49.131)";
          $result = $conn->query($query);
          if (!$result) {
               print "Query failed - closing connection\n";
               mysqli_close($conn);
          }
          
     $query = "SELECT * FROM stations WHERE 1";
     if (!mysqli_query($conn, $query, MYSQLI_STORE_RESULT)) {
          printf ("Table not read - error is %s\n", mysqli_error($conn));
     }
     else {
          printf ("Select returned %d rows.\n", mysqli_num_rows($result));
     }
          
     print "Closing database connection\n";
     mysqli_close($conn);
     */
?>

     
     

     

