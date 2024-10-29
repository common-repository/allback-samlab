<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also defines a function that starts the plugin.
 *
 * @link              http://code.tutsplus.com/tutorials/creating-custom-admin-pages-in-wordpress-1
 * @since             1.1.0
 * @package           callback-samlab
 *
 * @wordpress-plugin
 * Plugin Name:       Callback Samlab
 * Plugin URI:        https://vseprosto.top/
 * Description:       This plugin makes a simple widget for callback on your website.
 * Version:           1.1.0
 * Author:            Aleks Moroz
 * Author URI:        https://vseprosto.top
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	 die;
}

function samlab_callback_activate() {
    global $wpdb;
	$table_name = $wpdb->prefix . 'callback';
	$sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
            date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			name varchar(255) DEFAULT NULL,
            content longtext NOT NULL,
			UNIQUE KEY id (id)
	);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'samlab_callback_activate' );

register_uninstall_hook( __FILE__, 'samlab_callback_drop_tables');
function samlab_callback_drop_tables()
{
	//drop a custom db table
	global $wpdb;
	$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'callback' );
    delete_option('callback-settings');
}

// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
	load_plugin_textdomain( 'callback-settings', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    include_once $file;
}

add_action( 'plugins_loaded', 'samlab_сallback_settings' );
//для админки ajax для фронта ajax
add_action( 'wp_ajax_getformsamlab', 'samlab_сallback_getform' );
add_action( 'wp_ajax_nopriv_getformsamlab', 'samlab_сallback_getform' );
//для админки ajax для фронта ajax
add_action( 'wp_ajax_nopriv_sampostmessage', 'samlab_сallback_postmessage' );
add_action( 'wp_ajax_sampostmessage', 'samlab_сallback_postmessage' );

function samlab_сallback_add_script() {
$option = get_option( 'callback-settings' );
?>    
<script>
function сallbackFunk()
{
	jQuery.confirm(
	{
		title: "<?php if($option['name'] != "")  { echo $option['name']; }else{ echo __("Сallback","callback-settings"); } ?>",
		content: "url:<?= admin_url('admin-ajax.php?action=getformsamlab') ?>",
        buttons: {
			sayMyName: {
				text: "<?= __( 'Send me', 'callback-settings' ) ?>",
				btnClass: "btn-green",
				action: function()
				{
                    var name = this.$content.find("input#input-name");
                    var email = this.$content.find("input#input-email"); 
                    var message = this.$content.find("textarea#input-message"); 
                    var errorText = this.$content.find(".text-danger");
                    
					if (!name.val().trim())
					{
						jQuery.alert(
						{
							title: "<?= __( 'Attention', 'callback-settings' ) ?>",
                            content: "<?=  __( 'Required field.', 'callback-settings' ) ?>",
							type: "red"
						});
						return false;
					}
					<?php if($option['emailcheck'] == "1")  { ?>else if(!email.val().trim())
					{
						jQuery.alert(
						{
							title: "<?= __( 'Attention', 'callback-settings' ) ?>",
                            content: "<?=  __( 'Required field.', 'callback-settings' ) ?>",
							type: "red"
						});
						return false;
					}<?php } ?><?php if($option['messagecheck'] == "1")  { ?>else if(!message.val().trim())
					{
						jQuery.alert(
						{
							title: "<?= __( 'Attention', 'callback-settings' ) ?>",
                            content: "<?=  __( 'Required field.', 'callback-settings' ) ?>",
							type: "red"
						});
						return false;
					}<?php } ?>
					else
					{
					     var postname = name.val();
                         var postemail = email.val();
                         var postmessage = message.val();
						 poss(postname, postemail, postmessage);
                         
					}
				}
			},
			cancel: {
			 text: "<?= __( 'Cancel', 'callback-settings' ) ?>",
             action: function(){
                // do nothing.
             }
			}
            
		}
	});
}

function poss(name, email, message){
    var ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
    var data = { 
        action: 'sampostmessage', 
        name:name,
        email:email,
        message:message,
        };
    
    jQuery.post( ajaxurl, data, function(response) {
        jQuery.alert("<?= $option['thankstext'] ?>");
    });
    
}

function callme() {
   var btn = document.activeElement.getAttribute('value');
   var ajaxurl = "<?= admin_url('admin-ajax.php?action=sampostmessage') ?>";
   var data   = jQuery("#"+btn).serialize();
   
   jQuery.post( ajaxurl, data, function(response) {
        jQuery.alert("<?= $option['thankstext'] ?>");
   }); 
}    

</script> 
<?php    
}
add_action('wp_footer', 'samlab_сallback_add_script', 999);

