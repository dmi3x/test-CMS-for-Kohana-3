<?php defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text
{
    static function html2text($html, $limit=null, $end_char='...', $preserve_words=true)
    {
	$html = preg_replace("|\s+|is", ' ', $html);
	$html = strip_tags($html);
	$html = Html::entities($html);
	$html = trim($html);
	if(!is_null($limit)) {
	    $html = Text::limit_chars($html, $limit, $end_char, $preserve_words);
	}
	return $html;
    }

    static function replace($text, array $pairs, $deviders = array('[#', '#]'))
    {
	$pairsWithDeviders = array();

	if(!is_array($deviders)) {
	    $deviders = array('','');
	}

	foreach($pairs as $key=>$val) {
		$pairsWithDeviders[$deviders[0].$key.$deviders[1]] = $val;
        }

	return str_replace(array_keys($pairsWithDeviders), $pairsWithDeviders, $text);
    }
}