<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Front;

use Spiral\Views\ViewsInterface;
use Spiral\Prototype\Traits\PrototypeTrait;
use Psr\Http\Message\ResponseFactoryInterface;
use Nyholm\Psr7\Response;

class FrontController
{
    use PrototypeTrait;

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

    public function storage($type, $id, $file, ResponseFactoryInterface $responseFactory)
    {
        $path = directory('storage');
        $path .= "$type/$id/$file";
        if ( ! $this->files->exists($path)) {
            return;
        }

        $file = $this->files->read($path);

        $response = new Response(200);
        $response->getBody()->write($file);
        return $response;
    }
}
