<?php
require dirname(__DIR__).'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//Consumer script that is used to process broker message and save it to a file
$host = 'wolverine-01.rmq.cloudamqp.com';
$port = 5672;
$user = 'kvbtxwwf';
$pass = 'blTp5N7Z_vpFKjkuKRuZWeUvLrV9hNFd';
$vhost = 'kvbtxwwf';
$exchange = 'balance';
$queue = 'local_balance';

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();
/*
    The following code is the same both in the consumer and the producer.
    In this way we are sure we always have a queue to consume from and an
        exchange where to publish messages.
*/
/*
    name: $queue
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
$channel->queue_declare($queue, false, true, false, false);
/*
    name: $exchange
    type: direct
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false //the exchange won't be deleted once the channel is closed.
*/
$channel->exchange_declare($exchange, 'direct', false, true, false);
$channel->queue_bind($queue, $exchange);
/**
 * @param AMQPMessage $message
 */
function process_message(AMQPMessage $message){
    echo "\n--------\n";
    echo $message->body;
    echo "\n--------\n";

    file_put_contents(dirname(__DIR__).'/data/'. '/data' . '.json', $message->body);

    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
}
/*
    queue: Queue from where to get the messages
    consumer_tag: Consumer identifier
    no_local: Don't receive messages published by this consumer.
    no_ack: Tells the server if the consumer will acknowledge the messages.
    exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
    nowait:
    callback: A PHP Callback
*/
$consumerTag = 'local.consumer';
$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');
/**
 * @param \PhpAmqpLib\Channel\AMQPChannel $channel
 * @param \PhpAmqpLib\Connection\AbstractConnection $connection
 */
function shutdown($channel, $connection){
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

while (count($channel->callbacks)) {
    $channel->wait();
}