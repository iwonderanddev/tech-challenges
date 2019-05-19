<?php

namespace IWD\JOBINTERVIEW\Client\Webapp\Data;

Class Builder
{

    /**
     * @param String FILES_PATH
     */
    CONST FILES_PATH = ROOT_PATH . '/data/';

    /**
     * @param array
     */
    protected $data = [];

    /**
     *  @param array $files
     *  @return array $data
     */
    public static function extractData(array $files): array
    {
        $data = [];

        foreach ($files as $file) {

            if (
                $file !== '.'
                && $file !== '..'
                && file_exists(Builder::FILES_PATH . $file)
            ) {
                $dataFromJson = file_get_contents(Builder::FILES_PATH . $file);
                $dataFromJson = json_decode($dataFromJson, true);

                if (empty($data[$dataFromJson['survey']['code']]['name'])) {
                    $data[$dataFromJson['survey']['code']]['name'] = $dataFromJson['survey']['name'];
                }

                foreach ($dataFromJson['questions'] as $question) {
                    $data[$dataFromJson['survey']['code']]['questions'][$question['type']][] = $question;
                }
            }
        }

        return $data;
    }
}