<p>Xin chào {{ $comment->post->user->name }},</p>

<p>
    <strong>{{ $comment->user->name }}</strong> vừa bình luận trong bài viết
    <strong>"{{ $comment->post->title }}"</strong> của bạn:
</p>

<blockquote style="margin: 12px 0; padding: 8px 14px; border-left: 4px solid #0d6efd; background: #f5f5f5;">
    {{ $comment->body }}
</blockquote>

<p>
    <a href="{{ route('posts.show', ['post' => $comment->post->slug]) }}">Xem bài viết và trả lời</a>
</p>

<p>Blog Cộng Đồng</p>