// регестрируем секцию для опций
function samlab_сallback_settings_init(){
    register_setting( 'mod-settings-sektion', 'callback-settings');
}

// Добавляем кнопки в текстовый html-редактор samlab_callback_form
function samlab_сallback_addquicktags() {
   if (wp_script_is('quicktags')) :
?>
    <script type="text/javascript">
      if (QTags) {  
        // QTags.addButton( id, display, arg1, arg2, access_key, title, priority, instance );
        QTags.addButton( 'samlab_shlink', '[samlab_callback]', '[samlab_callback]', '[samlab_callback]', '', 'callback link', 1005 );
        QTags.addButton( 'samlab_shbutton', '[samlab_callback_button]', '[samlab_callback_button]', '[samlab_callback_button]', '', 'callback button', 1006 );
        QTags.addButton( 'samlab_shform', '[samlab_callback_form]', '[samlab_callback_form]', '[samlab_callback_form]', '', 'callback form', 1007 );
      }
    </script>
<?php endif;
}


/**
 * Starts the plugin.
 *
 */
function samlab_сallback_settings() {
    
	$plugin = new Submenuсallback( new Submenu_Page_сallback() );
	$plugin->init();
    
    add_action( 'admin_init', 'samlab_сallback_settings_init' );
    //ajax запрос для удаления вешаем на хукsamlab_сallback_dellrecord
    add_action('wp_ajax_samlabdellrecord', 'samlab_сallback_dellrecord');
    
    add_action('wp_ajax_samlabgettable', 'samlab_сallback_gettable');
    
    add_action('admin_print_footer_scripts', 'samlab_сallback_addjavascript', 99);
    
    //add widget to admin
    $option = get_option( 'callback-settings' );
    if($option['adminwidget'] == '1'){
        add_action( 'wp_dashboard_setup', 'samlab_сallback_adddashboardwidgets' );
    }
    add_action( 'admin_print_footer_scripts', 'samlab_сallback_addquicktags' );
    
}
//////

## Произвольный виджет в консоли в админ-панели
function samlab_сallback_dashhelp() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'callback';
    $posts = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY id DESC LIMIT 0,20");
    echo '<div style="width:100%;overflow:hidden;"><div style="height:200px;width:103%;overflow-y:scroll;">';
    echo '<table width="100%"><tr><td><b>'. __("Date", "callback-settings") .'</b></td><td><b>'. __("Name\Email", "callback-settings") .'</b></td><td><b>'. __("Message", "callback-settings") .'</b></td></tr>';
        foreach($posts as $res){
            echo '<tr><td valign="top" style="width: 25%; background-color: #f0f0f0; padding: 8px;"><b>'. $res->date . '</b></td> <td valign="top"  style="width: 25%; background-color: #f0f0f0; padding: 8px;"><b>' . $res->name . '</b></td> <td valign="top"  style="width: 25%; background-color: #f0f0f0; padding: 8px;"><b>' . $res->content . '</b></td></tr>';
        }
    echo '</table>'; 
    echo '</div></div>';
    
}

