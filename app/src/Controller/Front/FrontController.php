<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Front;

class FrontController
{
    public function index()
    {
        return 'welcome home';
    }

    public function podcasts()
    {
        return 'ALL podcasts 0.0.00.0.';
    }

    public function podcast($slug)
    {
        var_dump($slug);
    }

    public function events()
    {
        return 'events';
    }

    public function contact()
    {
        return 'contact';
    }
}
