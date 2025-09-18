<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

use App\Repositories\Core\SystemRepository;
use App\Repositories\Core\LecturerRepository;
use App\Repositories\Product\ProductRepository;

use Illuminate\Http\Request;

class LecturerController extends FrontendController
{
    protected $language;
    protected $systemRepository;
    protected $lecturerRepository;
    protected $productRepository;

    public function __construct(
        SystemRepository $systemRepository,
        LecturerRepository $lecturerRepository,
        ProductRepository $productRepository,
    ) {
        $this->systemRepository = $systemRepository;
        $this->lecturerRepository = $lecturerRepository;
        $this->productRepository = $productRepository;

        parent::__construct(
            $systemRepository,
        );
    }

    public function index(string $canonical = '', Request $request)
    {
        
        $lecturer = $this->lecturerRepository->findByCondition([
            ['canonical','=', $canonical]
        ]);

        $allLecturers = $this->lecturerRepository->all();

        $products = $this->productRepository->findByCondition([
            ['lecturer_id','=', $lecturer->id]
        ], true);

        $config = $this->config();

        $system = $this->system;

        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];

        $language = $this->language;

        $template = 'frontend.lecturer.index';

        return view($template, compact(
            'config',
            'seo',
            'system',
            'language',
            'lecturer',
            'products',
            'allLecturers'
        ));
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