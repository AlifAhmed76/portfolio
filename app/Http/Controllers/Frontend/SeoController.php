<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $baseUrl = url('/');

        $projects = Project::where('status', 'published')->get(['slug', 'updated_at']);
        $posts = Post::published()->get(['slug', 'updated_at']);
        $pages = Page::where('status', 'published')->get(['slug', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $xml .= "  <url>\n    <loc>{$baseUrl}</loc>\n    <changefreq>weekly</changefreq>\n    <priority>1.0</priority>\n  </url>\n";

        // Projects Index
        $xml .= "  <url>\n    <loc>{$baseUrl}/projects</loc>\n    <changefreq>weekly</changefreq>\n    <priority>0.8</priority>\n  </url>\n";

        // Published Projects
        foreach ($projects as $project) {
            $loc = "{$baseUrl}/projects/{$project->slug}";
            $lastmod = $project->updated_at->toAtomString();
            $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$lastmod}</lastmod>\n    <priority>0.8</priority>\n  </url>\n";
        }

        // Blog Index
        $xml .= "  <url>\n    <loc>{$baseUrl}/blog</loc>\n    <changefreq>weekly</changefreq>\n    <priority>0.8</priority>\n  </url>\n";

        // Published Blog Posts
        foreach ($posts as $post) {
            $loc = "{$baseUrl}/blog/{$post->slug}";
            $lastmod = $post->updated_at->toAtomString();
            $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$lastmod}</lastmod>\n    <priority>0.7</priority>\n  </url>\n";
        }

        // Custom Pages
        foreach ($pages as $page) {
            $loc = "{$baseUrl}/{$page->slug}";
            $lastmod = $page->updated_at->toAtomString();
            $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$lastmod}</lastmod>\n    <priority>0.6</priority>\n  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots(): Response
    {
        $baseUrl = url('/');
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /*?theme_preview=*\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
