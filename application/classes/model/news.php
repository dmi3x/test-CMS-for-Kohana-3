<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends Model_Base
{
    public $table = 'news';
    public $tableLocale = 'newsLocale';
    public $fk = 'newsId';

    public function getItemByAlias($alias, $parent_id = 0)
    {
        $lang = $this->getLang(Uri::lang());
	$langs = array_unique(array($this->_defaultLang, $lang));

        $query = DB::select()->from($this->table)
		       ->where('alias', '=', $alias)
		       ->where($this->tableLocale.'.lang', 'IN', $langs)
		       ->join($this->tableLocale)
		       ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk);

	$result = $query->execute();

	if($result->count()>1) {
	    $result = $result->as_array('lang');
	    return $result[$lang];
	}
	return $result->current();
    }

    public function frontendGetItem($alias)
    {
	$structureId = Page::urlObjects()->getLast(null, true)->id;
	$item = $this->getItemByAlias($alias, $structureId);
	if(empty($item)) {
	    return null;
	}
	$segments = Page::urlObjects()->getListByField(null, 'alias');
	$parents_uri = uri::object($segments)->string();
        $item['url'] = '/'.$parents_uri.'/'.$item['alias'];
	Page::urlObjects()->add($item, 'news');
	return $item;
    }

    public function add($data, $structureId=0)
    {
        $lang = $this->getLang(Uri::lang());
        
	if (!trim($data['name'])) {
	    return messages::err('Require name');
	}
	if (!trim($data['alias'])) {
	    $data['alias'] = $this->_translate($data['name']);
	}
	if (!trim($data['text'])) {
	    return messages::err('Require text');
	}

        $set = $locale = array();
	$set['alias'] = $this->_prepareAlias($data['alias']);
	if (!$set['alias']) {
	    return messages::err('Alias contains bad symbols');
	}
	if(!$this->_uniqueAlias($set['alias'])) {
	    return messages::err('Alias already exists');
	}
        $set['date'] = strtotime($data['date']);
        $set['dateAdd'] = time();
        $set['structureId'] = $structureId;

        list($insertId) = DB::insert($this->table, array_keys($set))
			      ->values(array_values($set))
			      ->execute();

        $locale[$this->fk] = $insertId;
        $locale['lang'] = $lang;
        $locale['name'] = $data['name'];
        $locale['text'] = $data['text'];

        DB::insert($this->tableLocale, array_keys($locale))
		  ->values(array_values($locale))
		  ->execute();

        return messages::ok('News create success');
    }

    public function edit($id, $data)
    {
        $lang = $this->getLang(Uri::lang());
        
	if (!trim($data['name'])) {
	    return messages::err('Require name');
	}
	if (!trim($data['alias'])) {
	    return messages::err('Require alias');
	}
	if (!trim($data['text'])) {
	    return messages::err('Require text');
	}

	$item = $this->getItemById($id);
	if(empty($item)) {
	    return messages::err('News not found');
	}

        $set = $locale = array();

	if($item['alias']!=$data['alias']) {
	    $set['alias'] = $this->_prepareAlias($data['alias']);
	    if(!$set['alias']) {
		return messages::err('Alias contains bad symbols');
	    }
	    if(!$this->_uniqueAlias($set['alias'], $id)) {
		return messages::err('Alias already exists');
	    }
	}

        $set['date'] = strtotime($data['date']);

        DB::update($this->table)
		->set($set)
		->where($this->pk, '=', (int)$id)
		->execute();

        $locale['name'] = $data['name'];
        $locale['text'] = $data['text'];

	DB::update($this->tableLocale)
		->set($locale)
		->where($this->fk, '=', (int)$id)
		->where('lang', '=', $lang)
		->execute();

        return messages::ok('News was saved');
    }

    public function delete($id)
    {
	$item = $this->getItemById($id);
	if(empty($item)) {
	    return messages::err('News not found');
	}
        DB::delete($this->table)->where($this->pk, '=', (int)$id)->execute();
        DB::delete($this->tableLocale)->where($this->fk, '=', (int)$id)->execute();
        return messages::ok('News delete success');
    }

    public function getItemById($id)
    {
        return DB::select()
		   ->from($this->table)
		   ->where($this->table.'.'.$this->pk, '=', $id)
		   ->join($this->tableLocale)
		   ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		   ->execute()
		   ->current();
    }

    public function getList($pageNum = 1, $perPage = 10, $structureId = 0)
    {
        $offset = $perPage * ($pageNum-1);
	$result = DB::select()
		   ->from($this->table)
		   ->join($this->tableLocale)
		   ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		   ->order_by('date', 'DESC')
		   ->where('structureId', '=', $structureId)
		   ->limit($perPage)
		   ->offset($offset)
		   ->execute()
		   ->as_array();
	
	$this->_saveLastQueryCount();
        
	$oStructure = new Model_Structure;
	foreach($result as $key=>$val) {
	    $result[$key]['url'] = $oStructure->getParentUrl($structureId).'/'.$val['alias'];
	}
	return $result;
    }

    protected function _uniqueAlias($alias, $id = null, $parentId = 0)
    {
        $query = DB::select(array(DB::expr('COUNT(*)'), 'total'))->from($this->table)
		    ->where('alias', '=', $alias);

        if (!is_null($id)) {
            $query->where($this->pk, '!=', $id);
        }

        return !$query->execute()->get('total');
    }
}