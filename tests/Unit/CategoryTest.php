<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_if_the_api_category_returns_a_successful_response(): void
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }

    public function test_the_api_category_returns_a_valid_json_structure(): void
    {
        $response = $this->get('/categories');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'data', 'message', 'count'])
        );
    }

    public function test_the_api_category_returns_a_valid_json_structure_datatypes(): void
    {
        $response = $this->get('/categories');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
                'data' => 'array',
                'data.0.id' => 'integer',
                'data.0.title' => 'string',
                'data.0.color' => 'string',
                'count' => 'integer',
            ])
        );
    }

    public function test_if_the_api_category_returns_a_successful_response_for_one_category(): void
    {
        $response = $this->get('/categories/1');
        $response->assertStatus(200);
    }

    public function test_the_api_category_returns_a_valid_json_structure_for_one_category(): void
    {
        $response = $this->get('/categories/1');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['category', 'message', 'status'])
        );
    }

    public function test_the_api_category_returns_a_valid_json_structure_datatypes_for_one_category(): void
    {
        $response = $this->get('/categories/1');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'category' => 'array',
                'message' => 'string',
                'status' => 'string',
                'category.0.id' => 'integer',
                'category.0.title' => 'string',
                'category.0.color' => 'string',
                'category.0.created_at' => 'string',
                'category.0.updated_at' => 'string'
            ])
        );
    }

    public function test_if_the_api_video_returns_a_not_found_response_for_one_invalid_category(): void
    {
        $response = $this->get('/categories/99');
        $response->assertStatus(404);
    }

    public function test_the_api_category_returns_a_valid_json_structure_for_one_invalid_category()
    {
        $response = $this->get('/categories/99');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'message'])
        );
    }

    public function test_the_api_category_returns_a_valid_json_structure_datatypes_for_one_invalid_category(): void
    {
        $response = $this->get('/categories/99');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
            ])
        );
    }

    public function test_if_the_api_video_returns_a_found_response_status_for_one_valid_category_id_with_videos(): void
    {
        $response = $this->get('/categories/3');
        $response->assertStatus(200);
    }

    public function test_the_api_category_returns_a_valid_json_structure_for_one_category_list_of_videos(): void
    {
        $response = $this->get('/categories/2/videos');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['videos', 'count', 'status', 'message'])
        );
    }

    public function test_the_api_category_returns_a_valid_json_structure_datatypes_for_one_category_list_of_videos(): void
    {
        $response = $this->get('/categories/3/videos');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'videos' => 'array',
                'message' => 'string',
                'status' => 'string',
                'count' => 'integer',
                'videos.0.id' => 'integer',
                'videos.0.category' => 'array',
                'videos.0.category.id' => 'integer',
                'videos.0.category.title' => 'string',
                'videos.0.category.color' => 'string',
                'videos.0.category.created_at' => 'string',
                'videos.0.category.updated_at' => 'string',
                'videos.0.title' => 'string',
                'videos.0.description' => 'string',
                'videos.0.url' => 'string',
                'videos.0.created_at' => 'string',
                'videos.0.updated_at' => 'string'
            ])
        );
    }

    public function test_if_the_api_video_returns_a_not_found_response_status_for_one_valid_category_id_without_videos(): void
    {
        $response = $this->get('/categories/99/videos');
        $response->assertStatus(404);
    }

    public function test_the_api_video_returns_a_videos_not_found_response_for_one_valid_category_id_without_videos(): void
    {
        $response = $this->get('/categories/99/videos');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'message'])
        );
    }

}
