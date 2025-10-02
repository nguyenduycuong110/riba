<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V1\Core\WidgetService;
use App\Services\V1\Core\SlideService;

use App\Repositories\Scholar\ScholarCatalogueRepo;
use App\Repositories\Scholar\ScholarRepo;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\Scholar\PolicyService;
use App\Services\V2\Impl\Scholar\TrainService;
use Illuminate\Http\Request;

use App\Enums\SlideEnum;


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
        // $childrenIds = $this->service->getCatalogueChildren($scholarCatalogue, new Request())->pluck('id')->toArray();
        
        $childrenIds = [11];

        $scholars = $this->scholarService->pagination(new Request()->merge([
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

        $cat_name = $scholarCatalogue->languages->first()->pivot->name;

        $cat_canonical = write_url($scholarCatalogue->languages->first()->pivot->canonical);

        $cat_description = strip_tags($scholarCatalogue->languages->first()->pivot->description);

        $itemListElements = '';

        $position = 1;

        foreach ($scholars as $scholar) {
            $name = $scholar->languages->first()->pivot->name;
            $canonical = write_url($scholar->languages->first()->pivot->canonical);
            $itemListElements .= "
                {
                    \"@type\": \"BlogPosting\",
                    \"headline\": \" " . $name . " \",
                    \"url\": \" " . $canonical . " \",
                    \"datePublished\": \" " . convertDateTime($scholar->created_at, 'd-m-Y') . " \",
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

}