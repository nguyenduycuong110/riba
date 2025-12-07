<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Repositories\Scholar\ScholarCatalogueRepo;
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


        $scholar->scholar_admissions->load(['languages', 'admission_schools.languages']);

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
        // Lưu giá trị gốc trước khi bị ghi đè trong vòng lặp
        $postName = $post->languages->first()->pivot->name ?? '';
        $postImage = $post->image ?? '';
        $postDescription = strip_tags($post->languages->first()->pivot->description ?? '');
        $postCanonical = write_url($post->languages->first()->pivot->canonical ?? '');
        $postDatePublished = $post->created_at ? convertDateTime($post->created_at, 'd-m-y') : '';
        $postDateModified = $post->updated_at ? convertDateTime($post->updated_at, 'd-m-y') : '';
        $articleSection = $postCatalogue->languages->first()->pivot->name ?? '';

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
                "@type" => "BlogPosting",
                "headline" => $postName,
                "description" => $postDescription,
                "url" => $postCanonical,
                "datePublished" => $postDatePublished,
                "dateModified" => $postDateModified,
                "articleSection" => $articleSection,
            ]
        ];

        // Add image if exists
        if (!empty($postImage)) {
            $schemaData[1]["image"] = $postImage;
        }

        $schema = "<script type=\"application/ld+json\">" . json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>";
        
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
