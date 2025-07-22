<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson("/api/posts/{$post->id}/comments", [
                'content' => 'Nice post!',
            ]);
        $response->assertStatus(200)->assertJsonFragment(['content' => 'Nice post!']);
    }

    public function test_guest_cannot_comment()
    {
        $post = Post::factory()->create();
        $response = $this->postJson("/api/posts/{$post->id}/comments", [
            'content' => 'Nice post!',
        ]);
        $response->assertStatus(401);
    }
} 