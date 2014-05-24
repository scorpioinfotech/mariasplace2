<?php
/**
 * WooCommerce Pre-Orders
 *
 * @package     WC-Pre-Orders/Admin
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Pre-Orders Admin class
 *
 * Loads / saves the admin settings page
 *
 * @since 1.0
 */
class WC_Pre_Orders_Admin {


	/** @var string settings page ID */
	private $page_id;

	/** @var array pre-order manage/actions tabs */
	private $tabs;

	/** @var string settings page tab ID */
	private $settings_tab_id = 'pre_orders';

	/* @var \WC_Pre_Orders_List_Table The pre-orders list table object */
	private $pre_orders_list_table;


	/**
	 * Setup admin class
	 *
	 * @since  1.0
	 */
	public function __construct() {

		$this->tabs = array(
			'manage'  => __( 'Manage', WC_Pre_Orders::TEXT_DOMAIN ),
			'actions' => __( 'Actions', WC_Pre_Orders::TEXT_DOMAIN ),
		);

		// maybe install default settings / terms
		$this->maybe_install();

		/** general admin hooks */

		// Load necessary admin styles / scripts (after giving woocommerce a chance to register their scripts so we can make use of them)
		add_action( 'admin_enqueue_scripts', array( $this, 'load_styles_scripts' ), 15 );

		// Add 'Pre-Orders' link under WooCommerce menu
		add_action( 'admin_menu', array( $this, 'add_menu_link' ) );


		/** settings hooks */

		// Add 'Pre-Orders' tab to WooCommerce settings
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab'  ) );

		// Show settings
		add_action( 'woocommerce_settings_tabs_' . $this->settings_tab_id, array( $this, 'show_settings' ) );

		// Save settings
		add_action( 'woocommerce_update_options_' . $this->settings_tab_id, array( $this, 'save_settings' ) );

		// Pre-Orders list table settings
		add_action( 'in_admin_header',   array( $this, 'load_pre_orders_list_table' ) );
		add_filter( 'set-screen-option', array( $this, 'set_pre_orders_list_option' ), 10, 3 );

		/** product hooks */

		// add 'Pre-Orders' product writepanel tab
		add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'add_product_tab' ), 11 );

		// Add 'Pre-Orders' tab content
		add_action( 'woocommerce_product_write_panels', array( $this, 'add_product_tab_options' ), 11 );

		// Save 'Pre-Orders' product options
		add_action( 'woocommerce_process_product_meta_simple',   array( $this, 'save_product_tab_options' ) );
		add_action( 'woocommerce_process_product_meta_variable', array( $this, 'save_product_tab_options' ) );

		/** order hooks */

		// add pre-order emails to list of available emails to resend
		add_filter( 'woocommerce_resend_order_emails_available', array( $this,'maybe_allow_resend_of_pre_order_emails' ) );

		// Hook to make sure pre order is properly set up when added through admin
		add_action( 'save_post', array( $this, 'check_manual_order_for_pre_order_products' ), 10, 1 );
	}


	/**
	 * Set installed option and default settings / terms
	 *
	 * @since 1.0
	 */
	private function maybe_install() {
		global $woocommerce;

		$installed_version = get_option( 'wc_pre_orders_version' );

		// install
		if ( ! $installed_version ) {

			// add 'pre-order' shop order status term
			$woocommerce->init_taxonomy();
			if ( ! get_term_by( 'slug', 'pre-ordered', 'shop_order_status' ) )
				wp_insert_term( 'pre-ordered', 'shop_order_status' );

			// install default settings
			foreach ( $this->get_settings() as $setting ) {

				if ( isset( $setting['default'] ) )
					update_option( $setting['id'], $setting['default'] );
			}
		}

		// upgrade - installed version lower than plugin version?
		if ( -1 === version_compare( $installed_version, WC_Pre_Orders::VERSION ) ) {

			$this->upgrade( $installed_version );

			// new version number
			update_option( 'wc_pre_orders_version', WC_Pre_Orders::VERSION );
		}
	}


	/**
	 * Handles upgrades
	 *
	 * @since 1.0
	 * @param string $installed_version
	 */
	private function upgrade( $installed_version ) {

		// upgrade code
	}


	/**
	 * Load admin styles & scripts only on needed pages
	 *
	 * @since 1.0
	 * @param string $hook_suffix the menu/page identifier
	 */
	public function load_styles_scripts( $hook_suffix ) {
		global $woocommerce, $wc_pre_orders, $wp_scripts;

		// only load on settings / order / product pages
		if( $this->page_id == $hook_suffix || 'edit.php' == $hook_suffix || 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Admin CSS
			wp_enqueue_style( 'wc_pre_orders_admin', $wc_pre_orders->get_plugin_url() . '/assets/css/wc-pre-orders-admin.min.css', WC_Pre_Orders::VERSION );

			// Admin JS
			wp_enqueue_script( 'wc_pre_orders_admin', $wc_pre_orders->get_plugin_url() . '/assets/js/wc-pre-orders-admin' . $suffix . '.js', WC_Pre_Orders::VERSION );

			// load WooCommerce CSS/JS on custom menu page
			if ( $this->page_id == $hook_suffix ) {

				wp_enqueue_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css' );
				wp_enqueue_script( 'woocommerce_admin', $woocommerce->plugin_url() . '/assets/js/admin/woocommerce_admin.min.js', array( 'jquery', 'jquery-ui-widget', 'jquery-ui-core' ), $woocommerce->version );
				wp_enqueue_script( 'ajax-chosen' );
				wp_enqueue_script( 'chosen' );
			}

			// load jQuery UI Date/TimePicker on new/edit product page and pre-orders > actions page
			if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix || $this->page_id == $hook_suffix ) {

				// get loaded jQuery version
				$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.8.2';

				// load jQuery UI CSS while respecting loaded jQuery version
				wp_enqueue_style( 'jquery-ui-style', ( is_ssl() ) ? 'https:' : 'http:' . '//ajax.googleapis.com/ajax/libs/jqueryui/' . $jquery_version . '/themes/smoothness/jquery-ui.css' );

				// load TimePicker add-on which extends jQuery DatePicker
				wp_enqueue_script( 'jquery_ui_timepicker', $wc_pre_orders->get_plugin_url() . '/assets/js/jquery-ui-timepicker-addon' . $suffix . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), '1.2' );

				// add calendar image location
				wp_localize_script( 'wc_pre_orders_admin', 'wc_pre_orders_params', array( 'calendar_image' => $woocommerce->plugin_url().'/assets/images/calendar.png' ) );
			}
		}
	}


	/*---------------------------------------------*
	* 'Pre-Orders' sub-menu page functions
	*---------------------------------------------*/


	/**
	 * Add 'Pre-Orders' sub-menu link under 'WooCommerce' top level menu
	 *
	 * @since 1.0
	 */
	public function add_menu_link() {

		$this->page_id = add_submenu_page(
			'woocommerce',
			__( 'Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
			__( 'Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
			'manage_woocommerce',
			'wc_pre_orders',
			array( $this, 'show_sub_menu_page' )
		);

		// add the Pre-Orders list Screen Options
		add_action( 'load-' . $this->page_id, array( $this, 'add_pre_orders_list_options' ) );
	}


	/**
	 * Save our list option
	 *
	 * @since 1.0
	 * @param string $status unknown
	 * @param string $option the option name
	 * @param mixed $value the option value
	 * @return mixed
	 */
	public function set_pre_orders_list_option( $status, $option, $value ) {
		if ( 'wc_pre_orders_edit_pre_orders_per_page' == $option )
			return $value;

		return $status;
	}


	/**
	 * Add the Pre-Orders list table Screen Options
	 *
	 * @since 1.0
	 */
	public function add_pre_orders_list_options() {

		$args = array(
			'label' => __( 'Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
			'default' => 20,
			'option' => 'wc_pre_orders_edit_pre_orders_per_page',
		);

		add_screen_option( 'per_page', $args );
	}


	/**
	 * Loads the pre-orders list table so the columns can be hidden/shown from
	 * the page Screen Options dropdown (this must be done prior to Screen Options
	 * being rendered)
	 */
	public function load_pre_orders_list_table() {
		if ( isset( $_GET['page'] ) && 'wc_pre_orders' == $_GET['page'] ) {
			$this->get_pre_orders_list_table();
		}
	}

	/**
	 * Show Pre-Orders Manage/Actions page content
	 *
	 * @since 1.0
	 */
	public function show_sub_menu_page() {

		$current_tab = ( empty( $_GET['tab'] ) ) ? 'manage' : urldecode( $_GET['tab'] );

		?>
		<div class="wrap woocommerce">
				<div id="icon-woocommerce" class="icon32-woocommerce-users icon32"><br /></div>
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">

				<?php

				// display tabs
				foreach ( $this->tabs as $tab_id => $tab_title ) {

					$class = ( $tab_id == $current_tab ) ? 'nav-tab nav-tab-active' : 'nav-tab';
					$url   = add_query_arg( 'tab', $tab_id, admin_url( 'admin.php?page=wc_pre_orders' ) );

					printf( '<a href="%s" class="%s">%s</a>', $url, $class, $tab_title );
				}

				?> </h2> <?php

				// show any messages
				if ( ! empty( $_GET['success'] ) ) {

					switch ( $_GET['success'] )  {

						case 'email':
							$message = __( 'Pre-Order customers emailed successfully', WC_Pre_Orders::TEXT_DOMAIN );
							break;

						case 'change-date':
							$message = __( 'Pre-Order Date Changed', WC_Pre_Orders::TEXT_DOMAIN );
							break;

						case 'complete':
							$message = __( 'Pre-Orders completed', WC_Pre_Orders::TEXT_DOMAIN );
							break;

						case 'cancel':
							$message = __( 'Pre-Orders cancelled', WC_Pre_Orders::TEXT_DOMAIN );
							break;

						default:
							$message = '';
							break;
					}

					if ( $message )
						echo '<div id="message" class="updated fade"><p><strong>' . $message . '</strong></p></div>';
				}


				// display tab content, default to 'Manage' tab
				if ( 'actions' === $current_tab )
					$this->show_actions_tab();
				else
					$this->show_manage_tab();

		?></div> <?php
	}


	/**
	 * Show the Pre-Orders > Manage tab content
	 *
	 * @since 1.0
	 */
	private function show_manage_tab() {

		// setup 'Manage Pre-Orders' list table and prepare the data
		$manage_table = $this->get_pre_orders_list_table();
		$manage_table->prepare_items();

		?><form method="get" id="mainform" action="" enctype="multipart/form-data"><?php
		// title/search result string
		echo '<h2>' . __( 'Manage Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN );
		if ( isset( $_GET['s'] ) && $_GET['s'] )
			echo '<span class="subtitle">' . sprintf( __( 'Search results for "%s"', WC_Pre_Orders::TEXT_DOMAIN ), $_GET['s'] ) . '</span>';
		echo '</h2>';

		// display any action messages
		$manage_table->render_messages();

		// Display the views
		$manage_table->views();
		$manage_table->search_box( __( 'Search Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ), 'pre_order' );

		if ( ! empty( $_REQUEST['pre_order_status'] ) )
			echo '<input type="hidden" name="pre_order_status" value="' . esc_attr( $_REQUEST['pre_order_status'] ) . '" />';

		echo '<input type="hidden" name="page" value="' . esc_attr( $_REQUEST['page'] ) . '" />';

		// display the list table
		$manage_table->display();
		?></form><?php
	}


	/**
	 * Gets the pre-orders list table object
	 *
	 * @since 1.0
	 * @return WC_Pre_Orders_List_Table the pre-orders list table object
	 */
	private function get_pre_orders_list_table() {
		global $wc_pre_orders;

		if ( ! isset( $this->pre_orders_list_table ) ) {

			$class_name = apply_filters( 'wc_pre_orders_list_table_class_name', 'WC_Pre_Orders_List_Table' );

			require( $wc_pre_orders->get_plugin_path() . '/classes/class-wc-pre-orders-list-table.php' );
			$this->pre_orders_list_table = new $class_name();
		}

		return $this->pre_orders_list_table;
	}


	/*---------------------------------------------------------------------*
	* Methods for displaying / processing the Pre-Orders > Action tab section
	*----------------------------------------------------------------------*/


	/**
	 * Show the Pre-Orders > Actions tab content
	 *
	 * @since 1.0
	 */
	private function show_actions_tab() {
		global $woocommerce;

		// process actions
		if ( ! empty( $_POST['wc_pre_orders_action'] ) ) {

			$this->process_actions_tab();

			wp_safe_redirect( add_query_arg( 'success', $_POST['wc_pre_orders_action'] ) );

			exit;
		}

		// load file for woocommerce_admin_fields() usage
		require_once( $woocommerce->plugin_path() . '/admin/woocommerce-admin-settings.php' );

		// Add 'submit_button' woocommerce_admin_fields() field type
		add_action( 'woocommerce_admin_field_submit_button', array( $this, 'generate_submit_button' ) );

		$current_section = ( empty( $_REQUEST['section'] ) ) ? 'email' : sanitize_text_field( urldecode( $_REQUEST['section'] ) );

		$actions = array(
			'email'       => __( 'Email', WC_Pre_Orders::TEXT_DOMAIN ),
			'change-date' => __( 'Change Release Date', WC_Pre_Orders::TEXT_DOMAIN ),
			'complete'    => __( 'Complete', WC_Pre_Orders::TEXT_DOMAIN ),
			'cancel'      => __( 'Cancel', WC_Pre_Orders::TEXT_DOMAIN ),
		);

		foreach ( $actions as $action_id => $action_title ) {

			$current = ( $action_id == $current_section ) ? ' class="current"' : '';

			$links[] = sprintf( '<a href="%s"%s>%s</a>', add_query_arg( array( 'section' => $action_id ), admin_url( 'admin.php?page=wc_pre_orders&tab=actions' ) ), $current, $action_title );
		}

		echo '<ul class="subsubsub"><li>' . implode( ' | </li><li>', $links ) . '</li></ul><br class="clear" />';
		?><form method="post" id="mainform" action="" enctype="multipart/form-data"><?php
		woocommerce_admin_fields( $this->get_action_fields( $current_section ) );

		wp_nonce_field( 'wc-pre-orders-process-actions' );
		?><input type="hidden" name="wc_pre_orders_action" value="<?php echo esc_attr( $current_section ); ?>" /></form><?php
	}


	/**
	 * Process the actions from the 'Actions' tab
	 *
	 * @since 1.0
	 */
	public function process_actions_tab() {
		global $wc_pre_orders;

		// security check
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'wc-pre-orders-process-actions' ) )
			wp_die( __( 'Action failed. Please refresh the page and retry.', WC_Pre_Orders::TEXT_DOMAIN ) );

		// user check
		if ( ! current_user_can( 'manage_woocommerce' ) )
			wp_die( __( 'You do not have the correct permissions to do this.', WC_Pre_Orders::TEXT_DOMAIN ) );

		// get parameters
		$action                = ( in_array( $_POST['wc_pre_orders_action'], array( 'email', 'change-date', 'complete', 'cancel' ), true ) ) ? $_POST['wc_pre_orders_action'] : '';
		$product_id            = ( ! empty( $_POST['wc_pre_orders_action_product'] ) ) ? absint( $_POST['wc_pre_orders_action_product'] ) : '';
		$send_email            = ( isset( $_POST['wc_pre_orders_action_enable_email_notification'] ) && '1' === $_POST['wc_pre_orders_action_enable_email_notification'] ) ? true : false;
		$email_message         = ( ! empty( $_POST['wc_pre_orders_action_email_message'] ) ) ? wp_filter_kses( $_POST['wc_pre_orders_action_email_message'] ) : '';
		$new_availability_date = ( ! empty( $_POST['wc_pre_orders_action_new_availability_date'] ) ) ? $_POST['wc_pre_orders_action_new_availability_date'] : '';

		if ( ! $action || ! $product_id )
			return;

		switch ( $action ) {

			// email all pre-ordered customers
			case 'email':

				WC_Pre_Orders_Manager::email_all_pre_order_customers( $product_id, $email_message );

				break;

			// change the release date for all pre-orders
			case 'change-date':

				// remove email notification if disabled
				if ( ! $send_email )
					remove_action( 'wc_pre_orders_pre_order_date_changed', array( $wc_pre_orders, 'send_transactional_email' ), 10 );

				WC_Pre_Orders_Manager::change_release_date_for_all_pre_orders( $product_id, $new_availability_date, $email_message );

				break;

			// complete all pre-orders
			case 'complete':

				// remove email notification if disabled
				if ( ! $send_email )
					remove_action( 'wc_pre_order_status_completed', array( $wc_pre_orders, 'send_transactional_email' ), 10 );

				WC_Pre_Orders_Manager::complete_all_pre_orders( $product_id, $email_message );

				break;

			// cancel all pre-orders
			case 'cancel':

				// remove email notification if disabled
				if ( ! $send_email )
					remove_action( 'wc_pre_order_status_active_to_cancelled', array( $wc_pre_orders, 'send_transactional_email' ), 10 );

				WC_Pre_Orders_Manager::cancel_all_pre_orders( $product_id, $email_message );

				break;

			default:
				break;
		}
	}


	/**
	 * Get the fields to display for the selected action, in the format required by woocommerce_admin_fields()
	 *
	 * @since 1.0
	 * @param string $section the current section to get fields for
	 * @return array
	 */
	private function get_action_fields( $section ) {

		$products = array(' ' => '');

		foreach ( WC_Pre_Orders_Manager::get_all_pre_order_enabled_products() as $product ) {
			$products[ $product->id ] = woocommerce_get_formatted_product_name( $product );
		}

		$fields = array(

			'email' => array(

				array(
					'name' => __( 'Email Pre-Order Customers', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc' => sprintf( __( 'You may send an email message to all customers who have pre-ordered a specific product. This will use the default template specified for the %sCustomer Note%s Email.', WC_Pre_Orders::TEXT_DOMAIN ), '<a href="' . admin_url( 'admin.php?page=woocommerce_settings&tab=email&section=WC_Email_Customer_Note' ) . '">', '</a>' ),
					'type' => 'title'
				),

				array(
					'id'       => 'wc_pre_orders_action_product',
					'name'     => __( 'Product', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Select which product to email all pre-ordered customers.' ),
					'default'  => ' ',
					'options'  => $products,
					'type'     => 'select',
				),

				array(
					'id'       => 'wc_pre_orders_action_email_message',
					'name'     => __( 'Message', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Enter a message to include in the email notification to customer. Limited HTML allowed.', WC_Pre_Orders::TEXT_DOMAIN ),
					'css'      => 'min-width: 300px;',
					'default'  => '',
					'type'     => 'textarea',
				),

				array( 'type' => 'sectionend' ),

				array(
					'name' => __( 'Send Emails', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'submit_button',
				),
			),

			'change-date' => array(

				array(
					'name' => __( 'Change the Pre-Order Release Date', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc' => __( 'You may change the release date for all pre-orders of a specific product. This will send an email notification to each customer informing them that the pre-order release date was changed, along with the new release date.', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'title'
				),

				array(
					'id'       => 'wc_pre_orders_action_product',
					'name'     => __( 'Product', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Select which product to change the release date for.' ),
					'default'  => ' ',
					'options'  => $products,
					'type'     => 'select',
				),

				array(
					'id'       => 'wc_pre_orders_action_new_availability_date',
					'name'     => __( 'New Availability Date', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'The new availability date for the product. This must be later than the current availability date.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default'  => '',
					'type'     => 'text',
				),

				array(
					'id'      => 'wc_pre_orders_action_enable_email_notification',
					'name'    => __( 'Send Email Notification', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc'    => __( 'Uncheck this to prevent email notifications from being sent to customers.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),

				array(
					'id'       => 'wc_pre_orders_action_email_message',
					'name'     => __( 'Message', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Enter a message to include in the email notification to customer.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default'  => '',
					'css'      => 'min-width: 300px;',
					'type'     => 'textarea',
				),

				array( 'type' => 'sectionend' ),

				array(
					'name' => __( 'Change Release Date', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'submit_button',
				),
			),

			'complete' => array(

				array(
					'name' => __( 'Complete Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc' => __( 'You may complete all pre-orders for a specific product. This will charge the customer\'s card the pre-ordered amount, change their order status to completed, and send them an email notification.', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'title'
				),

				array(
					'id'       => 'wc_pre_orders_action_product',
					'name'     => __( 'Product', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Select which product to complete all pre-orders for.' ),
					'default'  => ' ',
					'options'  => $products,
					'type'     => 'select',
				),

				array(
					'id'      => 'wc_pre_orders_action_enable_email_notification',
					'name'    => __( 'Send Email Notification', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc'    => __( 'Uncheck this to prevent email notifications from being sent to customers.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),

				array(
					'id'       => 'wc_pre_orders_action_email_message',
					'name'     => __( 'Message', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Enter a message to include in the email notification to customer.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default'  => '',
					'css'      => 'min-width: 300px;',
					'type'     => 'textarea',
				),

				array( 'type' => 'sectionend' ),

				array(
					'name' => __( 'Complete Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'submit_button',
				),
			),

			'cancel' => array(
				array(
					'name' => __( 'Cancel Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc' => __( 'You may cancel all pre-orders for a specific product. This will mark the order as cancelled and send the customer an email notification. If pre-orders were charged upfront, you must manually refund the orders.', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'title'
				),

				array(
					'id'       => 'wc_pre_orders_action_product',
					'name'     => __( 'Product', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Select which product to cancel all pre-orders for.' ),
					'default'  => ' ',
					'options'  => $products,
					'type'     => 'select',
				),

				array(
					'id'      => 'wc_pre_orders_action_enable_email_notification',
					'name'    => __( 'Send Email Notification', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc'    => __( 'Uncheck this to prevent email notifications from being sent to customers.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),

				array(
					'id'       => 'wc_pre_orders_action_email_message',
					'name'     => __( 'Message', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip' => __( 'Enter a message to include in the email notification to customer.', WC_Pre_Orders::TEXT_DOMAIN ),
					'default'  => '',
					'css'      => 'min-width: 300px;',
					'type'     => 'textarea',
				),

				array( 'type' => 'sectionend' ),

				array(
					'name' => __( 'Cancel Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
					'type' => 'submit_button',
				),
			),
		);

		return ( isset( $fields[ $section ] ) ) ? $fields[ $section ] : array();
	}


	/**
	 * Generate a submit button, called via a do_action() inside woocommerce_admin_fields() for non-default field types
	 *
	 * @since 1.0
	 * @param array $field the field info
	 */
	public function generate_submit_button( $field ) {

		submit_button( $field['name'] );
	}


	/*---------------------------------------------*
	* Settings functions
	*---------------------------------------------*/

	/**
	 * Add 'Pre-Orders' tab to WooCommerce Settings tabs
	 *
	 * @since 1.0
	 * @param array $settings_tabs tabs array sans 'Pre-Orders' tab
	 * @return array $settings_tabs now with 100% more 'Pre-Orders' tab!
	 */
	public function add_settings_tab( $settings_tabs ) {

		$settings_tabs[ $this->settings_tab_id ] = __( 'Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN );

		return $settings_tabs;
	}


	/**
	 * Show the 'Pre-Orders' settings page
	 *
	 * @since 1.0
	 */
	public function show_settings() {

		woocommerce_admin_fields( $this->get_settings() );
	}


	/**
	 * Save the 'Pre-Orders' settings page
	 *
	 * @since 1.0
	 */
	public function save_settings() {

		woocommerce_update_options( $this->get_settings() );
	}


	/**
	 * Returns settings array for use by output/save functions
	 *
	 * @since  1.0
	 * @return array settings
	 */
	private function get_settings() {

		return apply_filters( 'wc_pre_orders_settings', array(

			array(
				'title' => __( 'Button Text', WC_Pre_Orders::TEXT_DOMAIN ),
				'type' => 'title'
			),

			array(
				'title'    => __( 'Add to Cart Button Text', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'This controls the add to cart button text on single product pages for products that have pre-orders enabled.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_add_to_cart_button_text',
				'default'  => __( 'Pre-Order Now', WC_Pre_Orders::TEXT_DOMAIN ),
				'type'     => 'text',
			),

			array(
				'title'    => __( 'Place Order Button Text', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'This controls the place order button text on the checkout when an order contains a pre-orders.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_place_order_button_text',
				'default'  => __( 'Place Pre-Order Now', WC_Pre_Orders::TEXT_DOMAIN ),
				'type'     => 'text',
			),

			array( 'type' => 'sectionend' ),

			array(
				'title' => __( 'Product Message', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'  => sprintf( __( 'Adjust the message by using %1$s{availability_date}%2$s and %1$s{availability_time}%2$s to represent the product\'s availability date and time.', WC_Pre_Orders::TEXT_DOMAIN ), '<code>', '</code>' ),
				'type'  => 'title'
			),

			array(
				'title'    => __( 'Single Product Page Message', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'Add an optional message to the single product page below the price. Use this to announce when the pre-order will be available by using {availability_date} and {availability_time}. Limited HTML is allowed. Leave blank to disable.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_single_product_message',
				'default'  => sprintf( __( 'This item will be released on %s.', WC_Pre_Orders::TEXT_DOMAIN ), '{availability_date}' ),
				'type'     => 'textarea',
			),

			array(
				'title'    => __( 'Shop Loop Product Message', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'Add an optional message to each pre-order enabled product on the shop loop page above the add to cart button. Use this to announce when the pre-order will be available by using {availability_date} and {availability_time}. Limited HTML is allowed. Leave blank to disable.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_shop_loop_product_message',
				'default'  => sprintf( __( 'Available on %s.', WC_Pre_Orders::TEXT_DOMAIN ), '{availability_date}' ),
				'type'     => 'textarea',
			),

			array( 'type' => 'sectionend' ),

			array(
				'title' => __( 'Cart / Checkout Display Text', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'  => sprintf( __( 'Adjust the display of the order total by using %1$s{order_total}%2$s to represent the order total and %1$s{availability_date}%2$s to represent the product\'s availability date.', WC_Pre_Orders::TEXT_DOMAIN ), '<code>', '</code>' ),
				'type'  => 'title'
			),

			array(
				'title'    => __( 'Availability Date Title Text', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'This controls the title of the availability date section on the cart/checkout page. Leave blank to disable display of the availability date in the cart.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_availability_date_cart_title_text',
				'default'  => __( 'Available On', WC_Pre_Orders::TEXT_DOMAIN ),
				'type'     => 'text',
			),

			array(
				'title'    => __( 'Charged Upon Release Order Total Format', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'This controls the order total format when the cart contains a pre-order charged upon release. Use this to indicate when the customer will be charged for their pre-order by using {availability_date} and {order_total}.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_upon_release_order_total_format',
				'default'  => sprintf( __( '%s charged on %s', WC_Pre_Orders::TEXT_DOMAIN ), '{order_total}', '{availability_date}' ),
				'css'      => 'min-width: 300px;',
				'type'     => 'text',
			),

			array(
				'title'    => __( 'Charged Upfront Order Total Format', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc'     => __( 'This controls the order total format when the cart contains a pre-order charged upfront. Use this to indicate how the customer is charged for their pre-order by using {availability_date} and {order_total}.', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip' => true,
				'id'       => 'wc_pre_orders_upfront_order_total_format',
				'default'  => sprintf( __( '%s charged upfront', WC_Pre_Orders::TEXT_DOMAIN ), '{order_total}' ),
				'css'      => 'min-width: 150px;',
				'type'     => 'text',
			),

			array( 'type' => 'sectionend' ),
		) );
	}


	/*---------------------------------------------*
	* Product tab functions
	*---------------------------------------------*/

	/**
	 * Add 'Pre-Orders' tab to product writepanel
	 *
	 * @since 1.0
	 */
	public function add_product_tab() {

		?><li class="wc_pre_orders_tab wc_pre_orders_options"><a href="#wc_pre_orders_data"><?php _e( 'Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ); ?></a></li><?php
	}


	/**
	 * Add pre-orders options to product writepanel
	 *
	 * @since 1.0
	 */
	public function add_product_tab_options() {
		global $post, $woocommerce;

	?>
	<div id="wc_pre_orders_data" class="panel woocommerce_options_panel">
		<div class="options_group">
			<?php

			if ( $has_active_pre_orders = WC_Pre_Orders_Product::product_has_active_pre_orders( $post->ID ) )
				echo "<p><strong>" . sprintf( __( 'There are active pre-orders for this product. To change these settings, please %scomplete or cancel the active pre-orders%s first.', WC_Pre_Orders::TEXT_DOMAIN ), '<a href="' . admin_url( 'admin.php?page=wc_pre_orders' ) . '">', '</a>' ) . "</strong></p>";

			do_action( 'wc_pre_orders_product_options_start' );

			// enable pre-orders
			woocommerce_wp_checkbox(
				array(
					'id'          => '_wc_pre_orders_enabled',
					'label'       => __( 'Enable Pre-Orders', WC_Pre_Orders::TEXT_DOMAIN ),
					'description' => __( 'Enable pre-orders for this product. For variable products, pre-orders are enabled for each variation.', WC_Pre_Orders::TEXT_DOMAIN ),
				)
			);

			// availability date/time
			$availability_timestamp = WC_Pre_Orders_Product::get_localized_availability_datetime_timestamp( $post->ID );
			?><p class="form-field _wc_pre_orders_availability_datetime_field ">
				<label for="_wc_pre_orders_availability_datetime"><?php _e( 'Availability Date/Time', WC_Pre_Orders::TEXT_DOMAIN ); ?></label>
				<input type="text" class="short" name="_wc_pre_orders_availability_datetime" id="_wc_pre_orders_availability_datetime" value="<?php echo esc_attr( ( 0 === $availability_timestamp ) ? '' : date( 'Y-m-d H:i', $availability_timestamp ) ); ?>" placeholder="YYYY-MM-DD HH:MM"  />
				<img class="help_tip" data-tip="<?php printf( __( 'Set the date %s time that this pre-order will be available. The product will behave as a normal product when this date/time is reached.', WC_Pre_Orders::TEXT_DOMAIN ), '&amp;' ); ?>" src="<?php echo esc_url( $woocommerce->plugin_url() . '/assets/images/help.png' ); ?>" height="16" width="16" />
			</p>
			<?php

			// pre-order fee
			woocommerce_wp_text_input(
				array(
					'id'          => '_wc_pre_orders_fee',
					'label'       => __( 'Pre-Order Fee', WC_Pre_Orders::TEXT_DOMAIN ),
					'description' => __( 'Set a fee to be charged when a pre-order is placed. Leave blank to not charge a pre-order fee.', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip'    => true,
				)
			);

			woocommerce_wp_select(
				array(
					'id'          => '_wc_pre_orders_when_to_charge',
					'label'       => __( 'When to Charge', WC_Pre_Orders::TEXT_DOMAIN ),
					'description' => __( 'Select "Upon Release" to charge the entire pre-order amount (the product price + pre-order fee if applicable) when the pre-order becomes available. Select "Upfront" to charge the pre-order amount during the initial checkout.', WC_Pre_Orders::TEXT_DOMAIN ),
					'desc_tip'    => true,
					'default'     => 'upon_release',
					'options'     => array(
						'upon_release' => __( 'Upon Release', WC_Pre_Orders::TEXT_DOMAIN ),
						'upfront'      => __( 'Upfront', WC_Pre_Orders::TEXT_DOMAIN ),
					),
				)
			);

			do_action( 'wc_pre_orders_product_options_end' );
		?>
		</div>
		<?php
		// disable fields if the product has active pre-orders
		if ( $has_active_pre_orders ) {
			ob_start();
			?>
				$('input[name^=_wc_pre_orders_], select#_wc_pre_orders_when_to_charge').attr('disabled', true);
				$('img.ui-datepicker-trigger').css('display','none');
			<?php
			$woocommerce->add_inline_js( ob_get_clean() );
		}
		?>
	</div>
	<?php
	}


	/**
	 * Save pre-order options
	 *
	 * @since 1.0
	 * @param int $post_id the ID of the product being saved
	 */
	public function save_product_tab_options( $post_id ) {

		// don't save any settings if there are active pre-orders
		if ( WC_Pre_Orders_Product::product_has_active_pre_orders( $post_id ) )
			return;

		// pre-orders enabled
		if ( isset( $_POST['_wc_pre_orders_enabled'] ) && 'yes' === $_POST['_wc_pre_orders_enabled'] )
			update_post_meta( $post_id, '_wc_pre_orders_enabled', 'yes' );
		else
			update_post_meta( $post_id, '_wc_pre_orders_enabled', 'no' );

		/*
		 * Save the availability date/time
		 *
		 * The date/time a pre-order is released is saved as a unix timestamp adjusted for the site's timezone. For example,
		 * when an admin sets a pre-order to be released on 2013-06-25 12pm EST (UTC-4), it is saved as a timestamp equivalent
		 * to 2013-12-25 4pm UTC. This makes the pre-order release check much easier, as it's a simple timestamp comparison,
		 * because the release datetime and the current time are both in UTC.
		 */
		if ( ! empty( $_POST['_wc_pre_orders_availability_datetime'] ) ) {

			try {

				// get datetime object from site timezone
				$datetime = new DateTime( $_POST['_wc_pre_orders_availability_datetime'], new DateTimeZone( WC_Pre_Orders_Product::get_wp_timezone_string() ) );

				// get the unix timestamp (adjusted for the site's timezone already)
				$timestamp = $datetime->format( 'U' );

				// don't allow availability dates in the past
				if ( $timestamp <= time() )
					$timestamp = '';

				// set the availability datetime
				update_post_meta( $post_id, '_wc_pre_orders_availability_datetime', $timestamp );

			} catch ( Exception $e ) {
				global $wc_pre_orders;

				$wc_pre_orders->log( $e->getMessage() );
			}

		} else {

			delete_post_meta( $post_id, '_wc_pre_orders_availability_datetime' );
		}

		// pre-order fee
		if ( isset( $_POST['_wc_pre_orders_fee'] ) && is_numeric( $_POST['_wc_pre_orders_fee'] ) )
			update_post_meta( $post_id, '_wc_pre_orders_fee', $_POST['_wc_pre_orders_fee'] );

		// when to charge pre-order amount
		if ( isset( $_POST['_wc_pre_orders_when_to_charge'] ) && isset( $_POST['_wc_pre_orders_enabled'] ) && 'yes' === $_POST['_wc_pre_orders_enabled'] )
			update_post_meta( $post_id, '_wc_pre_orders_when_to_charge', ( 'upon_release' === $_POST['_wc_pre_orders_when_to_charge'] ) ? 'upon_release' : 'upfront' );

		do_action( 'wc_pre_orders_save_product_options', $post_id );
	}


	/**
	 * Add pre-order emails to the list of order emails that can be resent, based on the pre-order status
	 *
	 * @since 1.0
	 * @param array $available_emails simple array of WC_Email class IDs that can be resent
	 * @return array
	 */
	public function maybe_allow_resend_of_pre_order_emails( $available_emails ) {
		global $theorder;

		if ( WC_Pre_Orders_Order::order_contains_pre_order( $theorder ) ) {

			$available_emails[] = 'wc_pre_orders_pre_ordered';

			$pre_order_status = WC_Pre_Orders_Order::get_pre_order_status( $theorder );

			if ( 'cancelled' === $pre_order_status )
				$available_emails[] = 'wc_pre_orders_pre_order_cancelled';

			if ( 'completed' === $pre_order_status )
				$available_emails[] = 'wc_pre_orders_pre_order_available';
		}

		return $available_emails;
	}

	/**
	 * Marks the order as being a pre order if it contains pre order products in
	 * case an order gets added manually from the administration panel
	 *
	 * @since 1.0.4
	 * @param int $order_id id of the newly saved order
	 * @return void
	 */
	public function check_manual_order_for_pre_order_products( $order_id ) {
		// Make sure we are in the administration panel and we're saving an order
		if ( ! is_admin() || ! isset( $_POST['post_type'] ) || 'shop_order' != $_POST['post_type'] )
			return;

		$order = new WC_Order( $order_id );

		// Check if the order hasn't been processed already
		if ( WC_Pre_Orders_Order::order_contains_pre_order( $order ) )
			return;

		// Order has not been processed yet (or doesn't contain pre orders)
		$contains_pre_orders = false;

		foreach ( $order->get_items() as $item ) {
			if ( 'line_item' == $item['type'] ) {
				$product = get_product( $item['item_meta']['_product_id'][0] );

				if ( 'yes' == $product->wc_pre_orders_enabled ) {
					// Set correct flags for this order, making it a pre order
					update_post_meta( $order_id, '_wc_pre_orders_is_pre_order', 1 );
					update_post_meta( $order_id, '_wc_pre_orders_when_charged', $product->wc_pre_orders_when_to_charge );
					return;
				}
			}
		}
	}

} // end \WC_Pre_Orders_Admin class
