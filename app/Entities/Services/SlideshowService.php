<?php

namespace BookStack\Entities\Services;

use BookStack\Entities\Models\Page;

class SlideshowService
{
    /**
     * Extract sections from page content
     */
    public function extractSections(Page $page): array
    {
        // First try to extract existing sections
        preg_match_all('/<section.*?<\/section>/is', $page->html, $matches);
        $sections = $matches[0];
        
        // If no sections found, create sections from content
        if (empty($sections)) {
            $parts = preg_split('/(?=Slide\s+\d+)/i', $page->html);
            $sections = [];
            
            foreach ($parts as $part) {
                $part = trim($part);
                if (!empty($part)) {
                    if (preg_match('/^(Slide\s+\d+)(.*)/is', $part, $matches)) {
                        $heading = trim($matches[1]);
                        $content = trim($matches[2]);
                        $sections[] = sprintf(
                            '<section><h2>%s</h2>%s</section>',
                            $heading,
                            $content
                        );
                    }
                }
            }
        }
        
        return $sections;
    }
} 