<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Post\PostCatalogueRepository;
use App\Services\V1\Post\PostCatalogueService;
use App\Services\V1\Post\PostService;
use App\Services\V1\Core\WidgetService;
use App\Services\V1\Core\SlideService;

use App\Models\System;
use App\Enums\SlideEnum;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Introduce;
use App\Models\Post;

class PostCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $postCatalogueRepository;
    protected $postCatalogueService;
    protected $postService;
    protected $widgetService;
    protected $slideService;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        PostCatalogueService $postCatalogueService,
        PostService $postService,
        WidgetService $widgetService,
        SlideService $slideService,
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->postCatalogueService = $postCatalogueService;
        $this->postService = $postService;
        $this->widgetService = $widgetService;
        $this->slideService = $slideService;
        parent::__construct();
    }


    public function index($id, $request, $page = 1)
    {
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, $this->language);
        $postCatalogue->children = $this->postCatalogueRepository->findByCondition(
            [
                ['publish', '=', 2],
                ['parent_id', '=', $postCatalogue->id]
            ],
            true,
            [],
            ['order', 'desc']
        );
        
        $breadcrumb = $this->postCatalogueRepository->breadcrumb($postCatalogue, $this->language);
        $posts = $this->postService->paginate(
            $request,
            $this->language,
            $postCatalogue,
            $page,
            ['path' => $postCatalogue->canonical],
            ['posts.recommend', 'desc']
        );

        // dd($posts->toArray());

        $featuredPost = $this->postCatalogueRepository->getFeaturedPost($postCatalogue);

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'students', 'object' => true],
            ['keyword' => 'product-catalogue', 'object' => true],
            
        ], $this->language);

        $slides = $this->slideService->getSlide(
            [SlideEnum::MAIN],
            $this->language
        );
        $lastestNews = Post::with(['languages'])->orderBy('order', 'desc')->orderBy('id', 'desc')->where(['publish' => 2])->limit(8)->get();
        // dd($lastestNews);

        if($postCatalogue->canonical === 've-chung-toi'){
            $template = 'frontend.post.catalogue.intro';
        }else{
            $template = 'frontend.post.catalogue.index';
        }

        $config = $this->config();
        $system = $this->system;
        $seo = seo($postCatalogue, $page);
        $introduce = convert_array(Introduce::where('language_id', $this->language)->get(), 'keyword', 'content');
        $schema = $this->schema($postCatalogue, $posts, $breadcrumb);
        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'postCatalogue',
            'posts',
            'widgets',
            'schema',
            'slides',
            'introduce',
            'lastestNews'
        ));
    }

    private function schema($postCatalogue, $posts, $breadcrumb)
    {
        $catName = $postCatalogue->languages->first()->pivot->name ?? '';
        $catCanonical = write_url($postCatalogue->languages->first()->pivot->canonical ?? '');
        $catDescription = strip_tags($postCatalogue->languages->first()->pivot->description ?? '');

        // Build blog post items
        $blogPosts = [];
        foreach ($posts as $post) {
            $name = $post->languages->first()->pivot->name ?? '';
            $canonical = write_url($post->languages->first()->pivot->canonical ?? '');
            $datePublished = $post->created_at ? convertDateTime($post->created_at, 'd-m-Y') : '';
            
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

}