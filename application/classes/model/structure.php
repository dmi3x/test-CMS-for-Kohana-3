<?php defined('SYSPATH') or die('No direct script access.');

class Model_Structure_Exception extends Kohana_Exception {}

class Model_Structure extends Model_Base
{
    public $table = 'structure';
    public $tableLocale = 'structureLocale';
    public $fk = 'structureId';

    public function processUrlSegments(array $segments)
    {
	$defaultModule = Modules::instance()->get_default();

        $parents = array();
        $parentId = 0;

        $lang = $this->getLang(Uri::lang());

        foreach ($segments as $alias){
            $row = $this->getItemByAlias($alias, $parentId, $lang);

            if (empty($row)) {
                return false;
            }
            $parentId = $row[$this->pk];

            $parents[] = $row;
	    
            if ($row['module'] != $defaultModule) {
                break;
            }
        }
	// for home page
	if(empty($segments)) {
	    $parents = $this->getItemByAlias('', 0, $lang);
	}

	Page::urlObjects()->add($parents, 'structure');
	
	return true;
    }

    /**
     * Add page
     *
     * @param array $data
     * @return bool
     */
    public function add($data)
    {
	if (!trim($data['name'])) {
	    return messages::err('Require name');
	}

	if (!trim($data['alias'])) {
	    $data['alias'] = $this->_translate($data['name']);
	}

	if(empty($data['parentId']) && empty($data['folderId'])) {
	    $data['folderId'] = 1;
	}

        $set = $locale = array();
	$set['alias'] = $this->_prepareAlias($data['alias']);
	if (!$set['alias']) {
	    return messages::err('Alias contains bad symbols');
	}
	if($this->_uniqueAlias($set['alias'], $data['parentId'])) {
	    return messages::err('Alias already exists');
	}

	$url = $this->getParentUrl($data['parentId']);
	if(Modules::instance()->isReservedUrl($url.'/'.$set['alias'])) {
	    return messages::err('This url is reserved');
	}

        $set['parentId'] = $data['parentId'];
        $set['folder'] = $data['folderId'];


	if(!empty($data['module'])) {
	    $set['module'] = $data['module'];
	}
	else {
	    $set['module'] = Modules::instance()->get_default();
	}


        $set['dateAdd'] = time();

        list($insert_id) = DB::insert($this->table, array_keys($set))
			      ->values(array_values($set))
			      ->execute();
        $locale[$this->fk] = $insert_id;
        $locale['lang'] = $this->_defaultLang;
        $locale['name'] = $data['name'];

        DB::insert($this->tableLocale, array_keys($locale))
		  ->values(array_values($locale))
		  ->execute();

	$this->updateChildrens();

        return messages::ok('Page create success');
    }

    /**
     * Add page
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit($id, $data, $lang = null)
    {
	if (!trim($data['name'])) {
	    return messages::err('Require name');
	}
	$set = $locale = array();

	$item = $this->getItemById($id, $lang);
	if(empty($item)) {
	    return messages::err('Page not found');
	}

	$module = Modules::instance()->get($item['module']);

	if ($lang != Kohana::config('langs.default')){
	    $data['alias'] = $item['alias'];
	}

	if($item['module'] && !$module['required'] && $item['alias']!=$data['alias']) {
	    if (!trim($data['alias'])) {
		return messages::err('Require alias');
	    }
	    $set['alias'] = $this->_prepareAlias($data['alias']);
	    if(!$set['alias']) {
		return messages::err('Alias contains bad symbols');
	    }
	    if($this->_uniqueAlias($set['alias'], $item['parentId'], $id)) {
		return messages::err('Alias already exists');
	    }
	    
	    $url = $this->getParentUrl($item['parentId']);
	    if(Modules::instance()->isReservedUrl($url.'/'.$set['alias'])) {
		return messages::err('This url is reserved');
	    }
	}

	if(!empty($data['module'])) {
	    $set['module'] = $data['module'];
	}

	if(!empty($set)) {
	    DB::update($this->table)->set($set)->where('id', '=', $id)->execute();
	}

	//Adding lang row
	if ($lang != Kohana::config('langs.default')){
	    $res = DB::select()->from($this->tableLocale)->where($this->fk, '=', (int)$id)->where('lang', '=', $lang)->execute();
	    if (!$res->count()){
		 $new_locale['lang'] = $lang;
		 $new_locale[$this->fk] = $id;
		 DB::insert($this->tableLocale, array_keys($new_locale))->values(array_values($new_locale))->execute();
	    }
	}

        $locale = Arr::extract($data, array('name', 'title', 'keywords', 'description', 'text'));

	DB::update($this->tableLocale)
		->set($locale)
		->where($this->fk, '=', $id)
		->where('lang', '=', $lang)
		->execute();

        return messages::ok('Page was saved');
    }

    /**
     * Delete page 
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function delete($id)
    {
	$item = $this->getItemById($id);
	if(empty($item)) {
            return messages::err('Page not found');
	}

	$total = DB::select(array(DB::expr('COUNT(id)'), 'total'))->from($this->table)
		->where('parentId', '=', (int)$id)
		->execute()
		->get('total');

        if ($total) {
            return messages::err('Delete submenu items first');
        }

        DB::delete($this->table)->where($this->pk, '=', (int)$id)->execute();
        DB::delete($this->tableLocale)->where($this->fk, '=', (int)$id)->execute();

        return messages::ok('Page delete success');
    }

    /**
     * @param int $id
     * @return array
     */
    public function getItemById($id, $lang = null)
    {
        if (!$lang) {
	    $lang = $this->_defaultLang;
	}
	$langs = array_unique(array($this->_defaultLang, $lang));

	if($lang == $this->_defaultLang &&  isset(self::$_allStructure[$id])) {
	    return self::$_allStructure[$id];
	}
        $result = DB::select()->from($this->table)
		       ->where($this->table.'.'.$this->pk, '=', $id)
		       ->where($this->tableLocale.'.lang', 'IN', $langs)
		       ->join($this->tableLocale)
		       ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		       ->execute()
		       ->as_array('lang');

	// Либо текущий язык = дефаултному, либо в базе только дефаултный язык,
	if(count($result) < 2) {
	    return current($result);
	}
	// Если сейчас не дефаултный язык, и страница с таким языком существует
	// заменяем в дефаултной версии поля на другой язык
	return array_merge($result[$this->_defaultLang], $result[$lang]);
    }

