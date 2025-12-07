<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

use App\Repositories\Core\SystemRepository;
use App\Services\V1\Core\SlideService;
use App\Enums\SlideEnum;
use App\Services\V1\Core\WidgetService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Models\School;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    protected $systemRepository;
    protected $slideService;
    protected $widgetService;
    protected $scholarService;

    public function __construct(
        SlideService $slideService,
        SystemRepository $systemRepository,
        WidgetService $widgetService,
        ScholarService $scholarService
    ) {
        $this->slideService = $slideService;
        $this->systemRepository = $systemRepository;
        $this->widgetService = $widgetService;
        $this->scholarService = $scholarService;
        
        parent::__construct(
            $systemRepository,
        );
    }


    public function index()
    {
        $config = $this->config();

        $slides = $this->slideService->getSlide(
            [SlideEnum::MAIN, SlideEnum::TECHSTAFF, SlideEnum::PARTNER],
            $this->language
        );

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'commit'],
            ['keyword' => 'about-us'],
            ['keyword' => 'event'],
            ['keyword' => 'scholar-hl', 'object' => true],
            ['keyword' => 'scholars', 'object' => true],
            ['keyword' => 'scholar-catalogues'],
            ['keyword' => 'major-catalogue'],
            ['keyword' => 'share', 'object' => true],
        ], $this->language);



        $scholars = $this->scholarService->pagination(new Request()->merge(['type' => 'all', 'sort' => 'id,asc']));
        
        // Lấy danh sách schools mới nhất cho phần Review trường
        // Lấy 8 bản ghi mới nhất, language_id = 1
        $schools = School::with(['languages'])
            ->where('publish', 2)
            ->whereHas('languages', function($query) {
                $query->where('language_id', 1);
            })
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        $system = $this->system;
        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];
        $schema = $this->schema($seo);
        $template = 'frontend.homepage.home.index';
        return view($template, compact(
            'config',
            'slides',
            'seo',
            'system',
            'schema',
            'widgets',
            'scholars',
            'schools'
        ));
    }


    private function schema($seo)
    {
        $schemaData = [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => $seo['meta_title'] ?? '',
            "url" => $seo['canonical'] ?? '',
            "description" => $seo['meta_description'] ?? '',
            "publisher" => [
                "@type" => "Organization",
                "name" => $seo['meta_title'] ?? ''
            ],
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => [
                    "@type" => "EntryPoint",
                    "urlTemplate" => ($seo['canonical'] ?? '') . "search?q={search_term_string}"
                ],
                "query-input" => "required name=search_term_string"
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
                '__frontend/resources/style.css'
            ],
            'js' => []
        ];
    }

   



}