<?php


namespace App\Repositories;


abstract class Repository
{

    protected $model = false;

    /**
     * @param string $select Параметр для указания массива необходимых полей из таблицы.
     * @param false $take Параметр нужен для того чтобы достать из таблицы определённое колечство записей
     * @param false $pagination Параметр для того чтобы указать нужна ли пагинация выводимых данных.
     * @param false $where Параметр для возможности выборки определённой категории и просмотр на отдельной странице
     * @return false Возвращается обработанный запрос к базе данных.
     */
    public function get($select = '*', $take = false, $pagination = false, $where = false)
    {
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination){
            return $this->check($builder->paginate(\Illuminate\Support\Facades\Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    /*
     * Метод для проверки есть ли в таблице поле img
     *  и если оно есть то декодирование содержащегося в таблице объекта для
     * удобного ображения к нему.
     */

    protected function check($result)
    {
        if ($result->isEmpty())
        {
            return false;
        }

        //Метод позволяет преобразовать данные sql запроса,
        // например в данном случае ищется поле таблицы $item->img
        $result->transform(function ($item, $key) {

            if (is_string($item->img) && is_object(json_decode($item->img)) && json_last_error() == JSON_ERROR_NONE) {
                $item->img = json_decode($item->img);
            }

            return $item;

        });

        return $result;
    }

    public function one($alias = false, $attr = [])
    {
        $result = $this->model->where('alias', $alias)->first();
        return $result;
    }

    public function transliterate($string)
    {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = [
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г',
            'd' => 'д',
            'e' => 'е, э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и',
            'ji' => '',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        ];

        foreach ($leter_array as $letter => $kyr) {

            $kyr = explode(',', $kyr);

            $str = str_replace($kyr, $letter, $str);
        }

        $str = preg_replace('/(\s|[^A-Za-z0-9]\-)+/', '-', $str);
        $str = trim($str, '-');
        return $str;
    }

}
