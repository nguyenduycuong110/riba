<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Repositories\Scholar\ScholarCatalogueRepo;

use Jenssegers\Agent\Facades\Agent;
use App\Models\Post;
use App\View\Components\TableOfContents;
use App\Models\Scholar;

class ScholarController extends FrontendController
{
    protected $language;
    protected $system;
    protected $scholarCatalogueService;
    protected $scholarService;
    protected $scholarCatalogueRepo;

    public function __construct(
        ScholarCatalogueService $scholarCatalogueService,
        ScholarService $scholarService,
        ScholarCatalogueRepo $scholarCatalogueRepo
    ){
        $this->scholarCatalogueService = $scholarCatalogueService;
        $this->scholarService = $scholarService;
        $this->scholarCatalogueRepo = $scholarCatalogueRepo;
        parent::__construct(); 
    }


    public function index($id, $request){
        $language = $this->language;
        $scholar = $this->scholarService->findById($id, ['*']);    
        if(!$scholar){
            abort(404);
        }

        $scholarCatalogue = $scholar->scholar_catalogues()->with('languages')->first();
        // dd($scholarCatalogue);
        $breadcrumb = $this->scholarCatalogueRepo->breadcrumb($scholarCatalogue, $this->language);


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);

        /* ------------------- */
        
        $config = $this->config();
        $system = $this->system;
        $canonical = write_url($scholar->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($scholar->languages->first()->pivot->meta_title) ?? $scholar->languages->first()->pivot->name,
            'meta_keyword' => ($scholar->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($scholar->languages->first()->meta_description) ?? cut_string_and_decode($scholar->languages->first()->description, 168),
            'meta_image' => $scholar->languages->first()->image,
            'canonical' => $canonical,
        ];

        // dd($scholarCatalogue);

        // dd( $scholar->scholar_catalogues->pluck('id')->toArray());
        $relatedScholars = Scholar::with(['languages'])
         ->whereHas('scholar_catalogues', function($q) use ($scholar) {
            $q->whereIn('scholar_catalogue_id', $scholar->scholar_catalogues->pluck('id')->toArray());
        })
        ->where('id', '!=', $scholar->id) // bỏ chính nó
        ->where('publish', 2)
        ->limit(6)
        ->get();


        $scholar->scholar_admissions->load(['languages', 'admission_schools']);

        $template = 'frontend.scholar.scholar.index';
        $schema = $this->schema($scholar, $scholarCatalogue, $breadcrumb);
        $content = $scholar->languages->first()->pivot->content;
        $items = TableOfContents::extract($content);
        $contentWithToc = null;
        $contentWithToc = TableOfContents::injectIds($content, $items);

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'scholarCatalogue',
            'scholar',
            // 'widgets',
            'schema',
            'contentWithToc',
            'relatedScholars'
        ));
    }

    private function schema($post, $postCatalogue, $breadcrumb){

        $image = $post->image;

        $name = $post->languages->first()->pivot->name;

        $description = strip_tags($post->languages->first()->pivot->description);

        $canonical = write_url($post->languages->first()->pivot->canonical);

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

        $schema = "
            <script type=\"application/ld+json\">
                {
                    \"@type\": \"BreadcrumbList\",
                    \"itemListElement\": [
                        {
                            \"@type\": \"ListItem\",
                            \"position\": 1,
                            \"name\": \" Trang chủ  \",
                            \"item\": \" ". config('app.url') . " \"
                        },
                        $itemBreadcrumbElements
                    ]
                },
                {
                    \"@context\": \"https://schema.org\",
                    \"@type\": \"BlogPosting\",
                    \"headline\": \" " . $name .  " \",
                    \"description\": \"  " . $description .  "  \",
                    \"image\": \"  " . $image .  "  \",
                    \"url\": \"  " . $canonical .  "  \",
                    \"datePublished\": \"  " . convertDateTime($post->created_at, 'd-m-y') .  "  \",
                    \"dateModified\": \"  " . convertDateTime($post->created_at, 'd-m-y') .  "  \",
                    \"author\": [
                        \"@type\": \"Person\",
                        \"name\": \"\",
                        \"url\": \"\",
                    ],
                    \"publisher\": [
                        \"@type\": \"Organization\",
                        \"name\": \" An Hưng  \",
                        \"logo\": [
                            \"@type\": \"ImageObject\",
                            \"url\": \"   \",
                        ],
                    ],
                    \"mainEntityOfPage\": [
                        \"@type\": \"Organization\",
                        \"@id\": \" " . $canonical . " \",
                    ],
                    \"articleSection\": \"  " . $postCatalogue->languages->first()->pivot->name .  "  \",
                    \" keywords \": \"  \",
                    \" timeRequired \": \"  \",
                    \"about\": [
                        \"@type\": \"Thing\",
                        \"name\": \" \",
                    ],
                    \"mentions\": [
                        {
                            \"@type\": \"Product\",
                            \"name\": \" \",
                        }
                    ],
                }
            </script>
        ";
        return $schema;

    } 

    private function config(){
        return [
            'language' => $this->language,
            'js' => [
                'frontend/core/library/cart.js',
                'frontend/core/library/product.js',
                'frontend/core/library/review.js',
                'https://prohousevn.com/scripts/fancybox-3/dist/jquery.fancybox.min.js'
            ],
            'css' => [
                'frontend/core/css/product.css',
                'https://prohousevn.com/scripts/fancybox-3/dist/jquery.fancybox.min.css'
            ]
        ];
    }

}
