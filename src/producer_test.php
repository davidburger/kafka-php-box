<?php

$rk = new RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers('kafka'); //see docker-compose.yml

$topic = $rk->newTopic('test');

function getId(int $x)
{
    return microtime(true)
        . '-'
        . str_pad($x, 6, '0', STR_PAD_LEFT);
}

for ($x = 0; $x < 100000; $x++) {
    $message = [
        'id' => getId($x),
        'text' => 'Message ' . $x,
    ];

    $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message));
}

echo 'Done.' . PHP_EOL;

