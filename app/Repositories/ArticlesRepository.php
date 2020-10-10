<?php


namespace App\Repositories;


use App\Models\Article;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }
}
