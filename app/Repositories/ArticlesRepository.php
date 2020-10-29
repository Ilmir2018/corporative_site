<?php


namespace App\Repositories;


use App\Models\Article;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function one($alias = false, $attr = [])
    {
        $article = parent::one($alias, $attr);

        //Создается связь с таблицей comments а через
        // эту таблицу создаётся связь с таблицей user
        if ($article && !empty($attr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;

    }
}
