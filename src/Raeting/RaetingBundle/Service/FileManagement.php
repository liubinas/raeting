<?php

namespace Raeting\RaetingBundle\Service;

class FileManagement
{
    public function __construct()
    {
    }
    
    public function scanDir($dir) 
    { 
        $root = scandir($dir); 
        $result = array();
        foreach($root as $value) 
        { 
            if($value === '.' || $value === '..') {continue;} 
            if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
            $result[]=$value;
        } 
        return $result; 
    } 
    
    public function moveFile($from, $to)
    {
        return rename($from, $to);
    }
}
