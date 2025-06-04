<?php

namespace BookStack\Entities\Controllers;

use BookStack\Entities\Models\Page;
use BookStack\Entities\Services\SlideshowService;
use BookStack\Entities\Tools\PageContent;
use BookStack\Http\Controller;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    protected $slideshowService;

    public function __construct(SlideshowService $slideshowService)
    {
        $this->slideshowService = $slideshowService;
    }

    /**
     * Show the presentation view of a page
     */
    public function showPresentation(string $pageId)
    {
        $page = Page::query()->findOrFail($pageId);
        $this->checkOwnablePermission('page-view', $page);

        $pageContent = new PageContent($page);
        $page->html = $pageContent->render();
        
        $sections = $this->slideshowService->extractSections($page);
        
        return view('pages.presentation', [
            'page' => $page,
            'sections' => $sections
        ]);
    }

    /**
     * Show the slideshow view of a page
     */
    public function showSlideshow(string $pageId)
    {
        $page = Page::query()->findOrFail($pageId);
        $this->checkOwnablePermission('page-view', $page);

        $pageContent = new PageContent($page);
        $page->html = $pageContent->render();
        
        $sections = $this->slideshowService->extractSections($page);
        
        return view('pages.slideshow', [
            'page' => $page,
            'sections' => $sections
        ]);
    }
} 