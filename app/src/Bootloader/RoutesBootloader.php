<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace App\Bootloader;

use App\Controller\HomeController;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Router\Route;
use Spiral\Router\RouteInterface;
use Spiral\Router\RouterInterface;
use Spiral\Router\Target\Controller;
use Spiral\Router\Target\Namespaced;
use App\Controller\Front\FrontController;
use Spiral\Router\Target\Action;

class RoutesBootloader extends Bootloader
{
    /**
     * @param RouterInterface $router
     */
    public function boot(RouterInterface $router): void
    {
        /*
         * Front Pages
         * TODO refacto in namespace
         *
         * */
        $router->setRoute(
            'index',
            new Route('/', new Action(FrontController::class, 'index'))
        );

        $router->setRoute(
            'podcasts',
            new Route('podcasts', new Action(FrontController::class, 'podcasts'))
        );

        $router->setRoute(
            'podcast',
            new Route('podcasts/<slug>', new Action(FrontController::class, 'podcast'))
        );

        $router->setRoute(
            'events',
            new Route('events', new Action(FrontController::class, 'events'))
        );

        $router->setRoute(
            'contact',
            new Route('contact', new Action(FrontController::class, 'contact'))
        );
    }
}
