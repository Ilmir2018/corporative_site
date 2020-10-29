<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Repositories\MenuRepositories;
use App\Repositories\PortfolioRepository;
use Illuminate\Support\Arr;


class PortfolioController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep)
    {
        parent::__construct(new MenuRepositories(new Menu()));

        $this->p_rep = $p_rep;

        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        $this->title = 'Портфолио';

        $this->template = env('THEME') . '.portfolios.portfolios';
    }

    public function index()
    {

        $portfolios = $this->getPortfolio('*',false, true);

        if ($portfolios) {
            $portfolios->load('filter');
        }

        $content = view(env('THEME') . '.portfolios.portfolios_content')->with('portfolios', $portfolios);
        $this->vars = Arr::add($this->vars, 'content', $content);


        return $this->renderOutput();
    }

    public function show($alias)
    {

        $portfolio = $this->p_rep->one($alias);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $portfolios = $this->getPortfolio('*', config('settings.other_portfolios'), false);

        $content = view(env('THEME').'.portfolios.portfolio_content')
            ->with(['portfolio' => $portfolio ,'portfolios' => $portfolios])->render();

        $this->vars = Arr::add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

}