function samlab_сallback_adddashboardwidgets() {
    wp_add_dashboard_widget( 'custom_help_widget', 
        __("Сallback", "callback-settings"), 
        'samlab_сallback_dashhelp' );

    // Globalize the metaboxes array, this holds all the widgets for wp-admin    
    global $wp_meta_boxes;

    // Get the regular dashboard widgets array 
    // (which has our new widget already but at the end)    
    $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    // Backup and delete our new dashbaord widget from the end of the array    
    $example_widget_backup = array( 'example_dashboard_widget' => 
        $normal_dashboard['example_dashboard_widget'] );
    unset( $normal_dashboard['example_dashboard_widget'] );

    // Merge the two arrays together so our widget is at the beginning   
    $sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );

    // Save the sorted array back into the original metaboxes     
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 









//////////////
function samlab_сallback_getform(){
    global $wpdb;
$option = get_option( 'callback-settings' );

$tempform .= '<div>';
$tempform .= '    <div class="form-group">';

    $tempform .= '        <label class="control-label">'. $option['namerow'] .'</label>';
    $tempform .= '        <input autofocus type="text" id="input-name" placeholder="'. $option['namerow'] .'" class="form-control">';

if($option['emailcheck'] == "1"){
    $tempform .= '        <label class="control-label">'. $option['emailtext'] .'</label>';
    $tempform .= '        <input autofocus type="text" id="input-email" placeholder="'. $option['emailtext'] .'" class="form-control">';
}
if($option['messagecheck'] == "1"){
    $tempform .= '        <label class="control-label">'. $option['messagetext'] .'</label>';
    $tempform .= '        <textarea id="input-message" class="form-control" rows="5"></textarea>';
}
$tempform .= '    </div>';

if(isset($option['agreementstext'])){
    $tempform .= '    <p class="text">';
    $tempform .=  $option['agreementstext'];
    $tempform .= '    </p>';
}

$tempform .= '</div>';


    
    
    echo $tempform;
    wp_die();
}


function samlab_сallback_dellrecord() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'callback';
    
    $delrecord = sanitize_text_field( $_POST['id'] );
    
    $id = esc_attr($delrecord);
    $wpdb->delete( $table_name, array( 'id' => $id ) );
    echo __("Record delited","callback-settings");   
    wp_die();
}


function samlab_сallback_gettable(){
    header("Content-Type: application/json");
    //@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'callback';
    $posts = $wpdb->get_results("SELECT * FROM " . $table_name . " ORDER BY id DESC");
    
    if($posts){
        foreach($posts as $res){
          $nestedData = array();
          $nestedData[] = $res->date;
          $nestedData[] = $res->name;
          $nestedData[] = $res->content;
          $nestedData[] = '<span onclick="samlab_сallback_dellrecord('.$res->id.')" class="glyphicon glyphicon-trash"></span>';
          $data[] = $nestedData;
        }
        
        $json_data = array(
            "data" => $data
        );
        echo(json_encode($json_data));
    }else{
        $nestedData = array();
        $nestedData[] = '';
        $nestedData[] = '';
        $nestedData[] = __( 'No records yet', 'callback-settings' );
        $nestedData[] = '';
        $data_false[] = $nestedData;
        
        $json_data_false = array(
            "data" => $data_false
        );
        echo(json_encode($json_data_false));
    }
    
    wp_die();
}



