<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Dashboard;

use Spiral\Views\ViewsInterface;

class DashboardController
{
    public function index(ViewsInterface $views)
    {
        $title = 'dashboard';

        return $views->render('dashboard/index', compact('title'));
    }
}
