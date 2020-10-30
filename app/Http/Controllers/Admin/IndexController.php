<?php

namespace App\Http\Controllers\Admin;


class IndexController extends AdminController
{

    public function __construct()
    {
        parent::__construct();

        $this->template = env('THEME') . '.admin.index';

    }

    public function index()
    {
        $this->title = 'Панель администратора';

        return $this->renderOutput();
    }
}
