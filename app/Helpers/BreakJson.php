<?php

function breakThis($json)
{
    $splitJson = [];

    foreach ($json as $string) {
        // Split the string into an array based on "\r\n-" or ","
        // $splitParts = preg_split('/\s*[\r\n-]+|,/', $string, -1, PREG_SPLIT_NO_EMPTY);
        $splitParts = preg_split('/\s*[\r\n]+/', $string, -1, PREG_SPLIT_NO_EMPTY);


        // Create an array to store individual JSON objects
        $jsonObjects = [];

        foreach ($splitParts as $part) {
            $jsonObjects[] = json_encode(['content' => trim($part)]);
        }

        $splitJson[] = $jsonObjects;
    }

    $mergedData = [];

    foreach ($splitJson as $outerArray) {
        foreach ($outerArray as $innerArray) {
            $jsonObject = json_decode($innerArray, true);
            if ($jsonObject) {
                $mergedData[] = $jsonObject;
            }
        }
    }

    return $mergedData;
}
