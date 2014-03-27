PHP script that allows the recursive compression of all PNG images that are found beneath a directory using the tinypng.com API.

The script is built upon the CURL API usage example that can be found on the tinypng.com API reference page ( https://tinypng.com/developers/reference ).

## Requirements ##

- A PHP install with the CLI & CURL modules
- A Linux / Unix type OS with access to the command line

## Basic Usage ##

- Got to https://tinypng.com/developers and add your email address to subscribe and they will send you an email with a link. Click on this to get you API key for the service.
- Edit the png_crush.php file and add your API key to the define statement on line 10.
- Change line 11 to the full directory path of your project or image store containing the PNG files you would like to compress.
- Save the changes.
- In a terminal window make sure the png_crush.php file is executable i.e chomd +x png_crush.php
- Start the compression process by running the script from the command line i.e php png_crush.php

## Notes ##

- The free tinypng pricing plan allows for compressing 500 png images per month so if your a heavy user you may need to switch to a paid plan.
- The compression process on each image takes 10 - 15 seconds per second. So the process may take a long time to run to completion if your project contiains alot of PNG images.
- On average with the projects I have used the script on I have the compression process reduced the total file size of the images by 70 - 75%. 
