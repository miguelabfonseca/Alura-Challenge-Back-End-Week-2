<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class VideoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_api_video_returns_a_successful_response(): void
    {
        $response = $this->get('/videos');
        $response->assertStatus(200);
    }

    public function test_the_api_video_returns_a_json_response(): void
    {
        $response = $this->get('/videos');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['videos', 'count', 'status', 'message'])
        );
    }

    public function test_the_api_video_returns_a_valid_json_structure_and_data(): void
    {
        $response = $this->get('/videos');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
                'videos' => 'array',
                'videos.0.id' => 'integer',
                'videos.0.title' => 'string',
                'videos.0.description' => 'string',
                'videos.0.url' => 'string',
                'videos.0.created_at' => 'string',
                'videos.0.updated_at' => 'string',
                'count' => 'integer',
            ])
        );
    }

    public function test_the_api_video_returns_a_successful_response_for_one_id(): void
    {
        $response = $this->get('/videos/1');
        $response->assertStatus(200);
    }

    public function test_the_api_video_returns_a_json_response_for_one_id(): void
    {
        $response = $this->get('/videos/1');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['video', 'status', 'message'])
        );
    }

    public function test_the_api_video_returns_a_valid_json_structure_datatypes(): void
    {
        $response = $this->get('/videos/1');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
                'video' => 'array',
                'video.0.id' => 'integer',
                'video.0.title' => 'string',
                'video.0.description' => 'string',
                'video.0.url' => 'string',
                'video.0.created_at' => 'string',
                'video.0.updated_at' => 'string',
            ])
        );
    }

    public function test_if_the_api_video_returns_a_not_found_response_for_one_invalid_video(): void
    {
        $response = $this->get('/videos/99');
        $response->assertStatus(404);
    }

    public function test_the_api_video_returns_a_valid_json_structure_datatypes_for_one_invalid_video(): void
    {
        $response = $this->get('/videos/99');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'message'])
        );
    }

    public function test_the_api_video_returns_a_json_response_for_search(): void
    {
        $response = $this->get('/videos?search=a');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['videos', 'count', 'status', 'message'])
        );

    }

    public function test_the_api_video_returns_a_json_response_datatypes_for_search(): void
    {
        $response = $this->get('/videos?search=a');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
                'videos' => 'array',
                'videos.0.id' => 'integer',
                'videos.0.title' => 'string',
                'videos.0.description' => 'string',
                'videos.0.url' => 'string',
                'videos.0.created_at' => 'string',
                'videos.0.updated_at' => 'string',
                'count' => 'integer',
            ])
        );
    }

    public function test_the_api_video_returns_a_json_response_for_search_not_found(): void
    {
        $response = $this->get('/videos?search=2334#x445555');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status', 'message'])
        );
    }

    public function test_the_api_video_returns_a_json_response_datatypes_for_search_not_found(): void
    {
        $response = $this->get('/videos?search=2334#x445555');
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereAllType([
                'status' => 'string',
                'message' => 'string',
            ])
        );
    }

}
