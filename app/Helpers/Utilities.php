<?php 
namespace App\Helpers;

use App\Models\TempFiles;

class Utilities{

    public static $imageSize = '';
    public static $audioBucket = '/storage/';
    public static $imageBucket = '/storage/';
    public static $videoBucket = '/storage/';
    public static $videoBucketObject = 'live_videos';
    public static $audioBucketObject = 'live_audio';
    public static $imagesBucketObject = 'live_images';
    
    public static function filterMessage($request, $type){
        $file = null;
        if($request->hasFile('message') && ($type == 'image')){
            $file = $request->file('message')->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$imagesBucketObject,
                'table' => 'messages',
            ]);
        }
        if($request->hasFile('message') && ($type == 'audio')){
            $file = $request->file('message')->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$audioBucketObject,
                'table' => 'messages',
            ]);
        }
        if($request->hasFile('message') && ($type == 'video')){
            $file = $request->file('message')->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$videoBucketObject,
                'table' => 'messages',
            ]);
        }
        if(($type == 'text')){
            $file = $request->message;
        }
        return $file;
    }
    public static function uploadFiles($request, $type, $table, $keyFile){
        $file = null;
        if($request->hasFile($keyFile) && ($type == 'image')){
            $file = $request->file($keyFile)->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$imagesBucketObject,
                'table' => $table,
            ]);
        }
        if($request->hasFile($keyFile) && ($type == 'video')){
            $file = $request->file($keyFile)->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$videoBucketObject,
                'table' => $table,
            ]);
        }
        if($request->hasFile($keyFile) && ($type == 'audio')){
            $file = $request->file($keyFile)->store('');
            TempFiles::create([
                'key' => $file,
                'bucket' => self::$audioBucketObject,
                'table' => $table,
            ]);
        }
        return $file;
    }
}