<?php

namespace Tests\Unit;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_creation_of_a_category()
    {
        $categoryData = [
            "title" => "Susan Bell",
            "color" => "#696969",
        ];

        $response = $this->json('POST', 'categories', $categoryData, ['Accept' => 'application/json']);

        $response->assertStatus(201);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('category', $array);
        $this->assertArrayHasKey('message', $array);
    }

    public function test_the_update_of_a_category()
    {
        $categoryData = [
            "title" => "Susan Bellagio",
            "color" => "#696969",
        ];

        $response = $this->json('PUT', 'categories/11', $categoryData, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('category', $array);
        $this->assertArrayHasKey('message', $array);
    }

    public function test_the_delete_of_a_category()
    {
        $response = $this->json('DELETE', 'categories/11', ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('message', $array);
    }

}
