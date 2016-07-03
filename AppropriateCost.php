#!/bin/env php-cli
<?php

if ( PHP_SAPI !== 'cli' )
{
    echo PHP_EOL . PHP_EOL . "Can only be called from commandline. -> " . PHP_SAPI . PHP_EOL . PHP_EOL;
    exit( 0 );
}

echo PHP_EOL;
echo '
/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */';

echo PHP_EOL;

$timeTarget = 0.05; // 50 milliseconds 

$cost = 8;

do
{
    $cost++;
    $start = microtime( true );
    password_hash( "test", PASSWORD_BCRYPT, [ "cost" => $cost ] );
    $end = microtime( true );
}
while ( ( $end - $start ) < $timeTarget );

echo PHP_EOL . PHP_EOL . "Appropriate Cost Found: {$cost}" . PHP_EOL . PHP_EOL;
