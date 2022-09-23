<?php
     // Usage: curl -v -F "upload=@/home/pi/RMS_data/ArchivedFiles/US000N_20220105_003458_980194/US000N_20220105_003458_980194_stack_61_meteors.jpg" 
     //                       http://run.local/test-upload.php
     //                 OR    http://nm-meteors.net/test-upload-bh.php
     // uploads to /var/www/html on NM Server (where this script sits)
     // Uploads to public_html/ on Bluehost (where this script sits)
     
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
          var_dump($pieces);
          return array($new_name, $yr, $mo, $dy);
     }
     
     print "Contents of POST array\n";
     var_dump($_POST);
     $upload_type = $_POST["type"];
     printf( "Upload type: %s\n", $upload_type );
     $upload_date = $_POST["date_str"];
     printf ("upload date_str is %s\n", $upload_date);
     
     $uploads_dir = '/var/www/html/uploads';
     $tn = $_FILES['upload']['tmp_name'];
     $fn = $_FILES['upload']['name'];
     $er = $_FILES['upload']['error'];
     print "tmp_name is $tn\n";
     print "name is $fn\n\n";
     echo "SERVER FILE UPLOAD - \n";
     print "Upload error code: $er\n\n";
     
     $destination = "";
     $dy = date("d");

     switch ($upload_type)
     {
          case "FITS_COUNT":
               $nfn = $fn;
               $yr = substr($upload_date, 0, 4);
               $mo = substr($upload_date, 4, 2);
               break;
          case "IMAGE":
               $parsed = parse_filename($fn);
               var_dump($parsed);
               // Verify the values returned by parse_filename
               if ((strlen($parsed[1]) == 4 && strlen($parsed[2]) == 2 && strlen($parsed[3]) == 2
                    && $parsed[2] >= 1 && $parsed[2] <= 12 
                    && $parsed[3] >= 1 && $parsed[3] <= 31)
                    || (string_end_with($parsed[0], "fits_counts.txt"))) {
                    $nfn = $parsed[0];
                    $yr = $parsed[1];
                    $mo = $parsed[2];
                    print "New filename is $nfn\n";
                    }
               break;
          default:
               print "No upload_type specified";
               exit();
          }
          $destination = $uploads_dir . "/" . $yr . "/" . $mo . "/" . $dy . "/".$nfn;
          print "file destination: $destination\n";    
          echo move_uploaded_file($_FILES["upload"]['tmp_name'], $destination) 
               ? "OK\n" : "ERROR\n" ;
     
?>
