<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V1\Core\WidgetService;
use App\Repositories\School\SchoolCatalogueRepo;
use App\Services\V2\Impl\School\SchoolService;
use App\Services\V2\Impl\School\SchoolCatalogueService;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\School\AreaService;
use App\Services\V2\Impl\School\CityService;
use App\Services\V2\Impl\School\ProjectService;
use App\Services\V2\Impl\Scholar\PolicyService;
use App\Services\V2\Impl\Scholar\TrainService;
use App\Services\V2\Impl\Major\MajorCatalogueService;
use App\Services\V2\Impl\Major\MajorService;
use Illuminate\Http\Request;
use App\Models\School;

class SchoolCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $schoolService;
    protected $areaService;
    protected $cityService;
    protected $projectService;
    protected $scholarCatalogueService;
    protected $widgetService;
    protected $service;
    protected $repository;
    protected $policyService;
    protected $trainService;
    protected $majorService;
    protected $majorCatalogueService;

    public function __construct(
        SchoolService $schoolService,
        WidgetService $widgetService,
        SchoolCatalogueService $service,
        SchoolCatalogueRepo $repository,
        AreaService $areaService,
        ScholarCatalogueService $scholarCatalogueService,
        CityService $cityService,
        ProjectService $projectService,
        PolicyService $policyService,
        TrainService $trainService,
        MajorService $majorService,
        MajorCatalogueService $majorCatalogueService,
    ) {
        $this->service = $service;
        $this->schoolService = $schoolService;
        $this->widgetService = $widgetService;
        $this->repository = $repository;
        $this->areaService = $areaService;
        $this->scholarCatalogueService = $scholarCatalogueService;
        $this->cityService = $cityService;
        $this->projectService = $projectService;
        $this->policyService = $policyService;
        $this->trainService = $trainService;
        $this->majorCatalogueService = $majorCatalogueService;
        $this->majorService = $majorService;
        parent::__construct();
    }


    public function index($id, $request, $page = 1)
    {
        $schoolCatalogue = $this->service->findById($id);
        $childrenIds = $this->service->getCatalogueChildren($schoolCatalogue, new Request())->pluck('id')->toArray();
        

        $schools = $this->schoolService->pagination(new Request()->merge([
            'sort' => 'order,desc',
            'path' => $schoolCatalogue->languages->first()->pivot->canonical,
            'school_catalogue_id' => $schoolCatalogue->id,
            'childrenId' => $childrenIds
        ]));

        $schoolCatalogueList = $this->service->pagination(new Request()->merge([
            'type' => 'all',
            'level' => 2,
            'sort' => 'id,asc'
        ]));

        $policies = $this->policyService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $trains = $this->trainService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $areas = $this->areaService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $cities = $this->cityService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $scholarCatalogues = $this->scholarCatalogueService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $projects = $this->projectService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $majors = $this->majorService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $majorCatalogues = $this->majorCatalogueService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $breadcrumb = $this->repository->breadcrumb($schoolCatalogue, $this->language);

        $template = 'frontend.school.catalogue.index';

        $config = $this->config();

        $system = $this->system;

        $canonical = ($page > 1) ? write_url($schoolCatalogue->languages->first()->pivot->canonical, true, false).'/trang-'.$page.config('apps.general.suffix'): write_url($schoolCatalogue->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($schoolCatalogue->languages->first()->pivot->meta_title) ?? $schoolCatalogue->languages->first()->pivot->name,
            'meta_keyword' => ($schoolCatalogue->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($schoolCatalogue->languages->first()->meta_description) ?? cut_string_and_decode($schoolCatalogue->languages->first()->description, 168),
            'meta_image' => $schoolCatalogue->languages->first()->image,
            'canonical' => $canonical,
        ];

        $schema = $this->schema($schoolCatalogue, $schools, $breadcrumb);

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'schema',
            'schools',
            'schoolCatalogueList',
            'policies',
            'trains',
            'areas',
            'cities',
            'scholarCatalogues',
            'projects',
            'majors',
            'majorCatalogues'
        ));
    }

    private function schema($schoolCatalogue, $schools, $breadcrumb)
    {

        $cat_name = $schoolCatalogue->languages->first()->pivot->name;

        $cat_canonical = write_url($schoolCatalogue->languages->first()->pivot->canonical);

        $cat_description = strip_tags($schoolCatalogue->languages->first()->pivot->description);

        $itemListElements = '';

        $position = 1;

        foreach ($schools as $school) {
            $name = $school->languages->first()->pivot->name;
            $canonical = write_url($school->languages->first()->pivot->canonical);
            $itemListElements .= "
                {
                    \"@type\": \"BlogPosting\",
                    \"headline\": \" " . $name . " \",
                    \"url\": \" " . $canonical . " \",
                    \"datePublished\": \" " . convertDateTime($school->created_at, 'd-m-Y') . " \",
                    \"author\": {
                        \"@type\": \" Person  \",
                        \"name\": \" An Hưng \",
                    }
                },";
            $position++;
        }

        $itemListElements = rtrim($itemListElements, ',');

        $itemBreadcrumbElements = '';

        $positionBreadcrumb = 2;

        foreach ($breadcrumb as $key => $item) {
            $name = $item->languages->first()->pivot->name;
            $canonical = write_url($item->languages->first()->pivot->canonical);
            $itemBreadcrumbElements .= "
                {
                    \"@type\": \"ListItem\",
                    \"position\": $positionBreadcrumb,
                    \"name\": \"" . $name . "\",
                    \"item\": \"" . $canonical . "\",
                },";
            $positionBreadcrumb++;
        }

        $itemBreadcrumbElements = rtrim($itemBreadcrumbElements, ',');

        $schema = "<script type='application/ld+json'>
            {
                \"@type\": \"BreadcrumbList\",
                \"itemListElement\": [
                    {
                        \"@type\": \"ListItem\",
                        \"position\": 1,
                        \"name\": \" Trang chủ  \",
                        \"item\": \" " . config('app.url') . " \"
                    },
                    $itemBreadcrumbElements
                ]
            },
            {
                \"@context\": \"https://schema.org\",
                \"@type\": \"Blog\",
                \"name\": \"" . $cat_name . "\",
                \"description\": \" " . $cat_description . " \",
                \"url\": \"" . $cat_canonical . "\",
                \"publisher\": [
                    \"@type\": \"Organization\",
                    \"name\": \" An Hưng \",
                ],
                \"blogPost\": {
                    $itemListElements
                }
            }
            </script>";
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


    public function filter(Request $request)
    {
        $query = School::with(['languages', 'school_areas', 'school_cities', 'school_projects', 'school_catalogues']);

        if ($request->filled('school_areas')) {
            $query->whereIn('area_id', $request->school_areas);
        }

        if ($request->filled('school_cities')) {
            $query->whereIn('city_id', $request->school_cities);
        }

        if ($request->filled('school_projects')) {
            $query->whereHas('school_projects', function($q) use ($request) {
                $q->whereIn('project_id', $request->school_projects);
            });
        }

        // lọc theo catalogue (nếu có dạng belongsToMany)
        if ($request->filled('school_catalogues')) {
            $query->whereHas('school_catalogues', function($q) use ($request) {
                $q->whereIn('school_catalogue_id', $request->school_catalogues);
            });
        }

        if ($request->filled('major_catalogues')) {
            $query->whereHas('school_catalogues', function($q) use ($request) {
                $q->whereIn('school_catalogue_id', $request->school_catalogues);
            });
        }

        // lọc theo keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('languages', function($q) use ($keyword) {
                $q->where('school_language.name', 'LIKE', "%$keyword%");
            });
        }

        $schools = $query->paginate(12);

        if ($request->ajax()) {
            // trả về partial để update list
            return response()->json([
                'html' => view('frontend.school.catalogue._list', compact('schools'))->render(),
                'count' => $schools->total(),
            ]);
        }

        return view('frontend.school.index', compact('schools'));
    }

}