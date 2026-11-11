<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_SCHEDULED = 'scheduled';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'image',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Chỉ lấy bài đã đăng: dùng Post::published()->get()
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    // Sinh slug từ tiêu đề, nếu trùng thì thêm -2, -3...
    // Tính cả bài trong thùng rác vì cột slug là duy nhất trên toàn bảng
    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug(mb_substr($title, 0, 200)) ?: 'bai-viet';
        $slug = $base;
        $i = 2;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    // Nội dung bài viết dạng HTML, viết bằng Markdown.
    // html_input = strip: bỏ mọi thẻ HTML người dùng tự gõ (chống XSS).
    // allow_unsafe_links = false: vô hiệu hóa liên kết javascript:, data:...
    // soft_break: dòng xuống dòng đơn vẫn được giữ như văn bản thường.
    public function bodyHtml(): HtmlString
    {
        return new HtmlString(Str::markdown((string) $this->body, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'renderer' => ['soft_break' => "<br>\n"],
        ]));
    }

    // Đoạn trích ngắn cho trang chủ: bỏ ký hiệu Markdown, gom khoảng trắng
    public function excerpt(int $limit = 120): string
    {
        $text = html_entity_decode(strip_tags($this->bodyHtml()->toHtml()), ENT_QUOTES, 'UTF-8');

        return Str::limit(trim((string) preg_replace('/\s+/u', ' ', $text)), $limit);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'Đã đăng',
            self::STATUS_SCHEDULED => 'Hẹn giờ',
            default => 'Nháp',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'text-bg-success',
            self::STATUS_SCHEDULED => 'text-bg-warning',
            default => 'text-bg-secondary',
        };
    }
}