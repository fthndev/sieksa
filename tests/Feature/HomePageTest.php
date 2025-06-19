<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * Test that the home page loads successfully.
     *
     * @return void
     */
    public function test_home_page_can_be_accessed()
    {
        $response = $this->get('/'); // Mengirim HTTP GET request ke root URL

        $response->assertStatus(200); // Memastikan status respons adalah 200 (OK)
        $response->assertSee('SIEKSA'); // Memastikan ada teks "Welcome to our application" di halaman
    }
}