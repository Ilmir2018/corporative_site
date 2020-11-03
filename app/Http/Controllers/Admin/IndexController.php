<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->template = env('THEME') . '.admin.index';

    }

    public function index()
    {
        if (Gate::denies('VIEW_ADMIN')) {
            abort(403);
        }

        $this->title = 'Панель администратора';

        return $this->renderOutput();
    }
}
