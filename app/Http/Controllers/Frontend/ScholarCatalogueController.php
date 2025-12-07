<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V1\Core\WidgetService;
use App\Repositories\Scholar\ScholarCatalogueRepo;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\Scholar\PolicyService;
use App\Services\V2\Impl\Scholar\TrainService;
use Illuminate\Http\Request;
use App\Models\Scholar;

class ScholarCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $scholarService;
    protected $widgetService;
    protected $service;
    protected $repository;
    protected $policyService;
    protected $trainService;

    public function __construct(
        ScholarService $scholarService,
        WidgetService $widgetService,
        ScholarCatalogueService $service,
        ScholarCatalogueRepo $repository,
        PolicyService $policyService,
        TrainService $trainService,
    ) {
        $this->service = $service;
        $this->scholarService = $scholarService;
        $this->widgetService = $widgetService;
        $this->repository = $repository;
        $this->policyService = $policyService;
        $this->trainService = $trainService;
        parent::__construct();
    }


    public function index($id, $request, $page = 1)
    {
        $scholarCatalogue = $this->service->findById($id);
        $childrenIds = $this->service->getCatalogueChildren($scholarCatalogue, new Request())->pluck('id')->toArray();
        

        $scholars = $this->scholarService->pagination($request->merge([
            'sort' => 'order,desc',
            'path' => $scholarCatalogue->languages->first()->pivot->canonical,
            'scholar_catalogue_id' => $scholarCatalogue->id,
            'childrenId' => $childrenIds
        ]));


        $scholarCatalogueList = $this->service->pagination(new Request()->merge([
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

        // dd($policies);



        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'students', 'object' => true],
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);
        $breadcrumb = $this->repository->breadcrumb($scholarCatalogue, $this->language);
        $template = 'frontend.scholar.catalogue.index';
        $config = $this->config();
        $system = $this->system;
        $canonical = ($page > 1) ? write_url($scholarCatalogue->languages->first()->pivot->canonical, true, false).'/trang-'.$page.config('apps.general.suffix'): write_url($scholarCatalogue->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($scholarCatalogue->languages->first()->pivot->meta_title) ?? $scholarCatalogue->languages->first()->pivot->name,
            'meta_keyword' => ($scholarCatalogue->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($scholarCatalogue->languages->first()->meta_description) ?? cut_string_and_decode($scholarCatalogue->languages->first()->description, 168),
            'meta_image' => $scholarCatalogue->languages->first()->image,
            'canonical' => $canonical,
        ];
        $schema = $this->schema($scholarCatalogue, $scholars, $breadcrumb);
        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'schema',
            'scholars',
            'scholarCatalogueList',
            'policies',
            'trains'
        ));
    }

    private function schema($scholarCatalogue, $scholars, $breadcrumb)
    {
        $catName = $scholarCatalogue->languages->first()->pivot->name ?? '';
        $catCanonical = write_url($scholarCatalogue->languages->first()->pivot->canonical ?? '');
        $catDescription = strip_tags($scholarCatalogue->languages->first()->pivot->description ?? '');

        // Build blog post items
        $blogPosts = [];
        foreach ($scholars as $scholar) {
            $name = $scholar->languages->first()->pivot->name ?? '';
            $canonical = write_url($scholar->languages->first()->pivot->canonical ?? '');
            $datePublished = $scholar->created_at ? convertDateTime($scholar->created_at, 'd-m-Y') : '';
            
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
        $query = Scholar::with(['languages', 'scholar_catalogues', 'scholar_policies', 'scholar_trains']);

        // lọc theo policy_id
        if ($request->filled('scholar_policies')) {
            $query->whereIn('policy_id', $request->scholar_policies);
        }

        // lọc theo train_id
        if ($request->filled('scholar_trains')) {
            $query->whereIn('train_id', $request->scholar_trains);
        }

        // lọc theo catalogue (nếu có dạng belongsToMany)
        if ($request->filled('scholar_catalogues')) {
            $query->whereHas('scholar_catalogues', function($q) use ($request) {
                $q->whereIn('scholar_catalogue_id', $request->scholar_catalogues);
            });
        }

        // lọc theo keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('languages', function($q) use ($keyword) {
                $q->where('scholar_language.name', 'LIKE', "%$keyword%");
            });
        }

        $scholars = $query->paginate(12);

        if ($request->ajax()) {
            // trả về partial để update list
            return response()->json([
                'html' => view('frontend.scholar.catalogue._list', compact('scholars'))->render(),
                'count' => $scholars->total(),
            ]);
        }

        return view('frontend.scholar.index', compact('scholars'));
    }

}