<?php

class imageTagger{
    public function __construct(){
        $files = glob("photos/*.jpeg");
        $photoNumber = 1;
        foreach ($files as $file){
            $photoDate = $this->getPhotosDate($file);
            $jpg = imagecreatefromjpeg($file);
            $color = imagecolorexact($jpg, 255, 0, 0);
            
            $imageResult = imagefttext(
                $jpg, 
                60,
                0,
                100,
                160,
                $color,
                "ArialBlack.ttf",
                $photoDate
            );

            imagejpeg($jpg, "Home-{$photoNumber}.jpg");
            $photoNumber++;
            // die;
        }
    }
    private function getPhotosDate(String $imagePath):string{
        $exif = exif_read_data($imagePath);
        $imageDate = trim($exif["DateTimeOriginal"]);
        $correctDate = DateTime::createFromFormat("Y:m:d H:i:s", $imageDate);
        return $correctDate->format("Y/m/d H:i:s");
    }
}

putenv('GDFONTPATH=' . realpath('.'));
$imageTagger = new imageTagger;
