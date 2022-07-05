<?php 
namespace App\Helpers;

use App\Models\TempFiles;
use Ladumor\OneSignal\OneSignal;

class Utilities{

    public static $imageSize = '';
    public static $audioBucket = '/storage/';
    public static $imageBucket = '/storage/';
    public static $videoBucket = '/storage/';

    public static function owner(){
        if(auth()->user()->rule->name == 'owner'){
            return true;
        }
        return false;
    }
    public static function admin(){
        if(auth()->user()->rule->name == 'admin'){
            return true;
        }
        return false;
    }
    public static function captain(){
        if(auth()->user()->rule->name == 'captain'){
            return true;
        }
        return false;
    }
    public static function player(){
        if(auth()->user()->rule->name == 'player'){
            return true;
        }
        return false;
    }
    
    public static function sendNotifications($keys, $message, $subtitle)
    {
        if(!empty($keys)){
            $fields['include_player_ids'] = $keys;
            $notificationMsg = $message;
            return  OneSignal::sendPush($fields, $notificationMsg, $subtitle);
        }
        return false;
    }
}