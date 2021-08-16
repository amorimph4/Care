<?php

namespace App\Controllers;

use Core\BaseController;
use Core\SeederDataBase;

class HomeController extends BaseController
{
    public function index()
    {
        SeederDataBase::tablesCreation();
        $this->setPageTitle('Home');
        $this->renderView('home/index', 'layout');
    }
}
