<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepositories;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class SiteController extends Controller
{
    //

    protected $p_rep;
    protected $s_rep;
    protected $a_rep;
    protected $m_rep;

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template;

    protected $vars = [];

    protected $contentRightBar = false;
    protected $contentLeftBar = false;

    protected $bar = 'no';

    public function __construct(MenuRepositories $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {

        $menu = $this->getMenu();

        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu);
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if ($this->contentRightBar) {
            $rightBar = view(env('THEME') . '.rightbar')->with('content_rightBar', $this->contentRightBar)->render();
        }

        $this->vars = Arr::add($this->vars, 'rightBar', $rightBar);
        $this->vars = Arr::add($this->vars, 'bar', $this->bar);

        $footer = view(env('THEME'). '.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        $this->vars = Arr::add($this->vars, 'keywords', $this->keywords);
        $this->vars = Arr::add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = Arr::add($this->vars, 'title', $this->title);

        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {

        $menu = $this->m_rep->get();

//        dd($menu);

        $mBuilder = \Menu::make('MyNav', function($m) use ($menu) {

            foreach ($menu as $item) {

                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        return $mBuilder;
    }

    protected function getSliders()
    {
        $sliders = $this->s_rep->get();

        if ($sliders->isEmpty()) {
            return false;
        }
        $sliders->transform(function ($item, $key) {
            $item->img =  Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });

//        dd($sliders);

        return $sliders;
    }

    protected function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_port_count'));

        return $portfolio;
    }

}
