<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_create_post()
    {
        $user = User::factory()->create(['role' => UserRole::AUTHOR->value]);
        $token = auth()->login($user);
    
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/posts', [
                'title' => 'Test Post',
                'content' => 'Test content',
                'category' => 'Education',
            ]);
    
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Test Post']);
    }


    public function test_admin_can_update_any_post()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['author_id' => $author->id]);
        $token = auth()->login($admin);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/posts/{$post->id}", ['title' => 'Updated']);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated']);
    }

    public function test_author_can_update_own_post()
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['author_id' => $author->id]);
        $token = auth()->login($author);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/posts/{$post->id}", ['title' => 'Updated']);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated']);
    }

    public function test_author_cannot_update_others_post()
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['author_id' => $author2->id]);
        $token = auth()->login($author1);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/posts/{$post->id}", ['title' => 'Updated']);
        $response->assertStatus(403);
    }
} 