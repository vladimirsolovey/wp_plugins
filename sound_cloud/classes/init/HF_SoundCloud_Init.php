<?php
/**
 * Date: 22.08.17
 * Time: 16:51
 */

namespace SoundCloud\classes\init;

use SoundCloud\api\SoundCloud;
use SoundCloud\classes\cron\HF_SoundCloud_Cron;
use SoundCloud\classes\engine\HF_SoundCloud_Engine;
use SoundCloud\classes\HF_SoundCloud_Service;
use SoundCloud\classes\metabox\HF_SoundCloud_MetaBox;
use SoundCloud\classes\settings\HF_SoundCloud_Settings;


class HF_SoundCloud_Init extends HF_SoundCloud_Service {

	private $admin_main_page_url;
	private $admin_main_page_slug;
	/**
	 * @var HF_SoundCloud_Cron
     */
	private $cron;
	function __construct()
	{
		$this->admin_main_page_url = 'edit.php?post_type='.$this->import_post_type;
		$this->admin_main_page_slug = 'sound-cloud-importer';
		$this->api = SoundCloud::getInstance();
		$this->api->setClientId(get_option("hf_sound_cloud_settings",true)['client-id']);
	}
	static function getInstance() {

			if(!(self::$_instance instanceof self))
			{
				self::$_instance = new self();
			}
			return self::$_instance;

	}

	function init() {

		$this->cron = HF_SoundCloud_Cron::getInstance();
		add_action('init',array($this,'registerPostTypes'));

		if(is_admin())
		{
			add_action("admin_init",array($this,"initAdmin"));
			add_action("admin_menu",array($this,"initAdminMenu"));
			add_filter("manage_".$this->import_post_type."_posts_columns",array($this,'editFieldsHeader'));
			add_action("manage_".$this->import_post_type."_posts_custom_column",array($this,'editFieldsContent'),10,2);
			add_filter("post_row_actions",array($this,'editRowActions'),10,2);
        	add_action("current_screen",array($this,'initRequestHandler'));
                add_action("save_post",array($this,'saveScheduler'),10,2);
                add_action("delete_post",array($this,'deleteScheduler'));
                add_action("admin_notices", array($this,'isClientIDExists'));
                add_action('post_submitbox_misc_actions',	array($this, 'postSubmitAction'), 10);
                add_action("admin_footer-edit.php",array($this,'editBulkActions'));
                add_filter("bulk_actions-edit-".$this->import_post_type,array($this,'removeBulkActions'));
                add_filter('months_dropdown_results', array($this,'removeFilter'),10,2);





		}
		$this->removeAutoDraft();
	}

	function initAdmin()
	{
		HF_SoundCloud_MetaBox::getInstance()->init();
	}
	function initRequestHandler()
	{
		global $current_screen;

		if ( 'GET' === $_SERVER['REQUEST_METHOD'] && $current_screen->id=='edit-'.$this->import_post_type && isset($_GET['a']) && $_GET['a']=='run-import' && isset($_GET['ids']) && !empty($_GET['ids'])) {

			$engine = HF_SoundCloud_Engine::getInstance();
			$engine->runImport(get_post($_GET['ids']));
			$url = admin_url('edit.php');
			$redirect_url = add_query_arg(array('post_type'=>$this->import_post_type),$url);
			wp_redirect($redirect_url);
			die();
		}

	}

	function editRowActions($actions, $post)
	{

		if($post->post_type == $this->import_post_type) {
			unset($actions['inline hide-if-no-js']);
			unset($actions['trash']);
			if(isset($actions['duplicate']))
				unset($actions['duplicate']);

			$action = 'run-import';
			$run_import_link = add_query_arg( 'a', $action, admin_url( sprintf( 'edit.php?ids=%1$d&post_type=%2$s', $post->ID,$this->import_post_type ) ) );
			$delete_link = get_delete_post_link( $post->ID, '', true );

			if(preg_match('/_wpnonce=(.*?)$/',$delete_link,$matches)==1)
			{
				$run_import_link .= '&_wpnonce='.$matches[1];
			}

			$actions['run-import'] = '<a href="'.$run_import_link.'">Run Import</a>';
			$actions['delete']="<a href='".get_delete_post_link( $post->ID, '', true )."'>Delete</a>";
		}
		return $actions;
	}

	function deleteScheduler($post_id)
	{
		wp_clear_scheduled_hook(HF_SoundCloud_Cron::getAction());
	}
	function saveScheduler($post_id,$post)
	{

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return $post_id;
		}
		if($post->post_type != $this->import_post_type)
		{
			return $post_id;
		}

		if(wp_is_post_revision($post_id)){
			return $post_id;
		}
		if(!isset($_POST['_scheduler_nonce']) || !wp_verify_nonce($_POST['_scheduler_nonce'],'hf-sc-scheduler'))
		{

			return $post_id;
		}

		$_POST['_scheduler_nonce'] = false;

