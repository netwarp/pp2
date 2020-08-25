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
use App\Controller\Dashboard\PostsController;
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
                '/dashboard',
                new Action(
                    DashboardController::class,
                    'index'
                )
            ))
                ->withVerbs('GET')
        );

        /**
         * Posts
         */
        $route = (new Route('/dashboard/posts', new Action(PostsController::class, 'index')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.posts.index', $route);

        $route = (new Route('/dashboard/posts/create', new Action(PostsController::class, 'create')))
            ->withVerbs('GET')
            ->withMiddleware(CsrfFirewall::class);
        $router->setRoute('dashboard.posts.create', $route);

        $route = (new Route('/dashboard/posts/store', new Action(PostsController::class, 'store')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.posts.store', $route);

        $route = (new Route('/dashboard/posts/<id>', new Action(PostsController::class, 'edit')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.posts.edit', $route);

        $route = (new Route('/dashboard/posts/<id>', new Action(PostsController::class, 'update')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.posts.update', $route);

        $route = (new Route('/dashboard/posts/delete/<id>', new Action(PostsController::class, 'destroy')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.posts.destroy', $route);

        /**
         * Podcasts
         */
        $route = (new Route('/dashboard/podcasts', new Action(PodcastsController::class, 'index')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.podcasts.index', $route);

        $route = (new Route('/dashboard/podcasts/create', new Action(PodcastsController::class, 'create')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.podcasts.create', $route);

        $route = (new Route('/dashboard/podcasts/store', new Action(PodcastsController::class, 'store')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.podcasts.store', $route);

        $route = (new Route('/dashboard/podcasts/<id>', new Action(PodcastsController::class, 'edit')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.podcasts.edit', $route);

        $route = (new Route('/dashboard/podcasts/<id>', new Action(PodcastsController::class, 'update')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.podcasts.update', $route);

        $route = (new Route('/dashboard/podcasts/delete/<id>', new Action(PodcastsController::class, 'destroy')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.podcasts.destroy', $route);

        /**
         * Events
         */
        $route = (new Route('/dashboard/events', new Action(EventsController::class, 'index')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.events.index', $route);

        $route = (new Route('/dashboard/events/create', new Action(EventsController::class, 'create')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.events.create', $route);

        $route = (new Route('/dashboard/events/store', new Action(EventsController::class, 'store')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.events.store', $route);

        $route = (new Route('/dashboard/events/<id>', new Action(EventsController::class, 'edit')))
            ->withVerbs('GET');
        $router->setRoute('dashboard.events.edit', $route);

        $route = (new Route('/dashboard/events/<id>', new Action(EventsController::class, 'update')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.events.update', $route);

        $route = (new Route('/dashboard/events/delete/<id>', new Action(EventsController::class, 'destroy')))
            ->withVerbs('POST');
        $router->setRoute('dashboard.events.destroy', $route);

        $router->setRoute(
            'logout',
            new Route('logout', function() {
                $this->auth->close();
                return $this->response->redirect('/');
            })
        );

        $route = (new Route('/storage/<type>/<id>/<file>', new Action(FrontController::class, 'storage')));
        $router->setRoute('storage', $route);
    }
}
