<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\V2\Impl\Admission\AdmissionCatalogueService;
use App\Services\V2\Impl\Admission\AdmissionService;
use App\Repositories\Admission\AdmissionCatalogueRepo;

use Jenssegers\Agent\Facades\Agent;
use App\Models\Post;
use App\View\Components\TableOfContents;
use App\Models\Admission;

class AdmissionController extends FrontendController
{
    protected $language;
    protected $system;
    protected $admissionCatalogueService;
    protected $admissionService;
    protected $admissionCatalogueRepo;

    public function __construct(
        AdmissionCatalogueService $admissionCatalogueService,
        AdmissionService $admissionService,
        AdmissionCatalogueRepo $admissionCatalogueRepo
    ){
        $this->admissionCatalogueService = $admissionCatalogueService;
        $this->admissionService = $admissionService;
        $this->admissionCatalogueRepo = $admissionCatalogueRepo;
        parent::__construct(); 
    }


    public function index($id, $request){
        $language = $this->language;
        $admission = $this->admissionService->findById($id, ['*']);    
        if(!$admission){
            abort(404);
        }

        $admissionCatalogue = $admission->admission_catalogues()->with('languages')->first();

        // dd($admissionCatalogue);
        $breadcrumb = $this->admissionCatalogueRepo->breadcrumb($admissionCatalogue, $this->language);


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);

        /* ------------------- */
        
        $config = $this->config();
        $system = $this->system;
        $canonical = write_url($admission->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($admission->languages->first()->pivot->meta_title) ?? $admission->languages->first()->pivot->name,
            'meta_keyword' => ($admission->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($admission->languages->first()->meta_description) ?? cut_string_and_decode($admission->languages->first()->description, 168),
            'meta_image' => $admission->languages->first()->image,
            'canonical' => $canonical,
        ];

        // dd($admissionCatalogue);

        // dd( $admission->admission_catalogues->pluck('id')->toArray());
        $relateds = Admission::with(['languages'])
         ->whereHas('admission_catalogues', function($q) use ($admission) {
            $q->whereIn('admission_catalogue_id', $admission->admission_catalogues->pluck('id')->toArray());
        })
        ->where('id', '!=', $admission->id) // bỏ chính nó
        ->where('publish', 2)
        ->limit(6)
        ->get();


        $template = 'frontend.admission.admission.index';
        $schema = $this->schema($admission, $admissionCatalogue, $breadcrumb);
        $content = $admission->languages->first()->pivot->content;
        $items = TableOfContents::extract($content);
        $contentWithToc = null;
        $contentWithToc = TableOfContents::injectIds($content, $items);

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'admissionCatalogue',
            'admission',
            // 'widgets',
            'schema',
            'contentWithToc',
            'relateds'
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
