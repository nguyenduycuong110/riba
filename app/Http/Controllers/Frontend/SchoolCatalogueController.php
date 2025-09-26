<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\FrontendController;
use App\Services\V2\Impl\School\SchoolService;
use App\Services\V2\Impl\School\SchoolCatalogueService;
use App\Services\V2\Impl\School\AreaService;
use App\Services\V2\Impl\School\CityService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V2\Impl\School\ProjectService;
use App\Services\V2\Impl\Major\MajorCatalogueService;
use App\Services\V2\Impl\Major\MajorService;
use App\Repositories\Core\SystemRepository;
use Illuminate\Http\Request;

class SchoolCatalogueController extends FrontendController
{
    protected $schoolService;
    protected $schoolCatalogueService;
    protected $areaService;
    protected $cityService;
    protected $projectService;
    protected $majorCatalogueService;
    protected $majorService;
    protected $systemRepository;

    public function __construct(
        SchoolService $schoolService,
        SchoolCatalogueService $schoolCatalogueService,
        AreaService $areaService,
        CityService $cityService,
        ScholarService $scholarService,
        ProjectService $projectService,
        MajorCatalogueService $majorCatalogueService,
        MajorService $majorService,
        SystemRepository $systemRepository,
    ) {
        $this->schoolService = $schoolService;
        $this->schoolCatalogueService = $schoolCatalogueService;
        $this->areaService = $areaService;
        $this->cityService = $cityService;
        $this->scholarService = $scholarService;
        $this->projectService = $projectService;
        $this->majorCatalogueService = $majorCatalogueService;
        $this->majorService = $majorService;
        $this->systemRepository = $systemRepository;
    
        parent::__construct(
            $systemRepository,
        );
    }

    public function index(Request $request)
    {
        $request->merge([
            'sort' => 'rank,asc'
        ]);

        $schools = $this->schoolService->pagination($request);

        $areas = $this->areaService->all();

        $cities = $this->cityService->all();

        $scholars = $this->scholarService->all(['languages']);

        $schoolCatalogues = $this->schoolCatalogueService->all(['languages']);

        $projects = $this->projectService->all();

        $majorCatalogues = $this->majorCatalogueService->all(['languages']);
     
        $majors = $this->majorService->all(['languages']);

        $config = $this->config();

        $system = $this->system;

        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];

        $template = 'frontend.school.catalogue.index';

        return view($template, compact(
            'schools',
            'areas',
            'cities',
            'scholars',
            'schoolCatalogues',
            'projects',
            'majorCatalogues',
            'majors',
            'config',
            'seo',
            'system',
        ));
    }


    private function config()
    {
        return [
            'language' => $this->language,
            'css' => [
                '_frontend/resources/style.css'
            ],
            'js' => [
                '_frontend/resources/function.js'
            ]
        ];
    }

}