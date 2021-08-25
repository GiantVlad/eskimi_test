<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->get('/');
        $response->assertViewIs('app');
        $response->assertStatus(200);
    }
}
