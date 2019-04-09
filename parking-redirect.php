<?php
/*
Plugin Name: Parking Redirect
Plugin URI: http://plugin.playhroup.kr
Description: 관리자 로그인 상태가 아닐경우 지정된 URL로 Redirection 합니다.
Version: 1.0
Author: 놀이터
Author URI: http://playhroup.kr
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Parking_Redirect' ) ) {
	class Parking_Redirect{
		public function __construct() {
			add_action('admin_menu', array( $this, 'add_admin_menu' ));
			add_action('admin_init', array( $this, 'register_parking_redirect_settings'));
			add_action('template_redirect', array( $this, 'parking_redirect'));
		}

		public function add_admin_menu() {
			add_submenu_page('options-general.php', 'Parking Redirect', 'Parking Redirect', 'manage_options', 'parking_redirect_setting', array( $this, 'parking_redirect_setting_page' ));
		}

		public function parking_redirect_setting_page() {
			?>
			<div class="wrap">
				<h2>Parking redirect</h2>
				<form method="post" action="options.php">
					<p>관리자 로그인상태가 아닐경우 지정된 URL로 Redirection 합니다.</p>
					<?php settings_fields('parking_redirect_settings'); ?>
					<table class="form-table">
					<tbody>
					<tr valign="top">
						<th scope="row"><label for="parking_redirect_url">Redirect URL</label></th>
						<td>
							<input type="text" name="parking_redirect_url" id="parking_redirect_url" value="<?php echo get_option('parking_redirect_url'); ?>" class="regular-text">
							<p class="description">외부링크로 Redirect시에는 http:// 까지 입력해주세요.</p>
						</td>
					</tr>
					</tbody>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
			<?php
		}

		public function register_parking_redirect_settings() {
			register_setting('parking_redirect_settings','parking_redirect_url');
		}

		public function parking_redirect() {
			if( !current_user_can('administrator') ){
				wp_redirect( get_option('parking_redirect_url') );
			}
		}
	}

	return new Parking_Redirect();
}
