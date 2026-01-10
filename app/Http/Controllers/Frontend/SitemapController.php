<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Router;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate and return sitemap.xml
     */
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $suffix = config('apps.general.suffix', '.html');
        
        // Start XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Add static pages (trang chủ)
        $xml .= $this->generateUrlTag($baseUrl . '/', date('Y-m-d'), 'daily', '1.0');
        
        // Get all routers from database
        // Option 1: Get all languages (currently active)
        $routers = Router::whereNotNull('canonical')
            ->where('canonical', '!=', '')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        // Option 2: Only get default language (language_id = 1)
        // Uncomment the code below and comment the above if you want only default language
        // $routers = Router::where('language_id', 1)
        //     ->whereNotNull('canonical')
        //     ->where('canonical', '!=', '')
        //     ->orderBy('updated_at', 'desc')
        //     ->get();
        
        foreach ($routers as $router) {
            if (!empty($router->canonical)) {
                // Đảm bảo canonical không bắt đầu bằng dấu /
                $canonical = ltrim($router->canonical, '/');
                $url = $baseUrl . '/' . $canonical . $suffix;
                $lastmod = $router->updated_at ? $router->updated_at->format('Y-m-d') : date('Y-m-d');
                $xml .= $this->generateUrlTag($url, $lastmod, 'weekly', '0.8');
            }
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
    
    /**
     * Generate a single URL tag for sitemap
     */
    private function generateUrlTag(string $url, string $lastmod, string $changefreq, string $priority): string
    {
        $url = htmlspecialchars($url, ENT_XML1, 'UTF-8');
        $xml = "  <url>\n";
        $xml .= "    <loc>{$url}</loc>\n";
        $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
        $xml .= "    <changefreq>{$changefreq}</changefreq>\n";
        $xml .= "    <priority>{$priority}</priority>\n";
        $xml .= "  </url>\n";
        
        return $xml;
    }
}
