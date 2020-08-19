<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace App\Bootloader;

use App\Controller\Dashboard\DashboardController;
use App\Controller\Dashboard\EventsController;
use App\Controller\Dashboard\PodcastsController;
use Laminas\Diactoros\Uri;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Router\Route;
use Spiral\Router\RouteInterface;
use Spiral\Router\RouterInterface;
use Spiral\Router\Target\Controller;
use Spiral\Router\Target\Namespaced;
use App\Controller\Front\FrontController;
use Spiral\Router\Target\Action;
use App\Controller\Auth\LoginController;
use Spiral\Csrf\Middleware\CsrfFirewall;
use Spiral\Prototype\Traits\PrototypeTrait;
use Spiral\Router\Target\Group;
use Spiral\Auth\Middleware\Firewall\OverwriteFirewall;

class RoutesBootloader extends Bootloader
{
    use PrototypeTrait;

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
            (new Route(
                '/',
                new Action(
                    FrontController::class,
                    'index'
                )
            ))->withVerbs('GET')
        );

        $router->setRoute(
            'podcasts',
            (new Route(
                'podcasts',
                new Action(
                    FrontController::class,
                    'podcasts'
                )
            ))->withVerbs('GET')
        );

        $router->setRoute(
            'podcast',
            (new Route(
                'podcasts/<slug>',
                new Action(
                    FrontController::class,
                    'podcast'
                )
            ))->withVerbs('GET')
        );

        $router->setRoute(
            'events',
            (new Route(
                'events',
                new Action(
                    FrontController::class,
                    'events'
                )
            ))->withVerbs('GET')
        );

        $router->setRoute(
            'contact',
            (new Route(
                'contact',
                new Action(
                    FrontController::class,
                    'contact'
                )
            ))->withVerbs('GET')
        );

        $route = new Route('login', new Action(LoginController::class, 'login'));
        $router->setRoute(
            'login',
            $route
                ->withVerbs('GET')
                ->withMiddleware(CsrfFirewall::class)
                ->withDefaults(['action' => 'GET'])
        );

        $route = new Route('login', new Action(LoginController::class, 'postLogin'));
        $router->setRoute(
            'postLogin',
            $route->withVerbs('POST')->withDefaults(['action' => 'POST'])
        );


        $router->setRoute(
            'dashboard.dashboard',
            (new Route(
                'dashboard',
                new Action(
                    DashboardController::class,
                    'index'
                )
            ))->withMiddleware(new OverwriteFirewall(new Uri('/login')))
        );

        /*
        $router->setRoute(
            'dashboard.blog',
            (new Route(
                '/dashboard/blog',
                new Action(
                    DashboardController::class,
                    'index'
                )
            ))->withMiddleware(new OverwriteFirewall(new Uri('/login')))
        );
        */

        $router->setRoute(
            'logout',
            new Route('logout', function() {
                $this->auth->close();
                return $this->response->redirect('/');
            })
        );
    }
}
