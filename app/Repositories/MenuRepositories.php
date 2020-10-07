<?php


namespace App\Repositories;

use App\Models\Menu;

class MenuRepositories extends Repository {


    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }
}
