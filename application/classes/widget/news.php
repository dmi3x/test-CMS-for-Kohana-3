<?php defined('SYSPATH') or die('No direct script access.');

class Widget_News extends Widget
{
    public $type;
    private $_uri;

    // Тут мы можем обрабатывать запросы Request, $_POST, $_GET...
    public function  __construct($type = null) {
        parent::__construct();
        // Так как виджет создаётся в контроллере,
        // то можно отсюда делать редиректы, не боясь лишних запросов и выводов.
        // Например:
        // Может пригодиться, для виджета подписки на новости.
        if(isset($_GET['redirect'])) {
            Request::instance()->redirect('/');
        }
        
        // Вот ещё пример:       
        $this->type = $type;

        // Или вот такой.
        if(isset($_GET['last'])) {
            $this->type = 'last';
        }

        $this->_uri = Request::instance()->uri();
    }

    // А этот метод вызывается уже в шаблоне.
    // Рекомендую выводить через echo $widget, вместо echo $widget->render(),
    // Чтобы абстрагироваться от содержимого переменной шаблона.
    // Либо echo $sidebar
    public function render()
    {
        if($this->type=='last') {
            return $this->last();
        }

        return '<p>Это виджет новостей. <a href="'.$this->_uri.'?last">Фокус</a></p>';
    }

    // И конечно же, тут можно использовать любые другие методы.
    public function last()
    {
        $back = isset($_GET['last']) ? '<a href="'.$this->_uri.'">Назад</a>' : '';
        return '<p>Последние новости '.$back.'</p>';
    }
}