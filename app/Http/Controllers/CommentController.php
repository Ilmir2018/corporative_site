<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Исключаем определённые инпуты. которые не нужны в БД.
        $data = $request->except(['_token', 'comment_post_ID', 'comment_parent']);

        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        //Валидация входящих данных
        $validator = Validator::make($data, [
            'article_id' => 'integer|required',
            'parent_id' => 'integer|required',
            'text' => 'string|required'
        ]);

        //Валидация данных полей осуществляется только если пользователь не аутентиыицирован
        $validator->sometimes(['name', 'email'], 'required|max:255', function ($input) {

            return !Auth::check();

        });

        //Выводим специальный массив ошибок валидации
        if ($validator->fails()) {
            return Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        //Передаём в объект комментария содержимое ячеек инпутов.
        $comment = new Comment($data);

        //Если пользователь авторизован мы добавляем в модель комментария его id
        //Если нет по умаолчанию в шаблоне стоит 0
        if ($user) {
            $comment->user_id = $user->id;
        }

        //Находим статью в которой мы сейчас находимся
        $post = Article::find($data['article_id']);

        //Сохраняем комментарий в базу данных. comments - метод описанный в модели Comment
        $post->comments()->save($comment);

        $comment->load('user');
        $data['id'] = $comment->id;

        $data['email'] = (!empty($data['email']) ? $data['email'] : $comment->user->email);
        $data['name'] = (!empty($data['name']) ? $data['name'] : $comment->user->name);

        $data['hash'] = md5($data['email']);

        //Формирование шаблона с одним комментарием
        $view_comment = view(env('THEME'). '.blog.content_one_comment')->with('data', $data)->render();

        //Возвращаем в ответ для success - true, это для отрпаботки кода в js.
        //Так же возвращается шаблон с необходимыми данными.
        return Response::json(['success' => true, 'comment' => $view_comment, 'data' => $data]);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
