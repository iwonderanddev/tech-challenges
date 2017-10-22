<?php

namespace IWD\JOBINTERVIEW\Services;

interface JsonFetcherInterface
{

    /**
     *
     * @return Array
     */
    public function getAllJsonData();

    /**
     * @param string $filename
     *
     * @return String
     */
    public function getJsonFile($filename);

}

