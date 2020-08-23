<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Database\Post;
use Cycle\ORM\TransactionInterface;
use Spiral\Router\RouterInterface;
use Spiral\Views\ViewsInterface;
use Spiral\Auth\AuthContextInterface;
use Spiral\Prototype\Traits\PrototypeTrait;
use Cycle\ORM;
use Psr\Http\Message\ServerRequestInterface;
use Carbon\Carbon;
use Redis;
use Spiral\Files\FilesInterface;

class PostsController
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

    public function index(ViewsInterface $views, AuthContextInterface $auth, ORM\ORM $orm, Redis $redis, RouterInterface $router)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $posts = $orm->getRepository(Post::class)->select()->orderBy('id', 'desc');
        $title = 'Posts';

        $redis->connect('127.0.0.1');

        $success = null;
        if ($redis->exists('success')) {
            $success = $redis->get('success');
        }
        $redis->del('success');

        return$views->render('dashboard/posts/index', compact('posts', 'title', 'success'));
    }

    public function create(ViewsInterface $views, AuthContextInterface $auth, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = 'Create new Post';
        $action = '/dashboard/posts/store';
        $csrfToken = $request->getAttribute('csrfToken');



        return $views->render('dashboard/posts/create_or_edit', compact('title', 'action', 'csrfToken'));
    }

    public function store(TransactionInterface $transaction, AuthContextInterface $auth, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $image = '';
        $preview = $this->request->data->get('preview');
        $content = $this->request->data->get('content');
        $status = $this->request->data->get('status');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $post = new Post;
        $post->title = $title;
        $post->slug = $slug;
        $post->image = $image;
        $post->preview = $preview;
        $post->content = $content;
        $post->status = $status;
        $post->created_at = $created_at;
        $post->updated_at = $updated_at;

        $transaction->persist($post)->run();

        // CREATE image
        $id = $post->id;
        $path = directory('storage') . "/posts/{$id}";
        $this->files->ensureDirectory($path, FilesInterface::RUNTIME);

        if ($this->input->file('file')) {
            $file = $this->input->file('file');
            $name = $file->getClientFilename();

            $file->moveTo($path . "/{$name}");

            $image = "/storage/posts/{$id}/{$name}";

            $post->image = $image;
            $transaction->persist($post);
            $transaction->run();
        }

        $redis->connect('127.0.0.1');
        $redis->set('success', 'POST CREATED');

        return $this->response->redirect('/dashboard/posts');
    }

    public function edit($id, ViewsInterface $views, ORM\ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $post = $orm->getRepository(Post::class)->findByPK($id);
        $title = 'Posts';

        $action = "/dashboard/posts/{$id}";
        $csrfToken = $request->getAttribute('csrfToken');


        return $views->render('dashboard/posts/create_or_edit', compact('title', 'action', 'csrfToken', 'post'));
    }

    public function update($id, ORM\ORM $orm, AuthContextInterface $auth, ServerRequestInterface $request, Redis $redis, TransactionInterface $transaction)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $post = $orm->getRepository(Post::class)->findByPK($id);

        $title = $this->request->data->get('title');
        $slug = $this->slugify($title);
        $image = '';
        $preview = $this->request->data->get('preview');
        $content = $this->request->data->get('content');
        $status = $this->request->data->get('status');
        $updated_at = date('Y-m-d H:i:s');

        $post->title = $title;
        $post->slug = $slug;
        $post->image = $image;
        $post->preview = $preview;
        $post->content = $content;
        $post->status = $status;
        $post->updated_at = $updated_at;

        $transaction->persist($post)->run();


        // CREATE image
        $id = $post->id;
        $path = directory('storage') . "/posts/{$id}";
        $this->files->ensureDirectory($path, FilesInterface::RUNTIME);

        if ($this->input->file('file')) {
            $file = $this->input->file('file');
            $name = $file->getClientFilename();

            $file->moveTo($path . "/{$name}");

            $image = "/storage/posts/{$id}/{$name}";

            $post->image = $image;
            $transaction->persist($post);
            $transaction->run();
        }

        $redis->connect('127.0.0.1');
        $redis->set('success', 'POST UPDATED');

        return $this->response->redirect('/dashboard/posts');
    }

    public function destroy($id, AuthContextInterface $auth, ORM\ORM $orm, TransactionInterface $transaction, Redis $redis)
    {
        if ($auth->getActor() === null) {
            return $this->response->redirect('/login');
        }

        $post = $orm->getRepository(Post::class)->findByPK($id);
        $path = directory('storage') . "posts/{$post->id}";
        $this->files->deleteDirectory($path);
        $tr = new ORM\Transaction($orm);
        $tr->delete($post);
        $tr->run();

        $redis->connect('127.0.0.1');
        $redis->set('success', 'POST DELETED');

        return $this->response->redirect('/dashboard/posts');
    }
}
