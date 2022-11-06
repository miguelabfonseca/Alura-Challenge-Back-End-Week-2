<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_api_video_returns_a_successful_response()
    {
        $response = $this->get('/api/videos');
        $response->assertStatus(200);
    }

    public function test_the_api_video_returns_a_json_response()
    {
        $response = $this->get('/api/videos');
        $output = json_decode($response->getContent(), true);
        $this->assertArrayHasKey(1, $output);
    }

    public function test_the_api_video_returns_a_valid_json_structure_and_data()
    {
        $response = $this->get('/api/videos');
        $this->assertJsonStringEqualsJsonFile(
            base_path('tests/Feature/json/videos-schema.json'), $response->getContent());
    }

    public function test_the_api_video_returns_a_successful_response_for_one_id()
    {
        $response = $this->get('/api/videos/1');
        $response->assertStatus(200);
    }

    public function test_the_api_video_returns_a_json_response_for_one_id()
    {
        $response = $this->get('/api/videos/1');
        $output = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('titulo', $output);
    }

    public function test_the_api_video_returns_a_valid_json_structure_for_one_existing_video()
    {
        $test = json_encode([
            "id" => 1,
            'categoriaId' => 1,
            "titulo" => "Criar API Rest",
            "descricao" => "Como criar e testar e consumir uma api rest.",
            "url" => "www.youtube.com/21312",
            'created_at' => "2022-11-01T10:36:48.000000Z",
            "updated_at" => "2022-11-01T10:36:48.000000Z",
        ]);

        $response = $this->get('/api/videos/1');
        $this->assertJsonStringEqualsJsonString(
            $test, $response->getContent()
        );
    }

    public function test_the_api_video_returns_a_notfound_response_for_one_invalid_id()
    {
        $response = $this->get('/api/videos/99');
        $response->assertStatus(404);
    }

    public function test_the_api_video_returns_a_valid_json_structure_for_one_invalid_id()
    {
        $response = $this->get('/api/videos/99');
        $this->assertJsonStringEqualsJsonString(
            json_encode(['status' => 'error', 'message' => 'Video not found!']), $response->getContent()
        );
    }

    public function test_the_api_video_returns_a_json_response_for_search()
    {
        $response = $this->get('/api/videos?search=aplicaçã');
        $this->assertJsonStringEqualsJsonFile(
            base_path('tests/Feature/json/search-video-schema.json'), $response->getContent());
    }

    public function test_the_api_video_returns_a_json_response_for_search_not_found()
    {
        $response = $this->get('/api/videos?search=2334445555');
        $response->assertStatus(404);
    }

}