		if($this->api->getClientId()==null)
		{
			add_settings_error("hf-sc-user-id-api","130","Please add ClientID to use SoundCloud API");
			set_transient('settings_errors',get_settings_errors("hf-sc-user-id-api"),30);

		}else {


			foreach ($_POST['hf-sc'] as $key => $val) {
				foreach ($val as $key_item => $val_item) {
					update_post_meta($post_id, 'hf-sc-' . $key . '-' . $key_item, $val_item);
					unset(array_flip($this->input_fields)[$key_item]);
				}
				foreach ($this->input_fields as $val_f) {
					if (!array_key_exists($val_f, $_POST['hf-sc']['scheduler'])) {
						delete_post_meta($post_id, $this->settings['scheduler_meta_key'] . $val_f);
					}
				}
			}
			add_action("admin_notices", "errorHandler");
			try {
				if (($userID = $this->api->getUserId(get_post_meta($post_id, $this->settings['scheduler_meta_key'] . 'user-name', true)))) {
					update_post_meta($post_id, $this->settings['scheduler_meta_key'] . 'user-id', $userID);
				}
				$args = array("ID" => $post_id, "post_title" => 'Scheduler', "post_content" => get_post_meta($post_id, $this->settings['scheduler_meta_key'] . 'frequency', true));
				wp_update_post($args);
				return $post_id;
			} catch (\Exception $ex) {
				add_settings_error("hf-sc-user-id-api", "120", "There is no user with this UserName registered in SoundCloud");
				set_transient('settings_errors', get_settings_errors("hf-sc-user-id-api"), 30);
			}
		}
		return $post_id;
	}


	function editFieldsHeader($columns)
	{
		unset($columns['date']);
		unset($columns['title']);
		$columns['new-title'] = __("Title");
		$columns['frequency'] = __("Frequency");
		$columns['last-import']= __("Last Import");
		$columns['imported'] = __("Imported");
		return $columns;

	}

	function editFieldsContent($columns,$post_id)
	{
		$post = get_post($post_id);
		switch($columns)
		{
			case 'frequency':
				$fq = $this->cron->getFrequency(array('id'=>$post->post_content));
				echo  $fq->text;
				break;
			case 'new-title':
				$title = "<div class='hf-sc-row-title'>".get_the_title($post_id)."</div>";
				$title.= '<div class="hf-sc-row-sub-title"> for '.get_post_meta($post_id,$this->settings['scheduler_meta_key'].'user-name',true).'</div>';
				echo $title;
				break;
			case 'last-import':
				$today = current_time("timestamp");
				$post_modified = strtotime($post->post_modified);
				$time_delta = $today - $post_modified;
				echo $this->getTimeStringFromDelta($time_delta);
				break;
			case 'imported':
				echo $this->getImported($post);
				break;
		}

		//return $columns;
	}


	function initAdminMenu()
	{

		add_menu_page(__("HighFusion SoundCloud Aggregator"),__("HF SoundCloud"),$this->settings['capabilities'],$this->admin_main_page_url,false,'dashicons-format-audio','80.060');

		add_submenu_page($this->admin_main_page_url,__('Schedule Tools'),__('Schedule Tools'),$this->settings['capabilities'],$this->admin_main_page_url);
		add_submenu_page($this->admin_main_page_url,__('SoundCloud API Settings'),__('Settings'),$this->settings['capabilities'],'sound-cloud-settings',array($this,'settings'));
		//add_submenu_page($this->admin_main_page_url,__('SoundCloud API Settings'),__('Test API'),$this->settings['capabilities'],'sound-cloud-test',array($this,'testAPI'));

		add_action('admin_init', array($this, 'requestHandlerSettings'));
		remove_post_type_support($this->import_post_type,'editor');
	}

	function testAPI()
	{
		/*//wp_clear_scheduled_hook('hf_sc_scheduler_cron');
		$test = HF_SoundCloud_Engine::getInstance();
		$test->setCron($this->cron);
		echo $test->getTracks();*/

	}
	function settings()
	{
		$obj = new HF_SoundCloud_Settings();
		$params = $this->forward_manager($obj);

		echo $this->View(isset($params['view'])?$params['view']:"base_view",array_merge(array("btObj"=>$obj),$params));
	}

	function requestHandlerSettings()
	{
		if(is_admin()) {
			if (((isset($_POST['hf-sc-save']) && !empty($_POST['hf-sc-save']) && $_POST['hf-sc-save'] == 1)) && $_REQUEST['page'] == 'sound-cloud-settings') {
				$obj = new HF_SoundCloud_Settings();
				$this->forward_request_manager($obj,$_REQUEST['page']);
			}
		}
	}

	function registerPostTypes()
	{
		//registered main post-type: default value is Podcasts if not exist
		if(!post_type_exists($this->default_main_post_type))
		{
			$this->initPodcastType();
		}

		$this->initImportPostType();
	}

	function initPodcastType(){
		$labels = array(
			'name'               => __( 'Podcasts'),
			'singular_name'      => __( 'Podcast'),
			'menu_name'          => __( 'Podcasts'),
			'name_admin_bar'     => __( 'Book'),
			'add_new'            => __( 'Add New'),
			'add_new_item'       => __( 'Add New Podcast'),
			'new_item'           => __( 'New Podcast'),
			'edit_item'          => __( 'Edit Podcast'),
			'view_item'          => __( 'View Podcast'),
			'all_items'          => __( 'All Podcasts'),
			'search_items'       => __( 'Search Podcasts'),
			'parent_item_colon'  => __( 'Parent Podcasts:'),
			'not_found'          => __( 'No podcasts found.'),
			'not_found_in_trash' => __( 'No podcasts found in Trash.')
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.'),
			'menu_icon'          => 'dashicons-admin-media',
			'menu_position'      => 5,
			'map_meta_cap'		=> true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus' =>true,
			'query_var'          => true,
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => array('title', 'author', 'editor')
		);

		register_post_type( $this->default_main_post_type, $args );
	}
	function initImportPostType()
	{

	/*	if ( post_type_exists( $this->import_post_type ) ) {
			return get_post_type_object( $this->import_post_type );
		}*/

		$args = array(
			'description'        => 'SoundCloud Scheduler',
			'public'			=> false,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'capabilities'		=> array(
				'edit_post'			=> $this->settings['capabilities'],
				'delete_post'		=> $this->settings['capabilities'],
				'edit_posts'		=> $this->settings['capabilities'],
				'delete_posts'		=> $this->settings['capabilities'],
			),
			'has_archive'        => false,
			'hierarchical'       => false,
			'rewrite'			=> false,
			'query_var'			=> false,
			'supports' 			=> array(''),
			'show_in_menu'		=> false,
			'show_in_nav_menus'  => false,
			'menu_position'      => null,


		);
		$args['labels'] = array(
			'name'               => __( 'SoundCloud Schedulers List'),
			'singular_name'      => __( 'SoundCloud Scheduler'),
			'menu_name'          => __( 'SoundCloud Schedulers List'),
			'name_admin_bar'     => __( 'SoundCloud Scheduler Item'),
			'add_new'            => __( 'Add New'),
			'add_new_item'       => __( 'Add New Scheduler Record'),
			'new_item'           => __( 'New Scheduler Record'),
			'edit_item'          => __( 'Edit Scheduler Record'),
			'view_item'          => __( 'View Scheduler Record'),
			'all_items'          => __( 'All Scheduler Records'),
			'search_items'       => __( 'Search Scheduler Records'),
			'parent_item_colon'  => __( 'Parent Scheduler Record:'),
			'not_found'          => __( 'No Scheduler Records found.'),
			'not_found_in_trash' => __( 'No Scheduler Records found in Trash.'),
		);

		return register_post_type( $this->import_post_type, $args );
	}
	function isClientIDExists()
	{

		if($error = get_transient('settings_errors'))
		{
			$out_error = '<div class="notice notice-error"><ul>';
			foreach($error as $er)
			{
				$out_error.='<li>'.$er['message'].'</li>';
			}
			$out_error.="</ul></div>";
			echo $out_error;
		}
		$cl = get_option("hf_sound_cloud_settings");
		if(!isset($cl) || empty($cl))
		{
			echo '<div class="notice notice-warning"><p>SoundCloud API: Please add your ClientID <a href="edit.php?post_type=sound_cloud_import&page=sound-cloud-settings">here</a> to work plugin properly.</p></div>';
		}
	}

	function postSubmitAction($post)
	{
		if($post->post_type==$this->import_post_type)
		{
			$status = 'Active';

			?>
			<script type="text/javascript">
				(function($) {

					$('#post-status-display').html('<?php echo $status; ?>');
					$('#misc-publishing-actions a').remove();
					$('#misc-publishing-actions .hide-if-js').remove();
					$('#minor-publishing-actions').remove();

				})(jQuery);
			</script>
			<?php


		}
	}

	function removeAutoDraft()
	{
		global $wpdb;
		$post_status_draft = 'auto-draft';

		$sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts as p WHERE p.post_type=%s AND p.post_status=%s ",$this->import_post_type,$post_status_draft);

		$res = $wpdb->get_results($sql);


		if($res) {

			foreach ($res as $r)
			{
				if(floor((current_time("timestamp") - get_post_time("U",false,$r->ID))/DAY_IN_SECONDS)>=1)
				{
					wp_delete_post($r->ID);
				}

			}
		}

	}

	function removeBulkActions($actions)
	{

		unset($actions['trash']);
		//unset($actions['edit']);
		return $actions;
	}
	function editBulkActions()
	{
		global $post_type;

		if($post_type==$this->import_post_type)
		{
			?>
			<script type="text/javascript">
				(function($) {
					$('<option>').val('del').text('<?php _e('Delete')?>').appendTo("select[name='action']");
					$('<option>').val('del').text('<?php _e('Delete')?>').appendTo("select[name='action2']");
					$('#post-query-submit').remove();
				})(jQuery);
			</script>
			<?php
		}
	}
	function removeFilter($months,$post_type)
	{
		if($post_type==$this->import_post_type) {
			return array();
		}
		return $months;
	}

}