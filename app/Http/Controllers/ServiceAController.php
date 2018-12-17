<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ServiceAController extends Controller
{
    public function index(Request $request){
        //HTTP API Logic
        if( (-100000000  <= $request->amount )  &&  ($request->amount <= 100000000 )){
            //Sending message to RabbitMQ
            $amount = $request->amount;
            $currency = $request->currency;

            //Saving request data to variable to publish it
            $messageContent = json_encode([
                'amount' => $amount * 100,
                'currency' => $currency,
            ]);

            //MESSAGING API Logic
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
            $messageBody = $messageContent;
            $message = new AMQPMessage($messageBody, ['content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
            $channel->basic_publish($message, $exchange);
            $channel->close();
            $connection->close();

            //Returning json response of HTTP payload
            $response = json_encode([
                'amount' => +number_format($amount, 2, '.', ''),
                'currency' => $currency,
            ]);
            return $response;
        }else{
            //Returning status 400 if amount is not in acceptable range
            abort(400, 'Amount is not in acceptable range'); //Returning code 400 if condition isn't met
        }
    }
}