function samlab_сallback_postmessage(){
    global $wpdb;
    $option = get_option( 'callback-settings' );
    
    $post_name = sanitize_text_field( $_POST['name'] );
    $post_email = sanitize_text_field( $_POST['email'] );
    $post_message = sanitize_text_field( $_POST['message'] );
    
    if( $post_name){
        $name = $post_name;
    }else{$name = '';}
    
    if( $post_email){
        $email = $post_email;
    }else{$email = '';}
    
    if( $post_message){
        $message = $post_message;
    }else{$message = '';}
    
    //записываем в базу
    $date = date('Y-m-d H:i:s');
    $table_name = $wpdb->prefix . 'callback';
    $data_wp = array(
        'date' => $date,
        'name' => $name.'<br/>'.$email,
        'content' => $message
    );
    
    $wpdb->insert($table_name, $data_wp);
    
    if($option['sendemails'] == "1" )  {
        
        $to = $option['emailtosend'];
        $subject = __( 'Callback from the site', 'callback-settings' );
           
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $template = '
<table class="container" style="box-sizing: border-box; font-family: Helvetica, serif; min-height: 150px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px; margin-top: auto; margin-right: auto; margin-bottom: auto; margin-left: auto; height: 0px; width: 90%; max-width: 550px;" width="90%" height="0">
        <tr style="box-sizing: border-box;">
          <td class="container-cell" style="box-sizing: border-box; vertical-align: top; font-size: medium; padding-bottom: 50px;" valign="top">
            <table class="card" style="box-sizing: border-box; min-height: 150px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px; margin-bottom: 20px; height: 0px;" height="0">
              <tr style="box-sizing: border-box;">
                <td class="card-cell" style="box-sizing: border-box; background-color: rgb(255, 255, 255); overflow-x: hidden; overflow-y: hidden; border-top-left-radius: 3px; border-top-right-radius: 3px; border-bottom-right-radius: 3px; border-bottom-left-radius: 3px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; text-align: center;" bgcolor="rgb(255, 255, 255)" align="center">
                  <table class="table100 c1357" style="box-sizing: border-box; width: 100%; min-height: 150px; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px; height: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border-collapse: collapse;" width="100%" height="0">
                    <tr style="box-sizing: border-box;">
                      <td class="card-content" style="box-sizing: border-box; font-size: 13px; line-height: 20px; color: rgb(111, 119, 125); padding-top: 10px; padding-right: 20px; padding-bottom: 0px; padding-left: 20px; vertical-align: top;" valign="top">
                        <h1 class="card-title" style="box-sizing: border-box; font-size: 25px; font-weight: 300; color: rgb(68, 68, 68);">'.$subject.' - '. $name .' '.$email.'
                          <br data-highlightable="1" style="box-sizing: border-box;">
                        </h1>
                        <p class="card-text" style="box-sizing: border-box;">'.$message.' </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
';


        //$message .= $name;
        //$message .= $email;
        $messages .= $template;
        $done = mail ($to, $subject, $messages, $headers);
    }
    
    //$poempmess .= 'Получили имя:'.$name.' email:'.$email.' сообщение: '.$message;
    //echo $poempmess;
    wp_die();
}



    

function samlab_сallback_addjavascript() {
    
    if(get_user_locale() == 'ru_RU'){
        $translate =  plugins_url(dirname( plugin_basename( __FILE__ ) ) .'/admin/assets/js/Russian.json');
    }else{
        $translate = plugins_url(dirname( plugin_basename( __FILE__ ) ) .'/admin/assets/js/English.json');
    }
    
    ?>
    
   
<script>
    loadd();
    
    function samlabgetforms(){
        var data = { action: 'samlabgetforms' };
        jQuery.post( ajaxurl, data, function(response) { });  
    }    
    
    
    function samlab_сallback_dellrecord(id){
            var data = {
    			action: 'samlabdellrecord',
    			id: id
    		};
                
    		jQuery.post( ajaxurl, data, function(response) {
                $.confirm({
                    title: "<?= __("Alert!","callback-settings") ?>",
                    content: response,
                    
                });
                $("#datastable").dataTable().fnDestroy();
                loadd();
    		});
           
    }
    
    function loadd(){
        jQuery('#datastable').DataTable( {
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
               "language": {
                        "url": "<?= $translate ?>"
                    },
               "columns": [
                { "width": "20%" },
                { "width": "20%" },
                { "width": "55%" },
                { "width": "5%" }
              ],
            "ajax": ajaxurl+'?action=samlabgettable'
        });
    }
        
	</script>
    
	<?php
}

