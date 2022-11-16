<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_api_category_returns_a_successful_response()
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }

    public function test_the_api_category_returns_a_json_response()
    {
        $response = $this->get('/categories');
        $output = json_decode($response->getContent(), true);
        $this->assertArrayHasKey(1, $output);
    }

    public function test_the_api_category_returns_a_valid_json_structure_and_data()
    {
        $response = $this->get('/categories');
        $this->assertJsonStringEqualsJsonFile(
            base_path('tests/Feature/json/categorias-schema.json'), $response->getContent());
    }

    public function test_the_api_category_returns_a_successful_response_for_one_id()
    {
        $response = $this->get('/categories/1');
        $response->assertStatus(200);
    }

    public function test_the_api_category_returns_a_json_response_for_one_id()
    {
        $response = $this->get('/categories/1');
        $output = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('color', $output);
    }

    public function test_the_api_category_returns_a_valid_json_structure_for_one_existing_category()
    {
        $response = $this->get('/categories/2');
        $this->assertJsonStringEqualsJsonFile(
            base_path('tests/Feature/json/categoria-2-schema.json'), $response->getContent()
        );
    }

    public function test_the_api_video_returns_a_notfound_response_for_one_invalid_id()
    {
        $response = $this->get('/categories/99');
        $response->assertStatus(404);
    }

    public function test_the_api_video_returns_a_valid_json_structure_for_one_invalid_id()
    {
        $response = $this->get('/categories/99');
        $this->assertJsonStringEqualsJsonString(
            json_encode(['status' => 'error', 'message' => 'Category not found!']), $response->getContent()
        );
    }

    public function test_the_api_video_returns_a_found_response_for_one_valid_category_id_with_videos()
    {
        $response = $this->get('/categories/2/videos');
        $this->assertJsonStringEqualsJsonFile(
            base_path('tests/Feature/json/categoria-videos-schema.json'), $response->getContent());
    }

    public function test_the_api_video_returns_a_found_response_status_for_one_valid_category_id_without_videos()
    {
        $response = $this->get('/categories/3');
        $response->assertStatus(200);
    }

    public function test_the_api_video_returns_a_videos_not_found_response_for_one_valid_category_id_without_videos()
    {
        $response = $this->get('/categories/99/videos');
        $this->assertJsonStringEqualsJsonString(
            json_encode(["status" => "error", "message" => "No videos found on the selected category!"]), $response->getContent());
    }

    public function test_the_api_video_returns_a_not_found_response_status_for_one_valid_category_id_without_videos()
    {
        $response = $this->get('/categories/99');
        $response->assertStatus(404);
    }


}
