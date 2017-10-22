<?php

namespace IWD\JOBINTERVIEW\Services;

class JsonFetcher implements JsonFetcherInterface
{

    const JSON_ROOT_FOLDER = __DIR__.'/../../data';

    public function getAllJsonData(){

        $files = scandir(self::JSON_ROOT_FOLDER);
        $data = [];
        foreach($files as $file) {
            array_push($data,file_get_contents(self::JSON_ROOT_FOLDER.'/'.$file));
        }
        return $data;
    }


    public function getJsonFile($filename){
        $fileUri = JSON_ROOT_FOLDER.$filename;
        $json_file = file_get_contents($fileUri);
        return json_decode($json_file);
    }

}