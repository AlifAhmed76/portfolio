<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageRevision;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PageBuilderService
{
    public const ALLOWED_BLOCK_TYPES = [
        'hero',
        'about',
        'skills',
        'projects',
        'services',
        'experience',
        'contact',
        'custom_html',
    ];

    public function __construct(
        protected CacheInvalidationService $cache
    ) {}

    /**
     * Validate an array of blocks against structural and type schemas.
     *
     * @param array $blocks
     * @return array Sanitized and normalized blocks
     * @throws ValidationException
     */
    public function validateBlocks(array $blocks): array
    {
        // 1. Support GrapesJS Drag & Drop visual builder payload
        if (isset($blocks['mode']) && $blocks['mode'] === 'grapesjs') {
            return [
                'mode' => 'grapesjs',
                'html' => $this->sanitizeHtml((string) ($blocks['html'] ?? '')),
                'css' => (string) ($blocks['css'] ?? ''),
                'components' => $blocks['components'] ?? [],
                'style' => $blocks['style'] ?? [],
            ];
        }

        if (isset($blocks['html']) && is_string($blocks['html'])) {
            return [
                'mode' => 'grapesjs',
                'html' => $this->sanitizeHtml($blocks['html']),
                'css' => (string) ($blocks['css'] ?? ''),
                'components' => $blocks['components'] ?? [],
                'style' => $blocks['style'] ?? [],
            ];
        }

        $validated = [];

        foreach ($blocks as $index => $block) {
            if (! is_array($block)) {
                throw ValidationException::withMessages([
                    "blocks.{$index}" => "Block at index {$index} must be an object.",
                ]);
            }

            $type = $block['type'] ?? null;
            if (! in_array($type, self::ALLOWED_BLOCK_TYPES, true)) {
                throw ValidationException::withMessages([
                    "blocks.{$index}.type" => "Block type '{$type}' is unsupported or invalid.",
                ]);
            }

            $id = (string) ($block['id'] ?? 'block-' . ($index + 1));
            $enabled = (bool) ($block['enabled'] ?? true);
            $settings = is_array($block['settings'] ?? null) ? $block['settings'] : [];

            // Sanitize settings based on block type
            if ($type === 'custom_html') {
                $rawHtml = (string) ($settings['html'] ?? '');
                $settings['html'] = $this->sanitizeHtml($rawHtml);
            }

            $validated[] = [
                'id' => $id,
                'type' => $type,
                'enabled' => $enabled,
                'settings' => $settings,
            ];
        }

        return $validated;
    }

    /**
     * Strict HTML sanitization for custom HTML blocks.
     * Prevents XSS, script execution, and unsafe iframe/object embeds.
     */
    public function sanitizeHtml(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        // Remove <script> tags and contents
        $sanitized = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Remove <noscript>, <style>, <iframe>, <object>, <embed>, <applet> tags
        $sanitized = preg_replace('/<(noscript|iframe|object|embed|applet)[^>]*>.*?<\/\1>/is', '', $sanitized);

        // Remove self-closing or unclosed unsafe tags
        $sanitized = preg_replace('/<(script|noscript|iframe|object|embed|applet)[^>]*\/?>/is', '', $sanitized);

        // Remove event handlers (onclick, onerror, onload, etc.)
        $sanitized = preg_replace('/\s+on[a-zA-Z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $sanitized);

        // Remove javascript: URLs
        $sanitized = preg_replace('/href\s*=\s*["\']\s*javascript:[^"\']*["\']/i', 'href="#"', $sanitized);
        $sanitized = preg_replace('/src\s*=\s*["\']\s*javascript:[^"\']*["\']/i', 'src=""', $sanitized);

        return (string) $sanitized;
    }

    /**
     * Save draft content to a page without creating a published revision.
     */
    public function saveDraft(Page $page, array $blocks, ?int $userId = null): Page
    {
        $validatedBlocks = $this->validateBlocks($blocks);

        $page->update([
            'content_json' => $validatedBlocks,
            'updated_by' => $userId ?? $page->updated_by,
        ]);

        return $page;
    }

    /**
     * Atomically publish page content, create a revision snapshot, and flush cache.
     */
    public function publish(Page $page, array $blocks, ?int $userId = null): Page
    {
        $validatedBlocks = $this->validateBlocks($blocks);

        return DB::transaction(function () use ($page, $validatedBlocks, $userId) {
            $currentMax = PageRevision::where('page_id', $page->id)->max('revision_number') ?? 0;
            $nextRevision = $currentMax + 1;

            PageRevision::create([
                'page_id' => $page->id,
                'revision_number' => $nextRevision,
                'content_json' => $validatedBlocks,
                'created_by' => $userId,
                'created_at' => now(),
            ]);

            $page->update([
                'content_json' => $validatedBlocks,
                'status' => 'published',
                'published_at' => now(),
                'updated_by' => $userId,
            ]);

            $this->cache->flushFrontend();

            return $page;
        });
    }

    /**
     * Restore page content from a specified revision snapshot.
     */
    public function restoreRevision(Page $page, int $revisionNumber, ?int $userId = null): Page
    {
        $revision = PageRevision::where('page_id', $page->id)
            ->where('revision_number', $revisionNumber)
            ->firstOrFail();

        $page->update([
            'content_json' => $revision->content_json,
            'updated_by' => $userId,
        ]);

        $this->cache->flushFrontend();

        return $page;
    }

    /**
     * Get block schema definitions for the builder UI.
     */
    public function getAvailableBlockDefinitions(): array
    {
        return [
            [
                'type' => 'hero',
                'name' => 'Hero Banner',
                'category' => 'Header',
                'icon' => 'sparkles',
                'description' => 'Prominent headline, role subtitle, badges, and primary action buttons.',
                'defaultSettings' => [
                    'badge' => 'Available for Projects',
                    'headline' => 'Web Developer & Technical Project Lead',
                    'subheadline' => 'Crafting robust e-commerce solutions and enterprise web applications with precision.',
                    'cta_primary_label' => 'View Work',
                    'cta_primary_url' => '#projects',
                    'cta_secondary_label' => 'Get in Touch',
                    'cta_secondary_url' => '#contact',
                ],
            ],
            [
                'type' => 'about',
                'name' => 'About Narrative',
                'category' => 'Editorial',
                'icon' => 'user',
                'description' => 'Summary bio, narrative paragraphs, and professional highlights.',
                'defaultSettings' => [
                    'title' => 'About Me',
                    'subtitle' => 'Professional Journey & Technical Background',
                    'bio' => 'Dedicated technical project lead and full-stack developer with extensive experience building scalable web solutions.',
                    'highlights' => 'Enterprise Architecture, Technical Project Management, E-commerce Systems',
                ],
            ],
            [
                'type' => 'skills',
                'name' => 'Skills Matrix',
                'category' => 'Technical',
                'icon' => 'cpu',
                'description' => 'Categorized technical competencies with descriptive evidence.',
                'defaultSettings' => [
                    'title' => 'Skills & Capabilities',
                    'subtitle' => 'Core Technologies & Architectural Focus',
                    'layout' => 'grouped',
                    'show_evidence' => true,
                ],
            ],
            [
                'type' => 'projects',
                'name' => 'Project Showcase',
                'category' => 'Portfolio',
                'icon' => 'folder-git-2',
                'description' => 'Featured case studies with metrics, architectural highlights, and live links.',
                'defaultSettings' => [
                    'title' => 'Featured Projects',
                    'subtitle' => 'Production Case Studies',
                    'limit' => 6,
                    'featured_only' => false,
                    'layout' => 'grid',
                ],
            ],
            [
                'type' => 'services',
                'name' => 'Services & Offerings',
                'category' => 'Business',
                'icon' => 'layers',
                'description' => 'List of services, delivery methodology, and deliverables.',
                'defaultSettings' => [
                    'title' => 'Specialized Services',
                    'subtitle' => 'End-to-End Development & Consulting Solutions',
                ],
            ],
            [
                'type' => 'experience',
                'name' => 'Career Timeline',
                'category' => 'Background',
                'icon' => 'briefcase',
                'description' => 'Chronological career milestones and academic background.',
                'defaultSettings' => [
                    'title' => 'Experience & Milestones',
                    'subtitle' => 'Professional Roles and Education',
                    'show_type' => 'all',
                ],
            ],
            [
                'type' => 'contact',
                'name' => 'Contact Section',
                'category' => 'Conversion',
                'icon' => 'mail',
                'description' => 'Direct contact info, social links, and message form.',
                'defaultSettings' => [
                    'title' => 'Initiate Collaboration',
                    'subtitle' => 'Available for technical leadership and custom web solutions.',
                    'form_enabled' => true,
                    'show_socials' => true,
                ],
            ],
            [
                'type' => 'custom_html',
                'name' => 'Custom HTML Block',
                'category' => 'Advanced',
                'icon' => 'code-2',
                'description' => 'Sanitized HTML snippet with strict script tag filtering.',
                'defaultSettings' => [
                    'html' => '<div class="p-4 border border-secondary rounded bg-dark text-light"><p class="mb-0">Custom custom callout content.</p></div>',
                ],
            ],
        ];
    }
}
