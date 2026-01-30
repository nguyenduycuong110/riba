<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\School;
use App\Models\Post;
use App\Services\V1\Core\WidgetService;
use App\Services\V1\Core\SlideService;
use App\Enums\SlideEnum;
use App\Models\Introduce;
use Illuminate\Http\Request;

class ReviewSchoolController extends FrontendController
{
    protected $language;
    protected $system;
    protected $widgetService;
    protected $slideService;

    public function __construct(
        WidgetService $widgetService,
        SlideService $slideService
    ) {
        $this->widgetService = $widgetService;
        $this->slideService = $slideService;
        parent::__construct();
    }

    public function index(Request $request, $page = null)
    {
        $config = $this->config();
        $system = $this->system;

        // Lấy page từ route parameter hoặc request
        $currentPage = $page ?? $request->get('page', 1);

        // Set paginator current page resolver
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        // Define canonical trước để dùng cho pagination
        $canonical = 'review-cac-truong-dai-hoc';

        // Lấy danh sách schools với pagination
        $perPage = 12;

        $schools = School::with(['languages', 'reviews'])
            ->where('publish', 2)
            ->whereHas('languages', function ($query) {
                $query->where('language_id', 1); // Sử dụng language_id = 1 như HomeController
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withPath(write_url($canonical));

        // Breadcrumb
        $breadcrumb = [
            (object)[
                'languages' => collect([(object)[
                    'pivot' => (object)[
                        'name' => 'Trang chủ',
                        'canonical' => '/'
                    ]
                ]])
            ],
            (object)[
                'languages' => collect([(object)[
                    'pivot' => (object)[
                        'name' => 'Review Các Trường Đại Học',
                        'canonical' => 'review-cac-truong-dai-hoc'
                    ]
                ]])
            ]
        ];

        // Tạo fake PostCatalogue object trước để dùng cho SEO và Schema
        $postCatalogue = new \stdClass();
        $postCatalogue->name = 'Review Các Trường Đại Học';
        $postCatalogue->description = '<p>Khám phá các trường học nổi bật và đánh giá từ học sinh, phụ huynh. Danh sách review các trường đại học Trung Quốc uy tín.</p>';
        $postCatalogue->canonical = $canonical;
        $postCatalogue->direct_children = collect([]); // Không có children
        $postCatalogue->meta_title = 'Review Các Trường Đại Học Trung Quốc';
        $postCatalogue->meta_keyword = 'review trường đại học, đánh giá trường học, review đại học Trung Quốc';
        $postCatalogue->meta_description = 'Khám phá các trường học nổi bật và đánh giá từ học sinh, phụ huynh. Danh sách review các trường đại học Trung Quốc uy tín.';
        $postCatalogue->image = $system['seo_meta_images'] ?? '';

        // Thêm thuộc tính cần thiết cho mỗi school
        foreach ($schools->items() as $school) {
            if (!isset($school->extra) || is_null($school->extra)) {
                $school->extra = '';
            }
            if (!isset($school->comments)) {
                $school->comments = ($school->reviews && method_exists($school->reviews, 'count')) ? $school->reviews->count() : 0;
            }
        }

        // SEO sử dụng helper seo()
        $seo = seo($postCatalogue, $currentPage);

        // Widgets
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'students', 'object' => true],
            ['keyword' => 'product-catalogue', 'object' => true],
        ], $this->language);

        // Slides
        $slides = $this->slideService->getSlide(
            [SlideEnum::MAIN],
            $this->language
        );

        // Latest news
        $lastestNews = Post::with(['languages'])
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->where(['publish' => 2])
            ->limit(8)
            ->get();

        // Introduce
        $introduce = convert_array(Introduce::where('language_id', $this->language)->get(), 'keyword', 'content');

        // Schema
        $schema = $this->schema($postCatalogue, $schools, $breadcrumb);

        // Đổi tên $schools thành $posts để tương thích với view
        $posts = $schools;

        // Sử dụng view mới
        $template = 'frontend.review.school.index';

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'postCatalogue',
            'posts',
            'widgets',
            'schema',
            'slides',
            'introduce',
            'lastestNews'
        ));
    }

    private function schema($postCatalogue, $schools, $breadcrumb)
    {
        $catName = $postCatalogue->name ?? 'Review Các Trường Đại Học';
        $catCanonical = write_url($postCatalogue->canonical ?? 'review-cac-truong-dai-hoc.html');
        $catDescription = strip_tags($postCatalogue->description ?? '');

        // Build blog post items từ schools
        $blogPosts = [];
        foreach ($schools->items() as $school) {
            $name = $school->languages->first()->pivot->name ?? '';
            $canonical = write_url($school->languages->first()->pivot->canonical ?? '');
            $datePublished = $school->created_at ? convertDateTime($school->created_at, 'd-m-Y') : '';

            if (!empty($name) && !empty($canonical)) {
                $blogPosts[] = [
                    "@type" => "BlogPosting",
                    "headline" => $name,
                    "url" => $canonical,
                    "datePublished" => $datePublished,
                ];
            }
        }

        // Build breadcrumb items
        $breadcrumbItems = [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Trang chủ",
                "item" => config('app.url')
            ]
        ];

        $position = 2;
        foreach ($breadcrumb as $item) {
            $itemName = $item->languages->first()->pivot->name ?? '';
            $itemCanonical = write_url($item->languages->first()->pivot->canonical ?? '');

            if (!empty($itemName) && !empty($itemCanonical)) {
                $breadcrumbItems[] = [
                    "@type" => "ListItem",
                    "position" => $position,
                    "name" => $itemName,
                    "item" => $itemCanonical
                ];
                $position++;
            }
        }

        // Build schema data
        $schemaData = [
            [
                "@type" => "BreadcrumbList",
                "itemListElement" => $breadcrumbItems
            ],
            [
                "@context" => "https://schema.org",
                "@type" => "Blog",
                "name" => $catName,
                "description" => $catDescription,
                "url" => $catCanonical,
                "blogPost" => $blogPosts
            ]
        ];

        $schema = "<script type='application/ld+json'>" . json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>";

        return $schema;
    }

    private function config()
    {
        return [
            'language' => $this->language,
            'css' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css',
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css',
                'frontend/resources/css/custom.css'
            ],
            'js' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
                'frontend/resources/library/js/carousel.js',
                'https://getuikit.com/v2/src/js/components/sticky.js'
            ]
        ];
    }
}
