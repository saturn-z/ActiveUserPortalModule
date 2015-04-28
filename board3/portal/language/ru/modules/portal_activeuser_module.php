<?php
/**
*
* @package Board3 Portal v2 - Donation
* @copyright (c) Board3 Group (www.board3.de)
* @translator (c) Mac (www.belgut.by)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
$lang = array_merge($lang, array(
	'ACTIVEUSER' 			=> 'Конкурс',
	'JAN'					=> 'Января',
	'FEB'					=> 'Февраля',
	'MAR'					=> 'Марта',
	'APR'					=> 'Апреля',
	'MAY'					=> 'Мая',
	'JUN'					=> 'Июня',
	'JUL'					=> 'Июля',
	'AUG'					=> 'Августа',
	'SEP'					=> 'Сентября',
	'OCT'					=> 'Октября',
	'NOV'					=> 'Ноября',
	'DEC'					=> 'Декабря',
	'JAN2'					=> 'Январь',
	'FEB2'					=> 'Февраль',
	'MAR2'					=> 'Март',
	'APR2'					=> 'Апрель',
	'MAY2'					=> 'Май',
	'JUN2'					=> 'Июнь',
	'JUL2'					=> 'Июль',
	'AUG2'					=> 'Август',
	'SEP2'					=> 'Сентябрь',
	'OCT2'					=> 'Октябрь',
	'NOV2'					=> 'Ноябрь',
	'DEC2'					=> 'Декабрь',
	'YEAR'					=> 'года',
	'FORECAST_COMMENT_NO'	=> 'Нет информации о победителях!<br>Пользователи не оставили ни одного сообщения на форуме за',
	'FORECAST_WINNERS'		=> 'Прогноз победителей на',
	'WINNERS'				=> 'Победители',
	'WINNER'				=> 'Победитель',
	'TEST_PAGE_TITLE'		=> 'Конкурс на самого активного пользователя',
	'ICON_PAGE_TITLE'		=> 'Конкурс',
	'INFO_TITLE'			=> 'Информация о конкурсе',
	'AVATAR'				=> 'Аватар',
	'NAME'					=> 'Имя',
	'DATE'					=> 'Зарегистрирован',
	'POSTS'					=> 'Сообщ.',
	'POSITION'				=> 'место',
	'WAR_POSTS'				=> 'Либо Вы исключены из конкурса.',
	'VISIT'					=> 'Последнее посещение',
	'COMMENT'				=> 'Коммент.',
	'TOTAL_ITEMS'			=> 'Всего: <strong>%d</strong>',
	'TEXT_YOU_POSTS_TRUE'	=> 'количество оставленных Вами сообщений за',
	'TEXT_YOU_POSTS_FALSE'	=> 'Вы не оставили ни одного сообщения за',
	'TEXT_START_ACTIVEUSER'	=> 'Конкурс начался в этом месяце, победители будут отображены первого числа следующего месяца.',
	'TEXT_YOU_WINNER'		=> 'В следующем месяце можете выиграть Вы.',
	'ABOUT_ACTIVEUSER'		=> 'Подробнее о конкурсе',

));
