<?php


namespace App\Repositories;


use App\Models\Slider;

class SliderRepositories extends Repository
{

    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }

}
