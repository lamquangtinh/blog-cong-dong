<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Tài khoản quản trị viên duy nhất.
        // Dùng forceFill vì cột role cố ý không nằm trong $fillable (chống tự nâng quyền qua form).
        // Cột password có cast 'hashed' nên mật khẩu tự được mã hóa khi lưu.
        $admin = User::firstOrNew(['email' => 'admin@example.com']);
        $admin->forceFill([
            'name' => 'Quản trị viên',
            'password' => '12345678',
            'role' => 'admin',
            'email_verified_at' => now(),
        ])->save();

        // 2. Danh mục (admin có thể thêm, sửa, xóa thêm trong khu vực quản trị)
        foreach (['Công nghệ', 'Đời sống', 'Du lịch', 'Ẩm thực', 'Học tập'] as $name) {
            Category::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }

        // 3. Tag (chưa có trang quản lý tag, nên tạo sẵn ở đây; muốn đổi thì sửa danh sách này)
        foreach (['Laravel', 'PHP', 'MySQL', 'Lập trình', 'Hướng dẫn', 'Mẹo vặt', 'Kinh nghiệm', 'Review'] as $name) {
            Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}