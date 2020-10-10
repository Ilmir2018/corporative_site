<?php


namespace App\Repositories;


use App\Models\Portfolio;

class PortfolioRepository extends Repository
{
    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
    }


}
