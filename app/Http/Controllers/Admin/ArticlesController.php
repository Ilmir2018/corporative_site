<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Repositories\ArticlesRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends AdminController
{

    public function __construct(ArticlesRepository $a_rep, CategoryRepository $c_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;
        $this->template = env('THEME') . '.admin.articles';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::denies('view_admin_articles')) {
            abort(403);
        }

        $this->title = 'Менеджер статей';

        $articles = $this->getArticles();
        $this->content = view(env('THEME'). '.admin.articles_content')->with('articles', $articles)->render();
        $this->vars = Arr::add($this->vars, 'content', $this->content);

        return $this->renderOutput();


    }

    public function getArticles()
    {
        return $this->a_rep->get();
    }

    public function getCategory()
    {
        return $this->c_rep->get(['title', 'alias', 'parent_id', 'id']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('save', new Article())) {
            abort(403);
        }

        $this->title = 'Добавить новый материал';

        $categories = $this->getCategory();

        $lists = [];

        //Группировка категорий
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $lists[$category->title] = [];
            } else {
                //Возвращаем коллекицю моделей
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME') . '.admin.articles_create_content')->with('categories', $lists)->render();
        $this->vars = Arr::add($this->vars, 'content', $this->content);

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //
        $result = $this->a_rep->addArticle($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {

        //Проверка прав пользователя, методы в данном случае save, edit
        //храняться в ArticlePolicy
        if (Gate::denies('edit', new Article())) {
            abort(403);
        }

        $this->title = 'Редактирование материала - ' . $article->title;

        $article->img = json_decode($article->img);

        $categories = $this->getCategory();

        $lists = [];

        //Группировка категорий
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $lists[$category->title] = [];
            } else {
                //Возвращаем коллекицю моделей
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME') . '.admin.articles_create_content')->with(['categories' => $lists, 'article' => $article])->render();
        $this->vars = Arr::add($this->vars, 'content', $this->content);

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        //

        $result = $this->a_rep->updateArticle($request, $article);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
        $result = $this->a_rep->deleteArticle($article);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
    }
}
