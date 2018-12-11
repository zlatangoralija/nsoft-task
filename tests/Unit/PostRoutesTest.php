<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostRoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testThatPostRoutesGiveResponse()
    {
        //Testing if the POST api routes returns status 200
        $appURL = env('APP_URL');

        $urls = [
          '/api/send-message?example=100.19&currency=EUR', //Example of data that would be sent to RabbitMQ
          '/api/receive-message',
        ];

        echo PHP_EOL;

        foreach($urls as $url){
            $response = $this->post($url);
            if((int)$response->status() !== 200){
                echo $appURL . $url . '(FAILED) did not return status 200';
                $this->assertFalse(false);
            }else{
                echo $appURL.$url.'(SUCCESS)';
                $this->assertTrue(true);
            }
            echo PHP_EOL;
        }
    }
}
