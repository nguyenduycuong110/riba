<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\V2\Impl\School\SchoolCatalogueService;
use App\Services\V2\Impl\School\SchoolService;
use App\Repositories\School\SchoolCatalogueRepo;

use Jenssegers\Agent\Facades\Agent;
use App\Models\Post;
use App\View\Components\TableOfContents;
use App\Models\School;

class SchoolController extends FrontendController
{
    protected $language;
    protected $system;
    protected $schoolCatalogueService;
    protected $schoolService;
    protected $schoolCatalogueRepo;

    public function __construct(
        SchoolCatalogueService $schoolCatalogueService,
        SchoolService $schoolService,
        SchoolCatalogueRepo $schoolCatalogueRepo
    ){
        $this->schoolCatalogueService = $schoolCatalogueService;
        $this->schoolService = $schoolService;
        $this->schoolCatalogueRepo = $schoolCatalogueRepo;
        parent::__construct(); 
    }


    public function index($id, $request){
        $language = $this->language;
        $school = $this->schoolService->findById($id, ['*']);    
        if(!$school){
            abort(404);
        }

        $schoolCatalogue = $school->school_catalogues()->with('languages')->first();

        // dd($schoolCatalogue);
        $breadcrumb = $this->schoolCatalogueRepo->breadcrumb($schoolCatalogue, $this->language);


        // $widgets = $this->widgetService->getWidget([
        //     ['keyword' => 'product-catalogue', 'object' => true],
            
        // ], $this->language);

        /* ------------------- */
        
        $config = $this->config();
        $system = $this->system;
        $canonical = write_url($school->languages->first()->pivot->canonical, true, true);

        $seo = [
            'meta_title' => ($school->languages->first()->pivot->meta_title) ?? $school->languages->first()->pivot->name,
            'meta_keyword' => ($school->languages->first()->meta_keyword) ?? '',
            'meta_description' => ($school->languages->first()->meta_description) ?? cut_string_and_decode($school->languages->first()->description, 168),
            'meta_image' => $school->languages->first()->image,
            'canonical' => $canonical,
        ];

        // dd($schoolCatalogue);

        // dd( $school->school_catalogues->pluck('id')->toArray());
        $relateds = School::with(['languages'])
         ->whereHas('school_catalogues', function($q) use ($school) {
            $q->whereIn('school_catalogue_id', $school->school_catalogues->pluck('id')->toArray());
        })
        ->where('id', '!=', $school->id) // bỏ chính nó
        ->where('publish', 2)
        ->limit(6)
        ->get();


        $template = 'frontend.school.school.index';
        $schema = $this->schema($school, $schoolCatalogue, $breadcrumb);
        $content = $school->languages->first()->pivot->content;
        $items = TableOfContents::extract($content);
        $contentWithToc = null;
        $contentWithToc = TableOfContents::injectIds($content, $items);

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'schoolCatalogue',
            'school',
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

    public function compare(){
        $config = $this->config();
        $system = $this->system;
        $canonical = write_url('so-sanh-truong');

        $seo = [
            'meta_title' => 'So sánh các trường đại học',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => $canonical,
        ];

        $schools = $this->schoolService->pagination(new Request(['type' => 'all', 'take' => 4, 'sort' => 'id,desc']));

        $template = 'frontend.school.school.compare';
      
        return view($template, compact(
            'config',
            'seo',
            'system',
            'schools'
        ));
    }

}
