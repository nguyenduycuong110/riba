# Fix: Đường dẫn sai cho Review Trường trên trang chủ

## Vấn đề
Các bài viết trong phần "Review Trường" trên trang chủ có đường dẫn (canonical URL) không đúng hoặc bị lỗi.

## Nguyên nhân
1. **Model School thiếu relation `routers`**: Model School không có relation với bảng `routers`, dẫn đến việc không thể lấy canonical URL chính xác từ bảng này.

2. **HomeController không load relation `routers`**: Khi query danh sách schools, controller chỉ load relation `languages` mà không load `routers`.

3. **Component review lấy canonical sai**: Component `review.blade.php` lấy canonical trực tiếp từ `school_language.canonical` thay vì từ bảng `routers` (nguồn chính xác).

## Giải pháp đã áp dụng

### 1. Thêm relation `routers` vào Model School
**File**: `app/Models/School.php`

```php
// Thêm import
use App\Models\Router;

// Thêm relation
public function routers(){
    return $this->morphMany(Router::class, 'module');
}
```

### 2. Load relation `routers` trong HomeController
**File**: `app/Http/Controllers/Frontend/HomeController.php`

```php
// Thay đổi từ:
$schools = School::with(['languages'])

// Thành:
$schools = School::with(['languages', 'routers'])
```

### 3. Cập nhật component review để lấy canonical từ routers
**File**: `resources/views/components/review.blade.php`

```php
// Lấy canonical từ routers trước, nếu không có thì lấy từ pivot
$canonicalFromRouter = null;
if(isset($item->routers) && $item->routers->count() > 0) {
    // Lấy router theo language_id hiện tại
    $router = $item->routers->where('language_id', config('app.language_id'))->first();
    if($router) {
        $canonicalFromRouter = $router->canonical;
    }
}
$canonical = write_url($canonicalFromRouter ?? $language->pivot->canonical ?? $language->canonical ?? '');
```

## Cách hoạt động

1. **Ưu tiên lấy từ bảng `routers`**: Component sẽ tìm trong relation `routers` của item trước
2. **Filter theo language_id**: Chỉ lấy router của ngôn ngữ hiện tại (config('app.language_id'))
3. **Fallback**: Nếu không tìm thấy trong routers, sẽ fallback về `language.pivot.canonical`
4. **Xử lý URL**: Sử dụng helper `write_url()` để thêm domain và suffix

## Kiểm tra

Sau khi áp dụng các thay đổi:

1. Truy cập trang chủ
2. Scroll xuống phần "Review Trường"
3. Click vào bất kỳ trường nào
4. Kiểm tra URL có đúng format: `https://domain.com/ten-truong.html`

## Lưu ý

- Đảm bảo bảng `routers` có dữ liệu đầy đủ cho tất cả schools
- Nếu một school không có router, component sẽ tự động fallback về canonical trong `school_language`
- Relation `routers` sử dụng `morphMany` vì bảng routers là polymorphic (phục vụ nhiều model)

## Files đã thay đổi

1. `app/Models/School.php` - Thêm relation routers và import Router
2. `app/Http/Controllers/Frontend/HomeController.php` - Load relation routers
3. `resources/views/components/review.blade.php` - Cập nhật logic lấy canonical

## Áp dụng cho các model khác

Nếu gặp vấn đề tương tự với các model khác (Post, Scholar, etc.), áp dụng cùng pattern:

```php
// 1. Thêm relation trong model
public function routers(){
    return $this->morphMany(Router::class, 'module');
}

// 2. Load relation khi query
$items = ModelName::with(['languages', 'routers'])->get();

// 3. Lấy canonical từ routers trong blade/component
$router = $item->routers->where('language_id', config('app.language_id'))->first();
$canonical = write_url($router->canonical ?? $fallback);
```
