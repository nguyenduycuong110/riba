<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V1\Core\WidgetService;
use App\Repositories\Major\MajorCatalogueRepo;
use App\Services\V2\Impl\Major\MajorService;
use App\Services\V2\Impl\Major\MajorCatalogueService;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Services\V2\Impl\Scholar\TrainService;
use App\Services\V2\Impl\Major\MajorGroupService;

class MajorCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $majorService;
    protected $widgetService;
    protected $service;
    protected $repository;
    protected $policyService;
    protected $trainService;
    protected $majorGroupService;

    public function __construct(
        MajorService $majorService,
        WidgetService $widgetService,
        MajorCatalogueService $service,
        MajorCatalogueRepo $repository,
        TrainService $trainService,
        MajorGroupService $majorGroupService
    ) {
        $this->service = $service;
        $this->majorService = $majorService;
        $this->widgetService = $widgetService;
        $this->repository = $repository;
        $this->trainService = $trainService;
        $this->majorGroupService = $majorGroupService;
        parent::__construct();
    }


    public function index($id, $request, $page = 1)
    {
        $majorCatalogue = $this->service->findById($id);
        $childrenIds = $this->service->getCatalogueChildren($majorCatalogue, new Request())->pluck('id')->toArray();
        

        $majors = $this->majorService->pagination($request->merge([
            'sort' => 'order,desc',
            'path' => $majorCatalogue->languages->first()->pivot->canonical,
            'major_catalogue_id' => $majorCatalogue->id,
            'childrenId' => $childrenIds
        ]));

        $majorCatalogueList = $this->majorGroupService->pagination(new Request([
            'type' => 'all',
            'level' => 2,
            'sort' => 'id,asc'
        ]));

        $trains = $this->trainService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        // dd($trains);


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'students', 'object' => true],
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);
        $breadcrumb = $this->repository->breadcrumb($majorCatalogue, $this->language);
        $template = 'frontend.major.catalogue.index';
        $config = $this->config();
        $system = $this->system;
        $canonical = ($page > 1) ? write_url($majorCatalogue->languages->first()->pivot->canonical, true, false).'/trang-'.$page.config('apps.general.suffix'): write_url($majorCatalogue->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($majorCatalogue->languages->first()->pivot->meta_title) ?? $majorCatalogue->languages->first()->pivot->name,
            'meta_keyword' => ($majorCatalogue->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($majorCatalogue->languages->first()->meta_description) ?? cut_string_and_decode($majorCatalogue->languages->first()->description, 168),
            'meta_image' => $majorCatalogue->languages->first()->image,
            'canonical' => $canonical,
        ];
        $schema = $this->schema($majorCatalogue, $majors, $breadcrumb);
        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'schema',
            'majors',
            'majorCatalogueList',
            'trains',
        ));
    }

    private function schema($majorCatalogue, $majors, $breadcrumb)
    {

        $cat_name = $majorCatalogue->languages->first()->pivot->name;

        $cat_canonical = write_url($majorCatalogue->languages->first()->pivot->canonical);

        $cat_description = strip_tags($majorCatalogue->languages->first()->pivot->description);

        $itemListElements = '';

        $position = 1;

        foreach ($majors as $major) {
            $name = $major->languages->first()->pivot->name;
            $canonical = write_url($major->languages->first()->pivot->canonical);
            $itemListElements .= "
                {
                    \"@type\": \"BlogPosting\",
                    \"headline\": \" " . $name . " \",
                    \"url\": \" " . $canonical . " \",
                    \"datePublished\": \" " . convertDateTime($major->created_at, 'd-m-Y') . " \",
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
        $query = Major::with(['languages', 'major_catalogues', 'major_groups', 'major_trains']);

        // lọc theo policy_id
        if ($request->filled('major_groups')) {
            $query->whereIn('major_group_id', $request->major_groups);
        }

        // lọc theo train_id
        if ($request->filled('scholar_trains')) {
            $query->whereIn('train_id', $request->scholar_trains);
        }

        // // lọc theo catalogue (nếu có dạng belongsToMany)
        // if ($request->filled('major_catalogues')) {
        //     $query->whereHas('major_catalogues', function($q) use ($request) {
        //         $q->whereIn('major_catalogue_id', $request->major_catalogues);
        //     });
        // }

        // lọc theo keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('languages', function($q) use ($keyword) {
                $q->where('major_language.name', 'LIKE', "%$keyword%");
            });
        }

        $majors = $query->paginate(12);

        if ($request->ajax()) {
            // trả về partial để update list
            return response()->json([
                'html' => view('frontend.major.catalogue._list', compact('majors'))->render(),
                'count' => $majors->total(),
            ]);
        }

        return view('frontend.major.index', compact('majors'));
    }

}