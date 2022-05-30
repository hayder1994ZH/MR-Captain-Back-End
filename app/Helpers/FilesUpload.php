<?php 
namespace App\Helpers;

use Illuminate\Support\Str;

class FilesUpload{
    public function imageReels($video){
        $ffmpeg = "/bin/ffmpeg";
        $video = $_FILES["videoUrl"]["tmp_name"];
        $image = Str::random(32) . '_reels_image.jpg';
        $getFromSeconed = 2;
        $cmd = "ffmpeg -i " . $video . " -an -ss " . $getFromSeconed . " " . storage_path('app/public/') . $image ;
        shell_exec($cmd);
        return $image;
    }
}