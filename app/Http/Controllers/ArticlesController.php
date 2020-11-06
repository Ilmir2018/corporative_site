<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\MenuRepositories;
use App\Repositories\PortfolioRepository;
use Illuminate\Support\Arr;

class ArticlesController extends SiteController
{
    public function __construct(PortfolioRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {
        parent::__construct(new MenuRepositories(new Menu()));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.blog.articles';
    }

    /**
     * @param false $cat_alias Если есть параметр в роутинге то
     * можно осуществить просмотр например одной категории товаров
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index($cat_alias = false)
    {

        $articles = $this->getArticles($cat_alias);

        $content = view(env('THEME').'.blog.articles-content')->with('articles', $articles)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));

        $portfolios = $this->getPortfolio(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], config('settings.recent_portfolios'), false);

        $this->contentRightBar = view(env('THEME').'.blog.articlesBar')
            ->with(['comments'=>$comments, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }

    public function getArticles($alias = false)
    {

        $where = false;

        if ($alias) {
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(['title', 'img', 'created_at', 'alias', 'desc', 'user_id', 'category_id', 'id', 'keywords', 'meta_desc'], false, true, $where);

        /*
         *Оптимизация Sql запросов (жадная загрузка, которая
         * выполняется в начале формирования страницы)
         * в load мы указываем модели для связаннных таблиц
         */
        if ($articles) {
            $articles->load(['user', 'category', 'comments']);
        }

        return $articles;
    }

    private function getComments($take)
    {
        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        /*
         *Оптимизация Sql запросов (жадная загрузка, которая
         * выполняется в начале формирования страницы)
         * в load мы указываем модели для связаннных таблиц
         */
        if ($comments) {
            $comments->load(['article', 'user']);
        }

        return $comments;
    }

    protected function show($alias = false)
    {

        $article = $this->a_rep->one($alias, ['comments' => true]);

        if ($article) {
            $article->img = json_decode($article->img);
        }

        if (isset($article->id)) {
            $this->title = $article->title;
            $this->keywords = $article->keywords;
            $this->meta_desc = $article->meta_desc;
        }

        $content = view(env('THEME').'.blog.article_content')->with('article', $article)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));

        $portfolios = $this->getPortfolio(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], config('settings.recent_portfolios'), false);

        $this->contentRightBar = view(env('THEME').'.blog.articlesBar')
            ->with(['comments'=>$comments, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }
}
