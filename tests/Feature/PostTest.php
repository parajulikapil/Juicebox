<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostTest extends TestCase
{
    /**
     * Test list of post collection without authentication
     */
    public function test_post_index_without_authentication(): void
    {
        // Arrange
        $route = route('posts.index');

        // Act
        $response = $this->getJson($route);

        // Assert
        $response->assertStatus(401);
    }

    /**
     * Test list of post collection with authentication
     */
    public function test_post_index_with_authentication(): void
    {
        // Arrange
        $route = route('posts.index');
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $response = $this->getJson($route);

        // Assert
        $response->assertStatus(200);
    }  
    
    /**
     * Test post store without authentication
     */
    public function test_post_store_without_authentication(): void
    {
        // Arrange
        $route = route('posts.store');
        $post = [
            'title' => 'This is title'
        ];

        // Act
        $response = $this->postJson($route, $post);

        // Assert
        $response->assertStatus(401);
    }

    /**
     * Test store post with validation error
     */
    public function test_post_store_with_validation_error(): void
    {
        // Arrange
        $route = route('posts.store');
        $post = [];
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $response = $this->postJson($route, $post);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'title'
            ]
            ]);        
    }

    /**
     * Test post store with valid data
     */
    public function test_post_store_with_valid_data(): void
    {
        // Arrange
        $route = route('posts.store');
        $post = [
            'title' => 'This is title'
        ];
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $response = $this->postJson($route, $post);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas((new Post())->getTable(), $post);
    }
}
