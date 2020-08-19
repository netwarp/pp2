<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Front;

use Spiral\Views\ViewsInterface;

class FrontController
{
    private $title = 'Polis Parallème';

    public function index(ViewsInterface $views)
    {
        $title = $this->title;

        return $views->render('front/index', compact('title'));
    }

    public function podcasts(ViewsInterface $views)
    {
        $title = "$this->title | Podcasts";

        return $views->render('front/podcasts', compact('title'));
    }

    public function podcast($slug)
    {
        var_dump($slug);
    }

    public function events(ViewsInterface $views)
    {
        $title = "$this->title | Events";

        return $views->render('front/events', compact('title'));
    }

    public function contact()
    {
        return 'contact';
    }
}
