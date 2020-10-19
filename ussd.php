<?php

$config = [
    '*246#' => 'app1', //application 1
    '*246*1#' => 'app2',//different app here too
    '*246*3#' => 'app3',//application 3 with it's behavior
];

$possible_challenges = [
    '*246#',
    '*246*1*2#',
    '*246*2#',
    '*246*1*2#',
    '*246*3*5#',
    '*246*1*7#',
    '*246*3#',
    '*246*7#',
    '*246*9#',
];

//CHALLENGE: find out the mapping of the following to those specified in the config
//          The desire is to route the specific possible challenge to the application that will handle it

//SOLUTION: 

//find out the list of exact matches first, if there isn't a single exact match, then use something that closes matches your request

function exactMatch(string $challenge): ?string {
    global $config;

    $found = null;

    foreach($config as $possible_match => $app) {
        if ($possible_match === $challenge) {
            $found = $possible_match;
        
        break;
        }
    }

    return $found;
}

function relativeMatch(string $challenge): ?string{
    global $config;

    $found = null;

    $longest_match = '';

    foreach($config as $possible_match => $app) {
        //echo "Comparing... ".json_encode(['challenge' => $challenge, 'possible_match' => $possible_match])."\n";
        //don't forget to strip off the # 
        if (strpos($challenge, str_replace('#', '', $possible_match)) === 0) {//starts with or nothing else
            if (strlen($possible_match) > strlen($longest_match)) {
                $longest_match = $possible_match;
            }
        }
    }

    if (strlen(trim($longest_match)) != '') {
        $found = $longest_match;
    }

    return $found;
}

$solutions = [];

foreach($possible_challenges as $id => $challenge) {
    //find exact match first
    $matched = exactMatch($challenge);

    if (!$matched) {
        //try finding a closely related match
        $matched = relativeMatch($challenge);
    }

    //$solutions[$id + 1] = $matched ?: 'null';
    if ($matched) {
        foreach($config as $k => $v) {
            if ($matched == $k) {
                $solutions['challenge_'.($id + 1)] = $v;
            }
        }
    } else {
        $solutions['challenge_'.($id + 1)] = 'null';
    }
}

$presentation_challenges = [];

foreach($possible_challenges as $id => $challenge) {
    $presentation_challenges['challenge_'.($id + 1)] = $challenge;
}

echo "\n\n====================================\n\nThe RESULTS SO FAR\n\n====================================\n\n\n".json_encode(['config' => $config, 'short_codes' => $presentation_challenges, 'matches' => $solutions])."\n\n";
