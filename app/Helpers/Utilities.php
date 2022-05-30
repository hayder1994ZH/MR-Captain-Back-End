<?php 
namespace App\Helpers;

class Utilities{

    public static $imageSize = '';
    public static $audioBucket = '/storage/';
    public static $imageBucket = '/storage/';
    public static $videoBucket = '/storage/';
    public static $videoBucketObject = 'live_videos';
    public static $audioBucketObject = 'live_audio';
    public static $imagesBucketObject = 'live_images';
    
    public function getName(){
        return 'Name';
    }
}