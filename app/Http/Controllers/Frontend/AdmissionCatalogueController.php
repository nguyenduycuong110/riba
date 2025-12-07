<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V1\Core\WidgetService;
use App\Services\V1\Core\SlideService;

use App\Repositories\Admission\AdmissionCatalogueRepo;
use App\Repositories\Admission\AdmissionRepo;
use App\Services\V2\Impl\Admission\AdmissionService;
use App\Services\V2\Impl\Admission\AdmissionCatalogueService;
use App\Services\V2\Impl\Admission\PolicyService;
use App\Services\V2\Impl\Scholar\TrainService;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use Illuminate\Http\Request;

use App\Enums\SlideEnum;

use Illuminate\Support\Facades\DB;
use App\Models\Admission;


class AdmissionCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $admissionService;
    protected $widgetService;
    protected $service;
    protected $repository;
    protected $trainService;
    protected $scholarCatalogueService;

    public function __construct(
        AdmissionService $admissionService,
        WidgetService $widgetService,
        AdmissionCatalogueService $service,
        AdmissionCatalogueRepo $repository,
        TrainService $trainService,
        ScholarCatalogueService $scholarCatalogueService
    ) {
        $this->service = $service;
        $this->admissionService = $admissionService;
        $this->widgetService = $widgetService;
        $this->repository = $repository;
        $this->trainService = $trainService;
        $this->scholarCatalogueService = $scholarCatalogueService;
        parent::__construct();
    }


    public function index($id, $request, $page = 1)
    {
        $admissionCatalogue = $this->service->findById($id);
        $childrenIds = $this->service->getCatalogueChildren($admissionCatalogue, new Request())->pluck('id')->toArray();
        

        $admissions = $this->admissionService->pagination(new Request()->merge([
            'sort' => 'order,desc',
            'path' => $admissionCatalogue->languages->first()->pivot->canonical,
            'scholar_catalogue_id' => $admissionCatalogue->id,
            'childrenId' => $childrenIds
        ]));


        $admissionCatalogueList = $this->service->pagination(new Request()->merge([
            'type' => 'all',
            'level' => 2,
            'sort' => 'id,asc'
        ]));

        $trains = $this->trainService->pagination(new Request()->merge([
            'type' => 'all'
        ]));

        $scholarCatalogueList = $this->scholarCatalogueService->pagination(new Request()->merge([
            'type' => 'all',
            'level' => 2,
            'sort' => 'id,asc'
        ]));


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'students', 'object' => true],
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);
        $breadcrumb = $this->repository->breadcrumb($admissionCatalogue, $this->language);
        $template = 'frontend.admission.catalogue.index';
        $config = $this->config();
        $system = $this->system;
        $canonical = ($page > 1) ? write_url($admissionCatalogue->languages->first()->pivot->canonical, true, false).'/trang-'.$page.config('apps.general.suffix'): write_url($admissionCatalogue->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($admissionCatalogue->languages->first()->pivot->meta_title) ?? $admissionCatalogue->languages->first()->pivot->name,
            'meta_keyword' => ($admissionCatalogue->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($admissionCatalogue->languages->first()->meta_description) ?? cut_string_and_decode($admissionCatalogue->languages->first()->description, 168),
            'meta_image' => $admissionCatalogue->languages->first()->image,
            'canonical' => $canonical,
        ];
        $schema = $this->schema($admissionCatalogue, $admissions, $breadcrumb);
        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'schema',
            'admissions',
            'admissionCatalogueList',
            'scholarCatalogueList',
            'trains'
        ));
    }

    private function schema($admissionCatalogue, $admissions, $breadcrumb)
    {
        $catName = $admissionCatalogue->languages->first()->pivot->name ?? '';
        $catCanonical = write_url($admissionCatalogue->languages->first()->pivot->canonical ?? '');
        $catDescription = strip_tags($admissionCatalogue->languages->first()->pivot->description ?? '');

        // Build blog post items
        $blogPosts = [];
        foreach ($admissions as $admission) {
            $name = $admission->languages->first()->pivot->name ?? '';
            $canonical = write_url($admission->languages->first()->pivot->canonical ?? '');
            $datePublished = $admission->created_at ? convertDateTime($admission->created_at, 'd-m-Y') : '';
            
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


    public function filter(Request $request)
    {
        $query = Admission::with([
            'languages',
            'scholars.scholar_catalogues.languages',
            'admission_catalogues',
            'admission_trains',
            'admission_schools',
        ]);

        // lọc theo train_id (quan hệ n-n admission_trains)
        if ($request->filled('scholar_trains')) {
            $query->whereHas('admission_trains', function($q) use ($request) {
                $q->whereIn('train_id', $request->scholar_trains);
            });
        }

        if ($request->filled('admission_catalogues')) {
            $query->whereIn('admission_catalogue_id', $request->admission_catalogues);
        }

      
        // lọc theo loại học bổng (thông qua scholars -> scholar_catalogues)
        if ($request->filled('scholar_catalogues')) {
            $query->whereHas('scholars.scholar_catalogues', function($q) use ($request) {
                $q->whereIn('scholar_catalogue_id', $request->scholar_catalogues);
            });
        }

        // lọc theo keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('languages', function($q) use ($keyword) {
                $q->where('admission_language.name', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('admission_deadline')) {
            $today = now()->toDateString();
            $deadlines = $request->input('admission_deadline', []);

            $query->where(function ($q) use ($deadlines, $today) {
                if (in_array("0", $deadlines, true)) {
                    $q->orWhereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(admissions_info, '$.apply_deadline')), '%Y-%m-%d') >= ?", [$today]);
                }

                if (in_array("1", $deadlines, true)) {
                    $q->orWhereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(admissions_info, '$.apply_deadline')), '%Y-%m-%d') < ?", [$today]);
                }
            });
        }

        if ($request->filled('min_year') && $request->filled('max_year')) {
            $query->whereBetween(
                DB::raw("CAST(JSON_UNQUOTE(JSON_EXTRACT(admissions_info, '$.season')) AS UNSIGNED)"),
                [$request->min_year, $request->max_year]
            );
        }


        $admissions = $query->paginate(12);
        // $admissions = $query->toSql();
        // // dd($admissions);

        if ($request->ajax()) {
            // trả về partial để update list
            return response()->json([
                'html' => view('frontend.admission.catalogue._list', compact('admissions'))->render(),
                'count' => $admissions->total(),
            ]);
        }

        // return view('frontend.scholar.index', compact('scholars'));
    }

}