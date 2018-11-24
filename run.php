<?php
require_once __DIR__ . '/lib/PasswordDetect.php';

$url = 'http://<target url>';
$pd = new PasswordDetect($url);

## ATTACK WITH BRUTE FORCE
#$pd->guessWithBruteForce('admin');

## the post request response, if the login success what is the part of the result
#$pd->setSuccessLoginTest('');

## ATTACK WITH DICTIONARY
#$pd->guessWithDictionary('dictionary.csv');