<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Database\Event;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Cycle\ORM\TransactionInterface;
use Redis;
use Spiral\Prototype\Traits\PrototypeTrait;
use Spiral\Auth\AuthContextInterface;
use Spiral\Views\ViewsInterface;
use Psr\Http\Message\ServerRequestInterface;

/*
 * php app.php cycle
 * */
class EventsController
{
    use PrototypeTrait;

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function index(AuthContextInterface $auth, ORM $orm, Redis $redis, ViewsInterface $views)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $events = $orm->getRepository(Event::class)->select()->orderBy('id', 'desc');
        $title = 'Events';

        $redis->connect('127.0.0.1');

        $success = null;
        if ($redis->exists('success')) {
            $success = $redis->get('success');
        }
        $redis->del('success');

        return $views->render('dashboard/events/index', compact('events', 'title', 'success'));
    }

    public function create(AuthContextInterface $auth, ViewsInterface $views, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = 'Create new Event';
        $action = '/dashboard/events/store';
        $csrfToken = $request->getAttribute('csrfToken');

        return $views->render('dashboard/events/create_or_edit', compact('title', 'action', 'csrfToken'));
    }

    public function store(TransactionInterface $transaction, AuthContextInterface $auth, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $date = $this->request->data->get('date');

        $event = new Event;
        $event->title = $title;
        $event->slug = $slug;
        $event->date = $date;

        $transaction->persist($event)->run();

        $redis->connect('127.0.0.1');
        $redis->set('success', 'EVENT CREATED');

        return $this->response->redirect('/dashboard/events');
    }

    public function edit($id, ViewsInterface $views, ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $event = $orm->getRepository(Event::class)->findByPK($id);
        $title = 'Events';

        $action = "/dashboard/events/{$id}";
        $csrfToken = $request->getAttribute('csrfToken');

        return $views->render('dashboard/events/create_or_edit', compact('title', 'action', 'csrfToken', 'event'));
    }

    public function update($id, ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request, Redis $redis, TransactionInterface $transaction)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $event = $orm->getRepository(Event::class)->findByPK($id);

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $date = $this->request->data->get('date');

        $event->title = $title;
        $event->slug = $slug;
        $event->date = $date;

        $transaction->persist($event)->run();

        $redis->connect('127.0.0.1');
        $redis->set('success', 'EVENT UPDATED');

        return $this->response->redirect('/dashboard/events');
    }

    public function destroy($id, AuthContextInterface $auth, ORM $orm, Transaction $transaction, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }
        $event = $orm->getRepository(Event::class)->findByPK($id);

        $transaction = new Transaction($orm);
        $transaction->delete($event);
        $transaction->run();

        $redis->connect('127.0.0.1');
        $redis->set('success', 'EVENT DELETED');

        return $this->response->redirect('/dashboard/events');
    }
}
