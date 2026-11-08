<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MyPostController extends Controller
{
    // Danh sách bài của chính người đăng nhập (không gồm bài trong thùng rác)
    public function index(Request $request): View
    {
        $user = $request->user();

        $posts = $user->posts()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('my-posts.index', [
            'posts' => $posts,
            'trashedCount' => $user->posts()->onlyTrashed()->count(),
        ]);
    }

    public function create(): View
    {
        return view('my-posts.create', [
            'post' => new Post(['status' => Post::STATUS_DRAFT]),
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules($request));

        $post = new Post();
        $post->user_id = $request->user()->id;
        $this->fillAndSave($post, $data, $request);

        Log::info('Tạo bài viết', [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'status' => $post->status,
        ]);

        return redirect()->route('my-posts.index')->with('success', 'Đã tạo bài viết.');
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post); // không phải tác giả thì 403

        $post->load('tags');

        return view('my-posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post); // kiểm tra lại ở server khi gửi form

        $data = $request->validate($this->rules($request));
        $this->fillAndSave($post, $data, $request);

        Log::info('Cập nhật bài viết', [
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'status' => $post->status,
        ]);

        return redirect()->route('my-posts.index')->with('success', 'Đã cập nhật bài viết.');
    }

    // Xóa mềm: đưa bài vào thùng rác
    public function destroy(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();

        Log::info('Chuyển bài viết vào thùng rác', [
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('my-posts.index')
            ->with('success', 'Đã chuyển bài viết vào thùng rác.');
    }

    // Danh sách bài trong thùng rác của tôi
    public function trash(Request $request): View
    {
        $posts = $request->user()
            ->posts()
            ->onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('my-posts.trash', ['posts' => $posts]);
    }

    // Khôi phục bài từ thùng rác
    public function restore(Request $request, int $id): RedirectResponse
    {
        // Chỉ tìm trong thùng rác: bài chưa bị xóa thì trả về 404
        $post = Post::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $post); // không phải tác giả thì 403

        $post->restore();

        Log::info('Khôi phục bài viết', [
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('my-posts.trash')->with('success', 'Đã khôi phục bài viết.');
    }

    // Xóa vĩnh viễn (kèm xóa file ảnh)
    public function forceDestroy(Request $request, int $id): RedirectResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        Gate::authorize('forceDelete', $post);

        $postId = $post->id;

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Liên kết tag và bình luận của bài tự xóa theo nhờ khóa ngoại cascade
        $post->forceDelete();

        Log::info('Xóa vĩnh viễn bài viết', [
            'post_id' => $postId,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('my-posts.trash')->with('success', 'Đã xóa vĩnh viễn bài viết.');
    }

    private function rules(Request $request): array
    {
        $scheduled = $request->input('status') === Post::STATUS_SCHEDULED;

        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'status' => ['required', Rule::in([
                Post::STATUS_DRAFT,
                Post::STATUS_PUBLISHED,
                Post::STATUS_SCHEDULED,
            ])],
            // Chỉ bắt buộc giờ hẹn khi chọn "Hẹn giờ đăng", và phải ở tương lai
            'published_at' => $scheduled ? ['required', 'date', 'after:now'] : ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function fillAndSave(Post $post, array $data, Request $request): void
    {
        $wasPublished = $post->exists && $post->getOriginal('status') === Post::STATUS_PUBLISHED;

        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->category_id = $data['category_id'] ?? null;
        $post->status = $data['status'];

        // Slug chỉ sinh khi tạo mới, sửa tiêu đề không đổi đường dẫn cũ
        if (! $post->exists) {
            $post->slug = Post::generateUniqueSlug($data['title']);
        }

        $post->published_at = match ($data['status']) {
            Post::STATUS_DRAFT => null,
            Post::STATUS_PUBLISHED => $wasPublished ? $post->published_at : now(),
            Post::STATUS_SCHEDULED => $data['published_at'],
        };

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image); // xóa ảnh cũ
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();
        $post->tags()->sync($data['tags'] ?? []);
    }
}