    /**
     * @param string $alias
     * @param int $parentId
     * @return array
     */
    public function getItemByAlias($alias, $parentId = 0, $lang = null)
    {
      if (!$lang) $lang = $this->_defaultLang;
	$langs = array_unique(array($this->_defaultLang, $lang));

        $result = DB::select()->from($this->table)
		       ->where('alias', '=', $alias)
		       ->where('parentId', '=', $parentId)
		       ->where($this->tableLocale.'.lang', 'IN', $langs)
		       ->join($this->tableLocale)
		       ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		       ->execute()
		       ->as_array('lang');
	if(count($result) < 2) {
	    return current($result);
	}
	return array_merge($result[$this->_defaultLang], $result[$lang]);
    }

    /**
     * @param string $name
     * @return array
     */
    public function getModule($name)
    {
	if(!empty(self::$_index['module'][$name])) {
	    return self::$_index['module'][$name];
	}

	$structure =& $this->getStructure();

	self::$_index['module'] = ArrIndex::get($structure, 'module');

	return Arr::get(self::$_index['module'], $name);
    }

    /**
     * Return module url
     * @param string $name
     * @return string
     */
    public function getModuleUrl($name)
    {
	$item = $this->getModule($name);
	return $this->getParentUrl($item['id']);
    }

    /**
     * Выбирает данные только с дефаултного языка
     */
    public function adminGetList()
    {
	$structure = $this->getStructure();
	//TODO: Pagination for admin list
//	$structure = DB::select()
//		  ->from($this->_table)
//		  ->join($this->_tableLocale)
//		  ->on($this->_table.'.'.$this->pk, '=', $this->_tableLocale.'.'.$this->_fk)
//		  ->order_by($this->pk, 'DESC')
//		  ->where($this->_tableLocale.'.lang', '=', $this->_defaultLang)
//		  ->execute()
//		  ->as_array();
	if(!empty($structure)) {
	    foreach($structure as $key=>$val) {
		$val['url'] = $this->getParentUrl($val['id']);
		$structure[$key] = $val;
	    }
	}
	return $structure;
    }

// --- Tree ----
    private static $_tree;

    public function getTree($parentId = 0, $folderId = null, $idInKey = false)
    {
	if(empty(self::$_tree[$parentId][$folderId])) {
	    $this->getIndex();
	    self::$_tree[$parentId][$folderId] = $this->_generateTree($parentId, $folderId, $idInKey);
	}
	return self::$_tree[$parentId][$folderId];
    }

    private function _generateTree($parentId = 0, $folderId = null, $idInKey = false)
    {
	$tree = array();
	if(isset(self::$_index['parentId'][$parentId])) {
	    foreach(self::$_index['parentId'][$parentId] as $val) {
		$val['url'] = $this->getParentUrl($val['id']);
		$val['childs'] = $this->_generateTree($val['id'], null, $idInKey);
		if($parentId==0) {
		    if(!is_null($folderId) && $val['folder']!=$folderId) {
			continue;
		    }
		    if($idInKey) {
			$tree[$val['folder']][$val['id']] = $val;
		    }
		    else {
			$tree[$val['folder']][] = $val;
		    }
		}
		else {
		    if($idInKey) {
			$tree[$val['id']] = $val;
		    }
		    else {
			$tree[] = $val;
		    }
		}
	    }
	}
	return $tree;
    }

    /**
     * Выберает главное меню сайта
     */
    public function getMenu()
    {
	$folders = Kohana::config('main.structure_folders');
	if(empty($folders)) {
	    return null;
	}
	$folderKey = key($folders);
	$menu = $this->getTree(0, $folderKey);


	if(empty($menu)) {
	    return null;
	}
	return current($menu);
    }

// --- Get Parents
    public function getParentUrl($parentId)
    {
	$parents = $this->getAllParents($parentId);
	$aliases = array();
	foreach($parents as $val) {
	    $aliases[] = $val['alias'];
	}
	return implode('/', $aliases);
    }

