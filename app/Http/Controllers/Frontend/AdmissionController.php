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
    ) {
        $this->admissionCatalogueService = $admissionCatalogueService;
        $this->admissionService = $admissionService;
        $this->admissionCatalogueRepo = $admissionCatalogueRepo;
        parent::__construct();
    }


    public function index($id, $request)
    {
        $language = $this->language;
        $admission = $this->admissionService->findById($id, ['*']);
        if (!$admission) {
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
        $relateds = Admission::with(['languages', 'scholars.scholar_catalogues.languages', 'admission_schools', 'admission_trains'])
            ->whereHas('admission_catalogues', function ($q) use ($admission) {
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

    private function schema($post, $postCatalogue, $breadcrumb)
    {
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

    private function config()
    {
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
