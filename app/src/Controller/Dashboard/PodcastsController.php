<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Database\Podcast;
use Cycle\ORM\TransactionInterface;
use Spiral\Views\ViewsInterface;
use Spiral\Auth\AuthContextInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Redis;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\Prototype\Traits\PrototypeTrait;
use Spiral\Files\FilesInterface;


class PodcastsController
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

    public function index(AuthContextInterface $auth, ViewsInterface $views, ORM $orm, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $podcasts = $orm->getRepository(Podcast::class)->select()->orderBy('id', 'desc');
        $title = 'Posts';

        $redis->connect('127.0.0.1');

        $success = null;
        if ($redis->exists('success')) {
            $success = $redis->get('success');
        }
        $redis->del('success');

        return $views->render('dashboard/podcasts/index', compact('title', 'podcasts', 'success'));
    }

    public function create(ViewsInterface $views, AuthContextInterface $auth, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = 'Create new Podcast';
        $action = '/dashboard/podcasts/store';
        $csrfToken = $request->getAttribute('csrfToken');

        return $views->render('dashboard/podcasts/create_or_edit', compact('title', 'action', 'csrfToken'));
    }

    public function store(TransactionInterface $transaction, AuthContextInterface $auth, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $source = '';
        $content = $this->request->data->get('content');
        $status = $this->request->data->get('status');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $podcast = new Podcast;
        $podcast->title = $title;
        $podcast->slug = $slug;
        $podcast->source = $source;
        $podcast->content = $content;
        $podcast->status = $status;
        $podcast->created_at = $created_at;
        $podcast->updated_at = $updated_at;

        $transaction->persist($podcast)->run();

        // CREATE image
        $id = $podcast->id;
        $path = directory('storage') . "/podcasts/{$id}";
        $this->files->ensureDirectory($path, FilesInterface::RUNTIME);

        if ($this->input->file('file')) {
            $file = $this->input->file('file');
            $name = $file->getClientFilename();
            $name = $this->slugify($name);

            $file->moveTo($path . "/{$name}");

            $source = "/storage/podcasts/{$id}/{$name}";

            $podcast->source = $source;
            $transaction->persist($podcast);
            $transaction->run();
        }

        $redis->connect('127.0.0.1');
        $redis->set('success', 'PODCAST CREATED');

        return $this->response->redirect('/dashboard/podcasts');
    }

    public function edit($id, ViewsInterface $views, ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $podcast = $orm->getRepository(Podcast::class)->findByPK($id);
        $title = 'Podcasts';

        $action = "/dashboard/podcasts/{$id}";
        $csrfToken = $request->getAttribute('csrfToken');

        return $views->render('dashboard/podcasts/create_or_edit', compact('title', 'action', 'csrfToken', 'podcast'));
    }

    public function update($id, ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request, Redis $redis, TransactionInterface $transaction)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $podcast = $orm->getRepository(Podcast::class)->findByPK($id);

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $content = $this->request->data->get('content');
        $status = $this->request->data->get('status');
        $updated_at = date('Y-m-d H:i:s');

        $podcast->title = $title;
        $podcast->slug = $slug;

        $podcast->content = $content;
        $podcast->status = $status;
        $podcast->updated_at = $updated_at;

        $transaction->persist($podcast)->run();


        // CREATE source
        $id = $podcast->id;
        $path = directory('storage') . "/podcasts/{$id}";
        $this->files->ensureDirectory($path, FilesInterface::RUNTIME);

        if ($this->input->file('file')) {
            $file = $this->input->file('file');
            $name = $file->getClientFilename();
            $name = $this->slugify($name);

            $file->moveTo($path . "/{$name}");

            $source = "/storage/podcasts/{$id}/{$name}";

            $podcast->source = $source;
            $transaction->persist($podcast);
            $transaction->run();
        }

        $redis->connect('127.0.0.1');
        $redis->set('success', 'PODCAST UPDATED');

        return $this->response->redirect('/dashboard/podcasts');
    }

    public function destroy($id, AuthContextInterface $auth, ORM $orm, Transaction $transaction, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }
        $podcast = $orm->getRepository(Podcast::class)->findByPK($id);
        $path = directory('storage') . "podcasts/{$podcast->id}";

        $this->files->deleteDirectory($path);
        $transaction = new Transaction($orm);
        $transaction->delete($podcast);
        $transaction->run();


        $redis->connect('127.0.0.1');
        $redis->set('success', 'POST DELETED');

        return $this->response->redirect('/dashboard/podcasts');
    }
}
