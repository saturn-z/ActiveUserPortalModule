<?php
/**
*
* @package Board3 Portal v2.1
* @copyright (c) 2013 Board3 Group ( www.board3.de )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace board3\portal\modules;

/**
* @package Donation
*/
class activeuser extends module_base
{
	/**
	* Allowed columns: Just sum up your options (Exp: left + right = 10)
	* top		1
	* left		2
	* center	4
	* right		8
	* bottom	16
	*/
	public $columns = 31;

	/**
	* Default modulename
	*/
	public $name = 'ACTIVEUSER';

	/**
	* Default module-image:
	* file must be in "{T_THEME_PATH}/images/portal/"
	*/
	public $image_src = 'portal_donation.png';

	/**
	* module-language file
	* file must be in "language/{$user->lang}/mods/portal/"
	*/
	public $language = 'portal_activeuser_module';

	protected $config;
	protected $config_text;
	protected $request;
	protected $pagination;
	protected $db;
	protected $auth;
	protected $template;
	protected $user;
	protected $helper;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $table_prefix;
	protected $phpbb_container;

	/**
	* Construct a stylechanger object
	*
	* @param \phpbb\config\config $config phpBB config
	* @param \phpbb\template $template phpBB template
	* @param \phpbb\user $user phpBB user object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\request\request_interface $request, \phpbb\pagination $pagination, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, $phpbb_root_path, $php_ext, $table_prefix)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->request = $request;
		$this->pagination = $pagination;
		$this->db = $db;
		$this->auth = $auth;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->table_prefix = $table_prefix;
		define(__NAMESPACE__ . '\ACTIVE_USER_TABLE', $this->table_prefix . 'active_user');
		define(__NAMESPACE__ . '\USER_TABLE', $this->table_prefix . 'users');
		define(__NAMESPACE__ . '\POSTS_TABLE', $this->table_prefix . 'posts');

		$this->ext_root_path = 'ext/saturnZ/activeuser';
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_center($module_id)
	{



	date_default_timezone_set($this->config['board_timezone']);
	$month_Array = Array(
		"",
		$this->user->lang['JAN'],
		$this->user->lang['FEB'],
		$this->user->lang['MAR'],
		$this->user->lang['APR'],
		$this->user->lang['MAY'],
		$this->user->lang['JUN'],
		$this->user->lang['JUL'],
		$this->user->lang['AUG'],
		$this->user->lang['SEP'],
		$this->user->lang['OCT'],
		$this->user->lang['NOV'],
		$this->user->lang['DEC']
	);

	$month_real_Array = Array(
		"",
		$this->user->lang['JAN2'],
		$this->user->lang['FEB2'],
		$this->user->lang['MAR2'],
		$this->user->lang['APR2'],
		$this->user->lang['MAY2'],
		$this->user->lang['JUN2'],
		$this->user->lang['JUL2'],
		$this->user->lang['AUG2'],
		$this->user->lang['SEP2'],
		$this->user->lang['OCT2'],
		$this->user->lang['NOV2'],
		$this->user->lang['DEC2']
	);

	$start_date = date("U", strtotime('first day of -1 month'));
	$start_date_array = getdate($start_date);
	$start_date_month = $start_date_array['mon'];
	$start_date_year = $start_date_array['year'];
	$start_date_timestamp = mktime(0,0,0,$start_date_month,1,$start_date_year);

$pmonth = date("n", strtotime('first day of -1 month'));
$pmonth_real = date("n");
$warning = $this->config['activeuser_warning'];
$groups = $this->config['activeuser_group'];
$perpage = $this->config['activeuser_perpage'];
$text_title = htmlspecialchars_decode($this->config_text->get('activeuser_text_title'));
$text_winner = htmlspecialchars_decode($this->config_text->get('activeuser_text_winner'));
$text_forecast = htmlspecialchars_decode($this->config_text->get('activeuser_text_forecast'));
$you_userid = $this->user->data['user_id'];
$start_activeuser = $this->config['activeuser_start'];
$excluded_forums = $this->config_text->get('activeuser_excluded');
$forecast_limit = $this->config['activeuser_forecast_limit'];
$winner_limit = $this->config['activeuser_winner_limit'];

				$this->template->assign_block_vars('title', array(
	'MONTH'			=> "".$this->user->lang['FORECAST_WINNERS']." $month_real_Array[$pmonth_real]",
	'WINNERS'		=> $this->user->lang['WINNERS'],
	'TEXT_TITLE'	=> $text_title,
				));

//Список победителей по месяцам

$arhive_date = date("d.m.Y", strtotime('first day of -1 month'));

$i = 0;
		$sql = "SELECT t.user_id, t.date, t.user_posts, t.position, s.username, s.user_avatar_type, s.user_avatar, s.user_avatar_width, s.user_avatar_height, s.user_type, s.user_colour, s.user_lastvisit, s.user_regdate, s.user_id 
		FROM " . ACTIVE_USER_TABLE . " AS t LEFT JOIN " . USER_TABLE . " AS s ON (s.user_id = t.user_id)
		WHERE date 
		LIKE '$arhive_date' 
		ORDER BY t.id DESC";
		$result = $this->db->sql_query($sql);


	while ($row = $this->db->sql_fetchrow($result)) 
	{

		$date_act = $row['date'];
		$posts = $row['user_posts'];
		$position = $row['position'];
		$date_a = date("n",strtotime($date_act));
		$date_ab = $month_Array[$date_a];
		$date_abc = $month_real_Array[$date_a];
		$year = date("Y",strtotime($date_act));
		$user_lastvisit = date("d.m.Y, H:i", $row['user_lastvisit']);  
		$user_avatar = $row['user_avatar'];
		$user_avatar_type = $row['user_avatar_type'];
		$user_regdate = date("d.m.Y", $row['user_regdate']);
		$username = get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']);
			if ($user_avatar == "")
			{
				$user_avatar = $this->ext_root_path . '/images/no_avatar.gif';
				$user_avatar_type = AVATAR_REMOTE;
			}
		$avatar = array('user_avatar' => $user_avatar,'user_avatar_type' => $user_avatar_type,'user_avatar_width' => '40','user_avatar_height' => '40');
		$useravatar = phpbb_get_user_avatar($avatar);
			if ($posts == "0")
			{

				$this->template->assign_block_vars('arhive', array(
	'NAME'			=> "",
	'POSTS'			=> "",
	'DATE'			=> "",
	'AVATAR'		=> "",
	'VISIT'			=> "",
	'COMMENT'		=> "".$this->user->lang['FORECAST_COMMENT_NO']." $date_abc.",
				));
			}
			else
			{

	if ($winner_limit > 1)
	{
		$position_text = "<br><font color=\"red\"><b>$position ".$this->user->lang['POSITION']."</b></font>";
	}
	else
	{
		$position_text = '';
	}
				$this->template->assign_block_vars('arhive', array(
	'NAME'			=> "$username",
	'POSTS'			=> "$posts",
	'DATE'			=> "$user_regdate",
	'AVATAR'		=> "$useravatar",
	'VISIT'			=> "$user_lastvisit",
	'COMMENT'		=> "<font color=\"green\"><b>".$this->user->lang['WINNER']." $date_ab $year ".$this->user->lang['YEAR'].".</b></font>
						$position_text<br>$text_winner",
			));
			}
$i++;


	}

if ($i==1){
$title_block = "".$this->user->lang['WINNER']." $date_ab";
}else{
$title_block = "".$this->user->lang['WINNERS']." $date_ab";
}
				$this->template->assign_block_vars('title_block', array(
	'TITLE_BLOCK'			=> "$title_block",
			));


//Список победителей по месяцам
		$this->template->assign_vars(array(
			'ACTIVEUSER_CENTER'			=> (!empty($this->config['board3_activeuser_' . $module_id])) ? $this->user->data['username_clean'] : false,
			'U_MY_TEST_CENTER'			 => append_sid("{$this->phpbb_root_path}activeuser"),
		));

		return 'activeuser_center.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_side($module_id)
	{


	date_default_timezone_set($this->config['board_timezone']);
	$month_Array = Array(
		"",
		$this->user->lang['JAN'],
		$this->user->lang['FEB'],
		$this->user->lang['MAR'],
		$this->user->lang['APR'],
		$this->user->lang['MAY'],
		$this->user->lang['JUN'],
		$this->user->lang['JUL'],
		$this->user->lang['AUG'],
		$this->user->lang['SEP'],
		$this->user->lang['OCT'],
		$this->user->lang['NOV'],
		$this->user->lang['DEC']
	);

	$month_real_Array = Array(
		"",
		$this->user->lang['JAN2'],
		$this->user->lang['FEB2'],
		$this->user->lang['MAR2'],
		$this->user->lang['APR2'],
		$this->user->lang['MAY2'],
		$this->user->lang['JUN2'],
		$this->user->lang['JUL2'],
		$this->user->lang['AUG2'],
		$this->user->lang['SEP2'],
		$this->user->lang['OCT2'],
		$this->user->lang['NOV2'],
		$this->user->lang['DEC2']
	);

	$start_date = date("U", strtotime('first day of -1 month'));
	$start_date_array = getdate($start_date);
	$start_date_month = $start_date_array['mon'];
	$start_date_year = $start_date_array['year'];
	$start_date_timestamp = mktime(0,0,0,$start_date_month,1,$start_date_year);

$pmonth = date("n", strtotime('first day of -1 month'));
$pmonth_real = date("n");
$warning = $this->config['activeuser_warning'];
$groups = $this->config['activeuser_group'];
$perpage = $this->config['activeuser_perpage'];
$text_title = htmlspecialchars_decode($this->config_text->get('activeuser_text_title'));
$text_winner = htmlspecialchars_decode($this->config_text->get('activeuser_text_winner'));
$text_forecast = htmlspecialchars_decode($this->config_text->get('activeuser_text_forecast'));
$you_userid = $this->user->data['user_id'];
$start_activeuser = $this->config['activeuser_start'];
$excluded_forums = $this->config_text->get('activeuser_excluded');
$forecast_limit = $this->config['activeuser_forecast_limit'];
$winner_limit = $this->config['activeuser_winner_limit'];

				$this->template->assign_block_vars('title2', array(
	'MONTH'			=> "".$this->user->lang['FORECAST_WINNERS']." $month_real_Array[$pmonth_real]",
	'WINNERS'		=> $this->user->lang['WINNERS'],
	'TEXT_TITLE'	=> $text_title,
				));

//Список победителей по месяцам

$arhive_date = date("d.m.Y", strtotime('first day of -1 month'));

$i = 0;
		$sql = "SELECT t.user_id, t.date, t.user_posts, t.position, s.username, s.user_avatar_type, s.user_avatar, s.user_avatar_width, s.user_avatar_height, s.user_type, s.user_colour, s.user_lastvisit, s.user_regdate, s.user_id 
		FROM " . ACTIVE_USER_TABLE . " AS t LEFT JOIN " . USER_TABLE . " AS s ON (s.user_id = t.user_id)
		WHERE date 
		LIKE '$arhive_date' 
		ORDER BY t.id DESC";
		$result = $this->db->sql_query($sql);

	while ($row = $this->db->sql_fetchrow($result)) 
	{
		$date_act = $row['date'];
		$posts = $row['user_posts'];
		$position = $row['position'];
		$date_a = date("n",strtotime($date_act));
		$date_ab = $month_Array[$date_a];
		$date_abc = $month_real_Array[$date_a];
		$year = date("Y",strtotime($date_act));
		$user_lastvisit = date("d.m.Y, H:i", $row['user_lastvisit']);  
		$user_avatar = $row['user_avatar'];
		$user_avatar_type = $row['user_avatar_type'];
		$user_regdate = date("d.m.Y", $row['user_regdate']);
		$username = get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']);
			if ($user_avatar == "")
			{
				$user_avatar = $this->ext_root_path . '/images/no_avatar.gif';
				$user_avatar_type = AVATAR_REMOTE;
			}
		$avatar = array('user_avatar' => $user_avatar,'user_avatar_type' => $user_avatar_type,'user_avatar_width' => '40','user_avatar_height' => '40');
		$useravatar = phpbb_get_user_avatar($avatar);
			if ($posts == "0")
			{
				$this->template->assign_block_vars('arhive2', array(
	'NAME'			=> "",
	'POSTS'			=> "",
	'DATE'			=> "",
	'AVATAR'		=> "",
	'VISIT'			=> "",
	'COMMENT'		=> "".$this->user->lang['FORECAST_COMMENT_NO']." $date_abc.",
				));
			}
			else
			{
	if ($winner_limit > 1)
	{
		$position_text = "<font color=\"red\"><b>$position ".$this->user->lang['POSITION']."</b></font>";
	}
	else
	{
		$position_text = '';
	}
				$this->template->assign_block_vars('arhive2', array(
	'NAME'			=> "$username",
	'POSTS'			=> "$posts",
	'DATE'			=> "$user_regdate",
	'AVATAR'		=> "$useravatar",
	'VISIT'			=> "$user_lastvisit",
	'COMMENT'		=> "$position_text",
			));
			}

$i++;
	}

if ($i==1){
$title_block2 = "".$this->user->lang['WINNER']." $date_ab";
}else{
$title_block2 = "".$this->user->lang['WINNERS']." $date_ab";
}
				$this->template->assign_block_vars('title_block2', array(
	'TITLE_BLOCK2'			=> "$title_block2",
			));

//Список победителей по месяцам


		$this->template->assign_vars(array(
			'ACTIVEUSER_SIDE'		=> (!empty($this->config['board3_activeuser_' . $module_id])) ? $this->user->data['username_clean'] : false,
			'U_MY_TEST_SIDE'		 => append_sid("{$this->phpbb_root_path}activeuser"),
		));

		return 'activeuser_side.html';

	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_acp($module_id)
	{
		return array(
			'title'	=> 'ACP_PORTAL_PAYPAL_SETTINGS',
			'vars'	=> array(),
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function install($module_id)
	{
		$this->config->set('board3_activeuser_' . $module_id, true);
		return true;
	}

	/**
	* {@inheritdoc}
	*/
	public function uninstall($module_id, $db)
	{
		$del_config = array(
			'board3_activeuser_' . $module_id,
		);
		$sql = 'DELETE FROM ' . CONFIG_TABLE . '
			WHERE ' . $db->sql_in_set('config_name', $del_config);
		return $db->sql_query($sql);
	}


}
