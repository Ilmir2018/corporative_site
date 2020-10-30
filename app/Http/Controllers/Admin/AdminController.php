<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Menu;

class AdminController extends Controller
{

    protected $p_rep;
    protected $a_rep;

    protected $user;
    protected $template;

    protected $content = false;

    protected $title;

    protected $vars;

    public function __construct()
    {

        $this->user = Auth::user();

//        if (!$this->user) {
//            abort(403);
//        }

    }

    public function renderOutput()
    {

        $this->vars = Arr::add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $navigation = view(env('THEME') . '.admin.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if ($this->content) {
            $this->vars = Arr::add($this->vars, 'content', $this->content);
        }

        $footer = view(env('THEME') . '.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars)->render();


    }

    public function getMenu()
    {

        return \Menu::make('adminMenu', function ($menu) {

            $menu->add('Статьи', ['route' => 'articles.index']);

            $menu->add('Портфолио', ['route' => 'articles.index']);
            $menu->add('Меню', ['route' => 'articles.index']);
            $menu->add('Пользователи', ['route' => 'articles.index']);
            $menu->add('Привилегии', ['route' => 'articles.index']);

        });

    }
}
