#!/bin/bash

# SGK development notes: call for 18-Oct-2021 has interesting failures.
# Issue: Multiple files of one of four file names sought.
# So does call for 2-Oct-2021. Issue: Must use leading zeroes!
#
# This program copies image files uploaded to NM Server to the
# image directory of the web site area on the same server.
# Files are placed in a dated file structure, and extraneous stuff
# in the filenames is stripped out. It must be run as follows:
# "pi@RUN:~/src $ sudo -u www-data ./move_data_to_web.sh"
# Parameters:
#    First is day of month, with leading zero if necessary (i.e., two digits).
#    Second is month, with leading zero if necessary (i.e., two digits).
#    Third is year, in four digits.
# If left out, they default to the current calendar value at time of call.

declare -a station_list=('US0001' 'US0002' 'US0003' 'US0004' 'US0005' 'US0006' \
				 'US0007' 'US0008' 'US0009' 'US000A' 'US000C' \
				 'US000D' 'US000E' 'US000G' 'US000H' 'US000J' \
				 'US000K' 'US000L' 'US000M' 'US000N' 'US000P' \
				 'US000R' 'US001L' \
			)

declare -a file_names=('*meteors.jpg' '*captured.jpg' \
				      '*calib_report_astrometry.jpg' \
				      '*calib_report_photometry.png' \
		      )

declare -A station_meteor_jpg
declare -A station_captured
declare -A station_astro_calib
declare -A station_photo_calib

declare -i day_num month_num year_num

declare src='/home/pi/RMS_Station_data'
declare dst='/var/www/html/images'

# First parameter is day, 2nd is month, 3rd is year.
# If one is missing, it is replaced by the current time value.
# They are set here as default values, and changed as necessary
# in the subsequent argument processing logic.
dy=$(date +%d)
mo=$(date +%m)
yr=$(date +%Y)

if [[ $# -ge 1 ]]; then
    day_num=10#"$1"
    if (( 1 <= $day_num && $day_num <= 31 )); then
	dy=$1
    else {
	echo "First argument must be a number between 1 and 31"
	exit 1
    }
    fi	
fi

if [[ $# -ge 2 ]]; then
    mo_num=10#"$2"
    if (( 1 <= $mo_num && $mo_num <= 12 )); then
	mo=$2
    else {
	echo "Second argument must be a number between 1 and 12"
	exit 1
    }
    fi
fi

today="$yr""$mo""$dy"
env printf 'Day: %s\tMonth: %s\t Year: %s\n' "$dy" "$mo" "$yr"
env printf 'Date string: %s\n' "$today"

# The folllowing is uncommented when testing input processing.
# exit 0

if [[ ! -d "$dst"/"$yr" ]]; then
    mkdir "$dst"/"$yr"
fi

if [[ ! -d "$dst"/"$yr"/"$mo" ]]; then
    mkdir "$dst"/"$yr"/"$mo"
fi

if [[ ! -d "$dst"/"$yr"/"$mo"/"$dy" ]]; then
    mkdir "$dst"/"$yr"/"$mo"/"$dy"
fi

new_dst="$dst"/"$yr"/"$mo"/"$dy"
short_dst="images"/"$yr"/"$mo"/"$dy"

pushd "$src"
for station in "${station_list[@]}"; do
    env printf '%s: ' "$station";
    for f in "${file_names[@]}"; do 
	     full_file_name=$(find . -name "$station"_"$today""$f" -print)
    
	     # Now we want to strip out the middle part for image filenames,
	     # corresponding to date, seconds, and microseconds. Grep for 
	     # the trailing part of the file name to append to station
	     # to strip out fractioal second information.
	     # First check that the stack of detected meteors is really there.
    
	     if [[ -n "$full_file_name" ]]; then

		 # Need to grep for different strings depending on file name
		 st=$(echo "$full_file_name" | grep -o 'stack')
		 
		 if [[ -n $st ]]; then
		     file_id=$(echo "$full_file_name" \
				   | grep -o "stack_[1-9][0-9]*_$f")
		 else
		     file_id=$(echo "$full_file_name" | grep -o "*$f")
		 fi
		 
		 env printf 'file id: %s\n' "$file_id"
		 file_name="$station"_"$today"_"$file_id"
		 dst_name="$new_dst"/"$file_name"
		 cp "$src"/"$station"_"$today"*"$file_id" "$dst_name"
		 # The following has to take the file_names entry into account.
		 case "$f" in
		     '*meteors.jpg' )
		       station_meteor_jpg[$station]="$short_dst"/"$file_name";;
		     '*captured.jpg' )
		       station_captured[$station]="$short_dst"/"$file_name";;
		     '*calib_report_astrometry.jpg' )
		       station_astro_calib[$station]="$short_dst"/"$file_name";;
		     '*calib_report_photometry.png' )
		       station_photo_calib[$station]="$short_dst"/"$file_name";;
		     * ) printf 'Weird entry in file_list. WTF???\'
		 esac
	     else
		 env printf 'no file found\n'
	     fi
    done
done
popd

for station in "${station_list[@]}"; do
    env printf 'Station %s meteors: %s\n' "$station" \
	"${station_meteor_jpg["$station"]}"
done

for station in "${station_list[@]}"; do
    env printf 'Station %s captured: %s\n' "$station" \
	"${station_captured["$station"]}"
done

for station in "${station_list[@]}"; do
    env printf 'Station %s astro calibration: %s\n' "$station" \
	"${station_astro_calib[$station]}"
done

for station in "${station_list[@]}"; do
    env printf 'Station %s photo calibration: %s\n' "$station" \
	    "${station_photo_calib[$station]}"
done

printf '%d stations have uploaded so far\n' ${#station_meteor_jpg[@]}

