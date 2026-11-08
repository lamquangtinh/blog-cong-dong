<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_only_published_posts(): void
    {
        Post::factory()->create(['title' => 'TieuDeDaDang']);
        Post::factory()->draft()->create(['title' => 'TieuDeBaiNhap']);
        Post::factory()->scheduled()->create(['title' => 'TieuDeHenGio']);

        $this->get('/')
            ->assertOk()
            ->assertSee('TieuDeDaDang')
            ->assertDontSee('TieuDeBaiNhap')
            ->assertDontSee('TieuDeHenGio');
    }

    public function test_post_detail_opens_by_slug(): void
    {
        Post::factory()->create([
            'title' => 'Bai chi tiet',
            'slug' => 'bai-chi-tiet',
            'body' => 'Noi dung day du cua bai',
        ]);

        $this->get(route('posts.show', ['post' => 'bai-chi-tiet']))
            ->assertOk()
            ->assertSee('Bai chi tiet')
            ->assertSee('Noi dung day du cua bai');
    }

    public function test_draft_and_scheduled_posts_return_404(): void
    {
        $draft = Post::factory()->draft()->create();
        $scheduled = Post::factory()->scheduled()->create();

        $this->get(route('posts.show', ['post' => $draft->slug]))->assertNotFound();
        $this->get(route('posts.show', ['post' => $scheduled->slug]))->assertNotFound();
    }

    public function test_search_filters_posts_by_keyword(): void
    {
        Post::factory()->create(['title' => 'Hoc Laravel co ban']);
        Post::factory()->create(['title' => 'Nau an ngon']);

        $this->get('/?q=Laravel')
            ->assertOk()
            ->assertSee('Hoc Laravel co ban')
            ->assertDontSee('Nau an ngon');
    }

    public function test_search_with_no_match_shows_empty_message(): void
    {
        Post::factory()->create(['title' => 'Hoc Laravel']);

        $this->get('/?q=khongcoketqua')
            ->assertOk()
            ->assertDontSee('Hoc Laravel')
            ->assertSee('Không tìm thấy bài viết nào phù hợp.');
    }

    public function test_filter_posts_by_category(): void
    {
        $tech = Category::factory()->create(['name' => 'Cong nghe', 'slug' => 'cong-nghe']);
        $travel = Category::factory()->create(['name' => 'Du lich', 'slug' => 'du-lich']);

        Post::factory()->create(['title' => 'BaiCongNghe', 'category_id' => $tech->id]);
        Post::factory()->create(['title' => 'BaiDuLich', 'category_id' => $travel->id]);

        $this->get('/?category=cong-nghe')
            ->assertOk()
            ->assertSee('BaiCongNghe')
            ->assertDontSee('BaiDuLich');
    }

    public function test_unknown_page_shows_custom_404_page(): void
    {
        $this->get('/trang-khong-ton-tai')
            ->assertNotFound()
            ->assertSee('Không tìm thấy trang');
    }
}