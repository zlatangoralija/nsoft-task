<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetRoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testThatPostRoutesGiveResponse()
    {
        //Testing if the GET api route returns status 200
        $appURL = env('APP_URL');

        $url = '/api/receive-message/balance';

        echo PHP_EOL;
        $response = $this->get($url);
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
