<?php

error_reporting(E_ALL);
ini_set('display_errors', true);


$rk = new RdKafka\Consumer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers('kafka');

$topic = $rk->newTopic('test');

// The first argument is the partition to consume from.
// The second argument is the offset at which to start consumption. Valid values
// are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

function handleMessage($msg)
{
    echo 'Message: ' . $msg->payload . PHP_EOL;
}

function waitForMessage()
{
    echo 'no more messages, sleeping for 5s ...';
    sleep(5);
    echo PHP_EOL;
}

$start = true;
while (true) {
    $msg = $topic->consume(0, 1000); //partition, timeout

    if (null === $msg) {
        if (!$start) { //first message is often empty
            waitForMessage();
        }
        $start = false;
        continue;
    }

    if ($start) {
        $start = false;
    }

    switch ($msg->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            handleMessage($msg);
            break;

        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            throw new \RuntimeException('Timeout');
            break;

        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            waitForMessage();
            break;

        default:
            $err = $msg->errstr();
            throw new \RuntimeException($err ?? rd_kafka_err2str($msg->err));
            break;
    }
}
