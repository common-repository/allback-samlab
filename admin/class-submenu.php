<?php
/**
 * Creates the submenu item for the plugin.
 *
 * @package сallback-samlab
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package сallback-samlab
 */
class Submenuсallback {

	/**
	 * A reference the class responsible for rendering the submenu page.
	 *
	 * @var    Submenu_Page
	 * @access private
	 */
	private $submenu_page_сallback;

	/**
	 * Initializes all of the partial classes.
	 *
	 * @param Submenu_Page $submenu_page A reference to the class that renders the
	 *																	 page for the plugin.
	 */
	public function __construct( $submenu_page_сallback ) {
		$this->submenu_page_сallback = $submenu_page_сallback;
	}

	/**
	 * Adds a submenu for this plugin to the 'Tools' menu.
	 */
	public function init() {
		 
         add_action( 'admin_menu', array( $this, 'add_options_page' ) );
         
	}

	/**
	 * Creates the submenu item and calls on the Submenu Page object to render
	 * the actual contents of the page.
	 */
	public function add_options_page() {
		
        add_menu_page(
			'Сallback Settings Page',//текст для отображения в качестве заголовка на соответствующей странице параметрв
			__("Сallback","callback-settings"),//текст для отображения в виде текста подменю для пункта меню
			'manage_options',//возможности, необходимые для доступа к этот пункт меню
			'callback-settings',//токен меню, который используется для идентификации этого элемента подменю
            array( $this->submenu_page_сallback, 'render' ),//функция обратного вызова, которая отвечает за вывод страницы администратора
            plugin_dir_url( __FILE__ ) . 'assets/img/icon.png',
            '60'
            
		);
        
        wp_enqueue_style('style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css');
        
        
	}
    

}
