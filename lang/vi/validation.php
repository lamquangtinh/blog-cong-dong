<?php

return [

    'after' => ':Attribute phải là thời điểm sau :date.',
    'array' => ':Attribute phải là một danh sách.',
    'confirmed' => ':Attribute xác nhận không khớp.',
    'date' => ':Attribute không phải là ngày giờ hợp lệ.',
    'email' => ':Attribute phải là địa chỉ email hợp lệ.',
    'exists' => ':Attribute đã chọn không hợp lệ.',
    'image' => ':Attribute phải là tệp ảnh.',
    'in' => ':Attribute đã chọn không hợp lệ.',
    'integer' => ':Attribute phải là số nguyên.',
    'max' => [
        'array' => ':Attribute không được có quá :max mục.',
        'file' => ':Attribute không được lớn hơn :max KB.',
        'numeric' => ':Attribute không được lớn hơn :max.',
        'string' => ':Attribute không được dài quá :max ký tự.',
    ],
    'mimes' => ':Attribute phải có định dạng: :values.',
    'min' => [
        'array' => ':Attribute phải có ít nhất :min mục.',
        'file' => ':Attribute phải lớn hơn hoặc bằng :min KB.',
        'numeric' => ':Attribute phải lớn hơn hoặc bằng :min.',
        'string' => ':Attribute phải có ít nhất :min ký tự.',
    ],
    'required' => ':Attribute không được để trống.',
    'string' => ':Attribute phải là chuỗi ký tự.',
    'unique' => ':Attribute này đã được sử dụng.',
    'uploaded' => 'Tải :attribute lên thất bại.',

    // Thông báo riêng cho từng ô
    'custom' => [
        'published_at' => [
            'required' => 'Vui lòng chọn giờ đăng cho bài hẹn giờ.',
            'after' => 'Giờ đăng phải ở tương lai.',
            'date' => 'Giờ đăng không hợp lệ.',
        ],
    ],

    // Tên hiển thị của các ô trong thông báo
    'attributes' => [
        'name' => 'tên',
        'email' => 'email',
        'password' => 'mật khẩu',
        'password_confirmation' => 'nhập lại mật khẩu',
        'title' => 'tiêu đề',
        'body' => 'nội dung',
        'category_id' => 'danh mục',
        'tags' => 'tag',
        'tags.*' => 'tag',
        'status' => 'trạng thái',
        'published_at' => 'giờ đăng',
        'image' => 'ảnh',
    ],

];