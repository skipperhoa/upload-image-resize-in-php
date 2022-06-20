<?php
/**
 * Image re-size
 * @param int $width
 * @param int $height
 */
function ImageResize($w, $h, $path_file,$tmp_name,$type,$name,$crop=FALSE)
{
     /* Get original file size */
   
     list($width, $height) = getimagesize($tmp_name);

     $r = $width / $height;
     if ($crop) {
         if ($width > $height) {
             $width = ceil($width-($width*abs($r-$w/$h)));
         } else {
             $height = ceil($height-($height*abs($r-$w/$h)));
         }
         $newwidth = $w;
         $newheight = $h;
     } else {
         if ($w/$h > $r) {
             $newwidth = $h*$r;
             $newheight = $h;
         } else {
             $newheight = $w/$r;
             $newwidth = $w;
         }
     }
 
     $path = $path_file."/".$name;
     /* Save image */
     if($type=='image/jpeg')
     {
        /* Get binary data from image */
        $imgString = file_get_contents($tmp_name);
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($tmp, $path, 100);
         
     }
     else if($type=='image/png')
     {
         $image = imagecreatefrompng($tmp_name);
         $tmp = imagecreatetruecolor($newwidth, $newheight);
         imagealphablending($tmp, false);
         imagesavealpha($tmp, true);
         imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
         imagepng($tmp, $path, 0);
     }
     else if($type=='image/gif')
     {
         $image = imagecreatefromgif($tmp_name);

         $tmp = imagecreatetruecolor($newwidth, $newheight);
         $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
         imagefill($tmp, 0, 0, $transparent);
         imagealphablending($tmp, true); 

         imagecopyresampled($tmp, $image,0,0,0,0,$newwidth,$newheight,$width, $height);
         imagegif($tmp, $path);
     }
     else
     {
         return false;
     }
     return true;
     imagedestroy($image);
     imagedestroy($tmp);
}
?>