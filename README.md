# NMMA Web Development
# System Architecture
## RMS Stations belonging to the New Mexico Meteor Array. These are Raspberry-Pi based stations, runnig either the Jessie or Buster versions of the Raspbian OS. There are about 23 stations.
## Data Server - this host collects data from RMS meteor stations. Fourteen data files are uploaded to the Data Server each morning from each station. There may be fewer than fourteen files if no meteors were detected during the night.
## Web Server - This is the host for the website nm-meteors.net. It is a different host than the data server. Four files per RMS station are selected from the data server.  
# Files in this repository
## Data server files
1. move_data_to_web.sh: Shell script with arguments in this order: day month year. "day" and "month" must be two numeric characters, making a reasonable combination of day and month. "year" must be 4 numeric characters, denoting the year. There is minimal error checking of the characters. This file moves the four files from the uploaded files correspondig to the give date from the collected station files to a separate directory on the Data Server. Their names are modified to remove cruft used in file naming during the data collection process.
display_images.php: Meant to be run on the web server. It displays the images selected, for a selected date.
