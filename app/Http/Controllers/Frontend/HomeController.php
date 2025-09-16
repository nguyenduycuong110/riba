<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;
use App\Repositories\Interfaces\LecturerRepositoryInterface as LecturerRepository;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use App\Services\Interfaces\SlideServiceInterface as SlideService;
use App\Enums\SlideEnum;
use Illuminate\Http\Request;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Models\Post;
use App\Models\Lecturer;

class HomeController extends FrontendController
{
    protected $language;
    protected $slideRepository;
    protected $lecturerRepository;
    protected $systemRepository;
    protected $widgetService;
    protected $slideService;
    protected $system;
    protected $postService;

    public function __construct(
        SlideRepository $slideRepository,
        LecturerRepository $lecturerRepository,
        WidgetService $widgetService,
        SlideService $slideService,
        SystemRepository $systemRepository,
        PostService $postService,
    ) {
        $this->slideRepository = $slideRepository;
        $this->lecturerRepository = $lecturerRepository;
        $this->widgetService = $widgetService;
        $this->slideService = $slideService;
        $this->systemRepository = $systemRepository;
        $this->postService = $postService;

        parent::__construct(
            $systemRepository,
        );
    }


    public function index()
    {
        $config = $this->config();

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'product-catalogue', 'object' => true],
            ['keyword' => 'best-selling-course', 'children' => true, 'object' => true, 'promotion' => true],
            ['keyword' => 'new-course-launch', 'object' => true, 'promotion' => true],
            ['keyword' => 'news', 'object' => true],
            ['keyword' => 'videos', 'object' => true],
        ], $this->language);


        $slides = $this->slideService->getSlide(
            [SlideEnum::MAIN, SlideEnum::TECHSTAFF, SlideEnum::PARTNER],
            $this->language
        );

        $lecturers = $this->lecturerRepository->all();

        $system = $this->system;

        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];

        $language = $this->language;

        $schema = $this->schema($seo);

        $ishome = true;

        $template = 'frontend.homepage.home.index';

        return view($template, compact(
            'config',
            'slides',
            'widgets',
            'seo',
            'system',
            'language',
            'ishome',
            'schema',
            'lecturers'
        ));
    }


    private function schema($seo)
    {
        $schema = "<script type='application/ld+json'>
            {
                \"@context\": \"https://schema.org\",
                \"@type\": \"WebSite\",
                \"name\": \"" . $seo['meta_title'] . "\",
                \"url\": \"" . $seo['canonical'] . "\",
                \"description\": \"" . $seo['meta_description'] . "\",
                \"publisher\": {
                    \"@type\": \"Organization\",
                    \"name\": \"" . $seo['meta_title'] . "\"
                },
                \"potentialAction\": {
                    \"@type\": \"SearchAction\",
                    \"target\": {
                        \"@type\": \"EntryPoint\",
                        \"urlTemplate\": \"" . $seo['canonical'] . "search?q={search_term_string}\"
                    },
                    \"query-input\": \"required name=search_term_string\"
                }
            }
            </script>";

        return $schema;
    }

    private function config()
    {
        return [
            'language' => $this->language,
            'css' => [],
            'js' => []
        ];
    }

   



}