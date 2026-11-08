<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// ShouldQueue: email được đẩy vào hàng đợi, không làm chậm lúc người dùng bấm gửi bình luận
class NewCommentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Nếu bình luận bị xóa trước khi worker kịp gửi thì bỏ qua, không báo lỗi
    public bool $deleteWhenMissingModels = true;

    public function __construct(public Comment $comment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bình luận mới trong bài "' . $this->comment->post->title . '"',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-comment');
    }
}