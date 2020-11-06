<?php


namespace App\Repositories;


use App\Models\Article;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

    public function addArticle($request)
    {
        if (\Illuminate\Support\Facades\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        //Если поле псевдонима пустое, мы загружаем трансформированное содержимое поля title
        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        //Производися проверка уникальность поля alias
        if ($this->one($data['alias'], false)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        //Проверка того, загружаем ли мы изображение на сервер.
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {

                $str = Str::random(8);

                //Создание типичного объекта встроенного в пхп
                $obj = new \stdClass();

                $obj->mini = $str. '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                //Работаем с библиотекой intervention/image
                $img = Image::make($image);


                //Есть 3 метода, fit, resize, crop. resize - изменяет качество но сохраняет пропорции,
                //fit - сохраняет качество но пропорции изменяются, crop - просто обрезает изображения с нужного угла
                $img->resize(Config::get('settings.image')['width'], Config::get('settings.image')['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->path);
                $img->resize(Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->max);
                $img->resize(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);
                $this->model->fill($data);

                if ($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Материал добавлен'];
                }
            }
        }
    }

    public function updateArticle($request, $article)
    {
        if (\Illuminate\Support\Facades\Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image', '_method');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        //Если поле псевдонима пустое, мы загружаем трансформированное содержимое поля title
        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'], false);
        //Производися проверка уникальность поля alias
        if ($result->id != $article->id) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Данный псевдоним уже используется'];
        }

        //Проверка того, загружаем ли мы изображение на сервер.
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {

                $str = Str::random(8);

                //Создание типичного объекта встроенного в пхп
                $obj = new \stdClass();

                $obj->mini = $str. '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                //Работаем с библиотекой intervention/image
                $img = Image::make($image);


                //Есть 3 метода, fit, resize, crop. resize - изменяет качество но сохраняет пропорции,
                //fit - сохраняет качество но пропорции изменяются, crop - просто обрезает изображения с нужного угла
                $img->resize(Config::get('settings.image')['width'], Config::get('settings.image')['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->path);
                $img->resize(Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->max);
                $img->resize(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'])
                    ->save(public_path(). '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);
            }
        }
        $article->fill($data);

        if ($article->update()) {
            return ['status' => 'Материал обновлён'];
        }
    }

    public function deleteArticle($article)
    {
        if (Gate::denies('destroy', $article)) {
            abort(403);
        }

        //Удаление всех комментариев привязанных к статье
        $article->comments()->delete();

        if ($article->delete()) {
            return ['status' => 'Материал удалён'];
        }
    }
}
