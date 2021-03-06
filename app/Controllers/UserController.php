<?php

namespace App\Controllers;

use App\Models\User;
use Core\BaseController;
use Core\Redirect;
use Core\Container;
use Core\Authenticate;

class UserController extends BaseController
{
    use Authenticate;

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = Container::getModel("User");
    }

    public function create()
    {
        $this->setPageTitle('New User');
        return $this->renderView('user/create', 'layout');
    }

    public function store($request)
    {
        $data = [
            'name' => $request->post->name,
            'email' => $request->post->email,
            'password' => $request->post->password
        ];

        $data['password'] = password_hash($request->post->password, PASSWORD_BCRYPT);

        try {
            $this->user->create($data);
            return Redirect::route('/', [
                'success' => ['Usuário criado com sucesso!']
            ]);
        } catch (\Exception $e) {
            return Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
        }
    }
}
