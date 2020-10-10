<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\MenuRepositories;
use App\Repositories\PortfolioRepository;

class ArticlesController extends SiteController
{
    public function __construct(PortfolioRepository $p_rep, ArticlesRepository $a_rep)
    {
        parent::__construct(new MenuRepositories(new Menu()));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.blog.articles';
    }

    public function index()
    {

        $articles = $this->getArticles();
        dd($articles);
        return $this->renderOutput();
    }

    public function getArticles($alias = false)
    {
        $articles = $this->a_rep->get(['title', 'img', 'created_at', 'alias', 'desc'], false, true);

        if ($articles) {
//            $articles->load(['user', 'category', 'comments']);
        }

        return $articles;
    }
}
