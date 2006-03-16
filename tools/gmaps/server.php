<?php
//Images go to the maptiles directory in the format x_y_z.jpg

           define("NO_DATA", "./maptiles/no_data.jpg");
     
           $x = $_GET["x"];
           $y = $_GET["y"];
           $z = $_GET["zoom"];
           $filename = "./maptiles/${x}_${y}_${z}.jpg";
     
           if (is_numeric($x) && is_numeric($y) && is_numeric($z) && file_exists($filename)){
                 $content = file_get_contents( $filename );
           }else{
                 $content = file_get_contents( NO_DATA );
           }
     
           header("Content-type: image/jpg");
     
           echo $content;
?>
