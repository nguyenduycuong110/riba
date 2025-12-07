<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\V2\Impl\Major\MajorCatalogueService;
use App\Services\V2\Impl\Major\MajorService;
use App\Repositories\Major\MajorCatalogueRepo;

use Jenssegers\Agent\Facades\Agent;
use App\Models\Post;
use App\View\Components\TableOfContents;
use App\Models\Major;

class MajorController extends FrontendController
{
    protected $language;
    protected $system;
    protected $majorCatalogueService;
    protected $majorService;
    protected $majorCatalogueRepo;

    public function __construct(
        MajorCatalogueService $majorCatalogueService,
        MajorService $majorService,
        MajorCatalogueRepo $majorCatalogueRepo
    ){
        $this->majorCatalogueService = $majorCatalogueService;
        $this->majorService = $majorService;
        $this->majorCatalogueRepo = $majorCatalogueRepo;
        parent::__construct(); 
    }


    public function index($id, $request){
        $language = $this->language;
        $major = $this->majorService->findById($id, ['*']);    
        if(!$major){
            abort(404);
        }

        $majorCatalogue = $major->major_groups()->with('languages')->first();

        // dd($majorCatalogue);
        $breadcrumb = $this->majorCatalogueRepo->breadcrumb($majorCatalogue, $this->language);


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);

        /* ------------------- */
        
        $config = $this->config();
        $system = $this->system;
        $canonical = write_url($major->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($major->languages->first()->pivot->meta_title) ?? $major->languages->first()->pivot->name,
            'meta_keyword' => ($major->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($major->languages->first()->meta_description) ?? cut_string_and_decode($major->languages->first()->description, 168),
            'meta_image' => $major->languages->first()->image,
            'canonical' => $canonical,
        ];

        // dd($majorCatalogue);

        // dd( $major->admission_catalogues->pluck('id')->toArray());
        $relateds = Major::with(['languages'])
         ->whereHas('major_catalogues', function($q) use ($major) {
            $q->whereIn('major_catalogue_id', $major->major_catalogues->pluck('id')->toArray());
        })
        ->where('id', '!=', $major->id) // bỏ chính nó
        ->where('publish', 2)
        ->limit(6)
        ->get();


        $template = 'frontend.major.major.index';
        $schema = $this->schema($major, $majorCatalogue, $breadcrumb);
        $content = $major->languages->first()->pivot->content;
        $items = TableOfContents::extract($content);
        $contentWithToc = null;
        $contentWithToc = TableOfContents::injectIds($content, $items);

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'majorCatalogue',
            'major',
            // 'widgets',
            'schema',
            'contentWithToc',
            'relateds'
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
