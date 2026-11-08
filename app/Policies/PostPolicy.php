<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Chỉ tác giả mới được sửa bài của mình
    public function update(User $user, Post $post): bool
    {
        return $this->isAuthor($user, $post);
    }

    // Ba quyền dưới đây sẽ dùng ở Phần 2 (thùng rác)
    public function delete(User $user, Post $post): bool
    {
        return $this->isAuthor($user, $post);
    }

    public function restore(User $user, Post $post): bool
    {
        return $this->isAuthor($user, $post);
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $this->isAuthor($user, $post);
    }

    private function isAuthor(User $user, Post $post): bool
    {
        return (int) $user->id === (int) $post->user_id;
    }
}