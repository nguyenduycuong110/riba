# Hướng dẫn sử dụng class `.article-content`

## Mục đích
Class `.article-content` được tạo ra để có thể tái sử dụng cho tất cả các trang hiển thị nội dung bài viết (post, scholar, news, etc.) với định dạng thống nhất.

## Tính năng

### 1. **Danh sách không thứ tự (ul/li)**
- Padding trên dưới: **15px**
- Marker: **Hình tròn** (border-radius: 50%)
- Màu marker: Sử dụng `--primary-color` (fallback: #333)
- Kích thước marker: 6px x 6px
- Khoảng cách giữa các li: 10px

### 2. **Danh sách có thứ tự (ol/li)**
- Padding trên dưới: **15px**
- Marker: Số thứ tự (1., 2., 3., ...)
- Màu số: Sử dụng `--primary-color`
- Font weight: 600

### 3. **Hình ảnh**
- Max-width: 100%
- Border-radius: 8px
- Margin: 20px trên dưới

### 4. **Figure & Figcaption**
- Text-align: center
- Box-shadow cho ảnh
- Font-style: italic cho caption

### 5. **Headings (h2, h3, h4)**
- Font-family: var(--four-font, 'Oswald')
- Color: #32004b
- Margin-top: 30px
- Margin-bottom: 20px

### 6. **Blockquote**
- Border-left: 4px solid primary-color
- Background: #f8f9fa
- Font-style: italic
- Padding: 15px 20px

## Cách sử dụng

### Trong Blade Template
Chỉ cần thêm class `article-content` vào div chứa nội dung:

```blade
<div class="description article-content">
    {!! $content !!}
</div>
```

### Ví dụ thực tế

#### 1. Trang học bổng (Scholar)
```blade
<div class="scholar-content page-h2 mt30">
    <h2 class="title"><span>Giới thiệu về học bổng</span></h2>
    <div class="description article-content">
        {!! $scholar->languages->first()->pivot->description !!}
    </div>
    <div class="content article-content">
        {!! $contentWithToc !!}
    </div>
</div>
```

#### 2. Trang bài viết (Post)
```blade
<div class="post-container">
    <div class="content article-content">
        {!! $post->content !!}
    </div>
</div>
```

#### 3. Trang tin tức (News)
```blade
<div class="news-detail">
    <div class="news-content article-content">
        {!! $news->content !!}
    </div>
</div>
```

## Lưu ý
- Class này được định nghĩa ở cuối file `resources/css/app.scss`
- Có thể override các style bằng cách thêm class cụ thể hơn
- Hỗ trợ nested lists (ul trong ul, ol trong ol)
- Tương thích với các CSS variable của project (--primary-color, --four-font)

## File liên quan
- CSS: `resources/css/app.scss` (dòng ~4565)
- Blade example: `resources/views/frontend/scholar/scholar/index.blade.php`
