<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \TesmartApi\Client('192.168.10.10');

echo "current input: " . $client->getInput() . "\n";

if (!isset($argv[1])) {
    echo "To change the active input: php {$argv[0]} [activePort]\n";
    exit();
}

echo "setting input {$argv[1]}...\n";
$client->setInput($argv[1]);
echo "done.\n";

sleep(1);

echo "current input: " . $client->getInput() . "\n";