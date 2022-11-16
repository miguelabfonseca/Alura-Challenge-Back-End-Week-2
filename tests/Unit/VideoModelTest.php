<?php

namespace Tests\Unit;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_creation_of_a_video()
    {
        $videoData = [
            "category" => 3,
            "title" => "Susan Bell T1",
            "description" => "Labore sit nihil qui voluptates repellat quis. Optio est sint minus voluptas sequi necessitatibus et non. Laudantium doloribus occaecati assumenda cupiditate.",
            "url" => "http://www.google.pt",
        ];

        $response = $this->json('POST', 'videos', $videoData, ['Accept' => 'application/json']);

        $response->assertStatus(201);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('video', $array);
        $this->assertArrayHasKey('message', $array);
    }

    public function test_the_update_of_a_video()
    {
        $categoryData = [
            "title" => "Susan Bellagio T1",
        ];

        $response = $this->json('PUT', 'videos/31', $categoryData, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('video', $array);
        $this->assertArrayHasKey('message', $array);
    }

    public function test_the_delete_of_a_video()
    {
        $response = $this->json('DELETE', 'videos/31', ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $array = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('message', $array);
    }

}
