<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Dashboard;

use Spiral\Views\ViewsInterface;
use Spiral\Auth\AuthContextInterface;
use Spiral\Prototype\Traits\PrototypeTrait;

class DashboardController
{
    use PrototypeTrait;

    public function index(ViewsInterface $views, AuthContextInterface $auth)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = 'dashboard';
        return $views->render('dashboard/index', compact('title'));
    }
}