//START samlab_callback
add_shortcode( 'samlab_callback_form', 'samlab_callback_form' ); 
function samlab_callback_form( $atts ) {
    
    $option = get_option( 'callback-settings' );
    if($option['usebootstrap'] == "1" )  {
        //if use bootstrap
        wp_register_style('bootstrap_style', plugin_dir_url(__FILE__) . '/public/bootstrap.min.css');
        wp_enqueue_style('bootstrap_style');
        //if not use bootstrap
    }elseif($option['usebootstrap'] == "0" ){
        wp_register_style('samlab_callback_style', plugin_dir_url(__FILE__) . '/public/samlab_style.css');
        wp_enqueue_style('samlab_callback_style');
        //
    }
    wp_register_script('jquery_popup', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.js', array('jquery'), true);
    wp_enqueue_script('jquery_popup');
    wp_register_style('jquery_popup_style', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.css');
    wp_enqueue_style('jquery_popup_style');
    
    $temp_scw .= '';

	return $temp_scw ;
	
}
//FINISH samlab_callback

//START samlab_callback
add_shortcode( 'samlab_callback', 'samlab_callback_widget' ); 
function samlab_callback_widget( $atts ) {
    
    $option = get_option( 'callback-settings' );
    if($option['usebootstrap'] == "1" )  {
        //if use bootstrap
        wp_register_style('bootstrap_style', plugin_dir_url(__FILE__) . '/public/bootstrap.min.css');
        wp_enqueue_style('bootstrap_style');
        //if not use bootstrap
    }elseif($option['usebootstrap'] == "0" ){
        wp_register_style('samlab_callback_style', plugin_dir_url(__FILE__) . '/public/samlab_style.css');
        wp_enqueue_style('samlab_callback_style');
        //
    }
    wp_register_script('jquery_popup', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.js', array('jquery'), true);
    wp_enqueue_script('jquery_popup');
    wp_register_style('jquery_popup_style', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.css');
    wp_enqueue_style('jquery_popup_style');
    
    $temp_scw .= '<a onclick="сallbackFunk()" class="сallback_link" style="cursor: pointer;">'. __( 'Call me back', 'callback-settings' ) .'</a>';

	return $temp_scw ;
	
}
//FINISH samlab_callback


//START samlab_callback button
add_shortcode( 'samlab_callback_button', 'samlab_callback_widget_button' ); 
function samlab_callback_widget_button( $atts ) {
    if($option['usebootstrap'] == "1" )  {
        //if use bootstrap
        wp_register_style('bootstrap_style', plugin_dir_url(__FILE__) . '/public/bootstrap.min.css');
        wp_enqueue_style('bootstrap_style');
        //if not use bootstrap
    }elseif($option['usebootstrap'] == "0" ){
        wp_register_style('samlab_callback_style', plugin_dir_url(__FILE__) . '/public/samlab_style.css');
        wp_enqueue_style('samlab_callback_style');
        //
    }
    wp_register_script('jquery_popup', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.js', array('jquery'), true);
    wp_enqueue_script('jquery_popup');
    wp_register_style('jquery_popup_style', plugin_dir_url(__FILE__) . '/public/jquery-confirm.min.css');
    wp_enqueue_style('jquery_popup_style');
    
    $temp_scwbutton .= '<button  onclick="сallbackFunk()" type="button" class="btn btn-primary btn-sm">'. __( 'Call me back', 'сallback-settings' ) .'</button>';         

	return $temp_scwbutton ;
	
}
//FINISH samlab_callback



function samlab_callback_scripts() {
    wp_register_script('samlab_callback_script', dirname( plugin_basename( __FILE__ ) ) . '/public/samlab_callback.js', array('jquery'),'1.1', true);
    wp_enqueue_script('samlab_callback_script');
} 

//add_action( 'the_content', 'samlab_callback_scripts', 999 ); 

