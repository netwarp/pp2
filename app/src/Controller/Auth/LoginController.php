<?php
/**
 * {project-name}
 * 
 * @author {author-name}
 */
declare(strict_types=1);

namespace App\Controller\Auth;

use Spiral\Views\ViewsInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Request\LoginRequest;
use App\Database\User;
use Spiral\Auth\AuthContextInterface;
use Spiral\Prototype\Traits\PrototypeTrait;

class LoginController
{
    use PrototypeTrait;

    public function login(ViewsInterface $views, ServerRequestInterface $request, AuthContextInterface $auth)
    {
        if ($auth->getActor() === null) {
            $title = 'Login';
            $csrfToken = $request->getAttribute('csrfToken');
            return $views->render('auth/login', compact('title', 'csrfToken'));
        }
        else {
            return $this->response->redirect('/dashboard');
        }

    }

    public function postLogin(LoginRequest $request)
    {
        if ( ! $request->isValid()) {
            return [
                'status' => 400,
                'errors' => $request->getErrors()
            ];
        }

        $user = $this->users->findOne(['username' => $request->getField('username')]);

        if (
            $user === null ||
            ! password_verify($request->getField('password'), $user->password)
        ) {
            return [
                'status' => 400,
                'error' => 'No such user'
            ];
        }
        $this->auth->start(
            $this->authTokens->create(['userID' => $user->id])
        );

        return $this->response->redirect('/dashboard');
        /*
        return [
            'status'  => 200,
            'message' => 'Authenticated!'
        ];
        */
    }
}