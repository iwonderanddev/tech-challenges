<?php

function storage($value){
    $allSurveys = [];
    $uniqueSurveys = [];
    $dir ='data';
    $surveyFiles = array_diff(scandir($dir, 1), array('..', '.'));

    foreach($surveyFiles as $independentSurvey){
        $surveyJsonObject = json_decode( file_get_contents($dir.'/'.$independentSurvey));
        array_push($allSurveys, $surveyJsonObject);
        if(!in_array($surveyJsonObject->survey, $uniqueSurveys) && $surveyJsonObject !=null){
            array_push($uniqueSurveys, $surveyJsonObject->survey);
        }
    }
    if($value == 1){
        return $allSurveys;
    }return $uniqueSurveys;
}

function groupSurveys($code){
    $productList = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
    //$product1 =[]; $product2 =[];$product3 =[];$product4 =[];$product5 =[];$product6 =[];
    $countMatches = 0;
    $sumation = 0;
    $listOfDates = [];
    $allSurveys = storage(1);
    foreach($allSurveys as $currentSurvey){
        if($currentSurvey->survey->code == $code){
            $i = 1;
            foreach($currentSurvey->questions[0]->answer as $feedback){
                $productList[$i++] += $feedback ? 1 : 0 ;
            }
            $countMatches++;
            $sumation += $currentSurvey->questions[1]->answer;
            array_push($listOfDates, date("F jS, Y h:i A", strtotime($currentSurvey->questions[2]->answer)));
        }
    }
    arsort($productList);
    $average = $sumation / $countMatches;
    return array('bestSellingProducts' => $productList, 'averageNumberOfProducts' => $average,
        'Dates' => $listOfDates);
}

?>