<?php

// This is the temporary file created by PHP

$uploadedfile = $_FILES['uploadfile']['tmp_name'];

// Create an Image from it so we can do the resize

$src = imagecreatefromjpeg($uploadedfile);

// Capture the original size of the uploaded image

list($width,$height)=getimagesize($uploadedfile);

// For our purposes, I have resized the image to be
// 600 pixels wide, and maintain the original aspect
// ratio. This prevents the image from being "stretched"
// or "squashed". If you prefer some max width other than
// 600, simply change the $newwidth variable

$newwidth=600;

$newheight=($height/$width)*600;

$tmp=imagecreatetruecolor($newwidth,$newheight);

// this line actually does the image resizing, copying from the original
// image into the $tmp image

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// now write the resized image to disk. I have assumed that you want the
// resized, uploaded image file to reside in the ./images subdirectory.

$filename = "images/". $_FILES['uploadfile']['name'];

imagejpeg($tmp,$filename,100);

imagedestroy($src);

imagedestroy($tmp);

// NOTE: PHP will clean up the temp file it created when the request
// has completed.
?>