    public function getAllParents($parentId)
    {
	$arr = $this->_getParents($parentId);
	if(!is_array($arr)) {
	    $arr = array();
	}
	return array_reverse($arr);
    }

    private function _getParents($parentId, $parents = null)
    {
	if(is_null($parents)) {
	    $parents = array();
	}
	$lang = $this->getLang(Uri::lang());
	$page = $this->getItemById($parentId, $lang);
	$parents[] = $page;
	if($page['parentId']==0) {
	    return $parents;
	}
	return $this->_getParents($page['parentId'], &$parents);
    }

// --- Get All Structure
    static private $_index;
    static private $_allStructure;

    public function & getStructure()
    {
        $lang = $this->getLang(Uri::lang());

	if(!self::$_allStructure) {
	     self::$_allStructure
		    = DB::select()
		      ->from($this->table)
		      ->join($this->tableLocale)
		      ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		      ->order_by('pos', 'ASC')
		      ->order_by($this->pk, 'DESC')
		      ->where($this->tableLocale.'.lang', '=', $this->_defaultLang)
		      ->execute()->as_array('id');

                  if ($lang != $this->_defaultLang){
                      $multi_lang = DB::select()
		          ->from($this->table)
		          ->join($this->tableLocale)
		          ->on($this->table.'.'.$this->pk, '=', $this->tableLocale.'.'.$this->fk)
		          ->order_by('pos', 'ASC')
		          ->order_by($this->pk, 'DESC')
		          ->where($this->tableLocale.'.lang', '=', $lang)
		          ->execute()->as_array('id');
			  self::$_allStructure = self::$_allStructure + $multi_lang;
		  }
	}
	return self::$_allStructure;
    }

    //Формируем индексы по парентам
    public function getIndex()
    {
	if(!empty(self::$_index['parentId'])) {
	    return self::$_index['parentId'];
	}

	$structure =& $this->getStructure();

	self::$_index['parentId'] = ArrIndex::get($structure, 'parentId', 'id');

	return self::$_index['parentId'];
    }

// --- Update Children ---
    public function updateChildrens()
    {
	$list = $this->adminGetList();
	if(empty($list)) {
	    return;
	}
	$ids_parents = $ids_other = array();
	foreach($list as $row) {
	    if($row['parentId']>0) {
		$ids_parents[] = $row['parentId'];
	    }
	    else {
		$ids_roots[] = $row[$this->pk];
	    }
	}
	if(!empty($ids_roots)) {
	    DB::update($this->table)
		->set(array('hasChildren'=>0))
		->where($this->pk, 'IN', $ids_roots)
		->execute();
	}
	if(!empty($ids_parents)) {
	    DB::update($this->table)
		->set(array('hasChildren'=>1))
		->where($this->pk, 'IN', array_unique($ids_parents))
		->execute();
	}
	return true;
    }

    public function saveTreeStructure($structure, $aliasUniqueInParent = true)
    {
        if (!$structure) {
            return messages::err('No '.$this->_name);
	}

	list($ids, $new_pos) = $this->parserTreeIds($structure);
	
	if(empty($ids)) {
	    return true;
	}

	$list = DB::select('id', 'parentId', 'alias')->from($this->table)->where('id', 'IN', $ids)->execute()->as_array('id');
        foreach ($new_pos as $val) {
	    $item = isset($list[$val['id']]) ? $list[$val['id']] : null;
	    $parent = true;
	    if($val['parentId']) {
		$parent = isset($list[$val['parentId']]) ? $list[$val['parentId']] : null;
	    }
            if(empty($item) || empty($parent)) {
                return Messages::err('One of '.$this->_name.' not found ');
	    }

	    if($aliasUniqueInParent) {
		$r = DB::select()->from($this->table)
				 ->where('alias', '=', $item['alias'])
				 ->where('parentId', '=', $val['parentId'])
				 ->where('id', '!=', $item['id'])
				 ->execute();
		if($r->count()>0) {
		    return Messages::err($this->_name.' with alias "'.$item['alias'].'" alredy exists in this parent ');
		}
	    }

	    $set = array('parentId' => $val['parentId'],
			 'pos'	     => $val['pos'],
			 );
	    if(isset($val['folder'])) {
		$set['folder'] = $val['folder'];
	    }

            DB::update($this->table)->set($set)
			      ->where($this->pk, '=', $val['id'])
			      ->execute();
        }
        return $ids;
    }

    public function parserTreeIds($structure)
    {
        $structure = explode("|", trim($structure,'|'));

	$ids = array();
	$new_pos = array();
        foreach ($structure as $val) {
	    $val = explode(",", $val);
	    $item = array();
	    $item['id'] = $val[1];
	    $item['parentId'] = $val[0];
	    $item['pos'] = $val[2];
	    if(isset($val[3])) {
		$item['folder'] = $val[3];
	    }
	    $new_pos[] = $item;
	    $ids[$item['id']] = $item['id'];
	    $ids[$item['parentId']] = $item['parentId'];
	}
	return array($ids, $new_pos);
    }
}
