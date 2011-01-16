<?php defined('SYSPATH') or die('No direct script access.');

abstract class Model_Base extends Model
{
    public $pk = 'id';
    
    protected $_aliasMask = '[a-z0-9_-]';
    protected $_defaultLang = '';

    public function  __construct($db = NULL)
    {
	parent::__construct($db);
        $this->_defaultLang = Kohana::config('langs.default');
    }

    protected function _prepareAlias($alias)
    {
	// Регистронезависимая проверка
	if(!preg_match('|^'.$this->_aliasMask.'+$|Ui', $alias)) {
	    return false;
	}
	return $this->_translate($alias);
    }

    protected function _translate($alias)
    {
	$alias = UTF8::strtolower($alias);
	$translit = array("а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j", "з" => "z", "и" => "i", "й" => "i", "ы" => "i",  "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "y", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sh", "ь" => "", "ъ" => "", "э" => "e", "ю" => "u", "я" => "ya");
        $alias = strtr($alias, $translit);
	$alias = preg_replace('|[^a-z0-9-_]|U', '-', $alias);
	$alias = preg_replace('|-+|u', '-', $alias);
	return trim(trim($alias),'-_');
    }

    protected function _uniqueAlias($alias, $id = null, $parentId = 0)
    {
	$query = DB::select(array(DB::expr('COUNT(*)'), 'total'))->from($this->table)
		    ->where('parentId', '=', $parentId)
		    ->where('alias', '=', $alias);

        if (!is_null($id)) {
            $query->where($this->pk, '!=', $id);
        }
        return $query->execute()->get('total');
    }

    private $_lastQueryCount;
    
    protected function _saveLastQueryCount()
    {
	return $this->_lastQueryCount = $this->_db->count_last_query();
    }

    public function countLastList()
    {
	return $this->_lastQueryCount;
    }

    public function generateRandHash($length=32, $type='hexdec')
    {
	if(is_null($length)) {
	    $length = 32;
	}
	return Text::random($type, $length);
    }

    public function generateUniqHash($fieldName, $length=null, $type=null)
    {
	$hash = $this->generateRandHash($length, $type);

	$result = DB::select(array('COUNT("*")', 'total'))
		    ->from($this->table)
		    ->where($fieldName, '=', $hash)
		    ->execute()
		    ->get('total');
	if($result) {
	    return $this->generateUniqHash($fieldName, $length, $type);
	}
	return $hash;
    }

    public function count()
    {
	return $count = $this->_db->count_records($this->table);
    }

    public function getLang($lang)
    {
        if (!$lang){
            return kohana::config('langs.default');
        }

        if (!kohana::config('langs.list.'.$lang)){
            return kohana::config('langs.default');
        }
        return $lang;
    }
}