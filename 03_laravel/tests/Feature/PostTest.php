<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_crud_relations_and_restore(): void
    {
        $category = Category::create(['name' => 'News']);
        $tag = Tag::create(['name' => 'PHP']);
        $data = ['category_id' => $category->id, 'title' => 'First', 'body' => 'Text', 'tags' => [$tag->id]];

        $this->post(route('posts.store'), $data)->assertRedirect();
        $post = Post::firstOrFail();
        $this->assertTrue($category->posts->contains($post));
        $this->assertTrue($tag->posts->contains($post));
        $this->get(route('posts.index', ['category' => $category->id]))->assertOk()->assertSee('First')->assertSee('News (1)');
        $this->get(route('posts.show', $post))->assertOk()->assertSee('PHP');
        $this->get(route('posts.edit', $post))->assertOk();
        $this->put(route('posts.update', $post), [...$data, 'title' => 'Updated'])->assertRedirect();
        $this->post(route('posts.comments.store', $post), ['author' => 'A', 'body' => 'Hello'])->assertRedirect();
        $this->post(route('posts.comments.store', $post), ['target' => 'category', 'author' => 'B', 'body' => 'Category comment'])
            ->assertRedirect(route('posts.show', $post));
        $categoryComment = $category->comments()->firstOrFail();
        $this->assertInstanceOf(Category::class, Comment::findOrFail($categoryComment->id)->commentable);
        $this->assertInstanceOf(Post::class, $post->comments()->firstOrFail()->commentable);
        $this->get(route('posts.show', $post))->assertSee('Category comment');
        $this->delete(route('posts.destroy', $post))->assertRedirect();
        $this->assertSoftDeleted($post);
        $this->get(route('posts.trash'))->assertSee('Updated');
        $this->patch(route('posts.restore', $post))->assertRedirect();
        $this->assertNotSoftDeleted($post);
    }

    public function test_api_crud_validation_and_published_scope(): void
    {
        $category = Category::create(['name' => 'News']);
        $tag = Tag::create(['name' => 'PHP']);
        $data = ['category_id' => $category->id, 'title' => 'Public', 'body' => 'Text', 'is_published' => true, 'tags' => [$tag->id]];
        $id = $this->postJson('/api/posts', $data)->assertCreated()->assertJsonPath('data.category.name', 'News')->json('data.id');
        Post::create(['category_id' => $category->id, 'title' => 'Draft', 'body' => 'Text']);
        $this->getJson('/api/posts')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.tags.0.name', 'PHP');
        $this->getJson("/api/posts/$id")->assertOk()->assertJsonPath('data.title', 'Public');
        $this->putJson("/api/posts/$id", [...$data, 'title' => 'Changed'])->assertOk()->assertJsonPath('data.title', 'Changed');
        $this->patchJson("/api/posts/$id", ['title' => 'Patched'])->assertOk()
            ->assertJsonPath('data.title', 'Patched')->assertJsonPath('data.tags.0.id', $tag->id);
        $this->patchJson("/api/posts/$id", ['tags' => []])->assertOk()->assertJsonCount(0, 'data.tags');
        $this->postJson('/api/posts', [])->assertUnprocessable()->assertJsonValidationErrors(['category_id', 'title', 'body']);
        $this->deleteJson("/api/posts/$id")->assertNoContent();
        $this->getJson("/api/posts/$id")->assertNotFound();
        $this->assertSoftDeleted('posts', ['id' => $id]);
    }
}
