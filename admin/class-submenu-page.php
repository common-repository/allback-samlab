<?php
/**
 * Creates the submenu page for the plugin.
 *
 * @package сallback-samlab
 */

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package сallback-samlab
 */
class Submenu_Page_сallback {

	/**
	 * This function renders the contents of the page associated with the Submenu
	 * that invokes the render method. In the context of this plugin, this is the
	 * Submenu class.
	 */
     
public function prepare_form(){
?><form method="post" action="options.php">
<?php 
    settings_fields( 'mod-settings-sektion' ); 
    do_settings_sections( 'callback-settings' );  
}    
     
     
	public function render() {


global $select_options; if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
if ( false !== $_REQUEST['settings-updated'] ) : 
$temp .='
<div id="message" class="updated">
<p><strong>'. __("Settings have been saved", "callback-settings") .'</strong></p>
</div>   
';        
endif;   


$temp .= $this->prepare_form();
$option = get_option( 'callback-settings' );
//
if($option['usebootstrap'] == "1" )  { 
    $prepare_bootstrap = '
    <input id="publish" type="hidden" name="callback-settings[usebootstrap]" value="1">
    <input id="check" type="checkbox" value="1" checked="checked"/>
    '; 
}else{
    $prepare_bootstrap = '
    <input id="publish" type="hidden" name="callback-settings[usebootstrap]" value="0">
    <input id="check" type="checkbox" value="0"/>
    ';
} 


if($option['adminwidget'] == "1" )  { 
    $prepare_adminwidget = '
    <input  id="publish_name" type="hidden" name="callback-settings[adminwidget]" value="1">
    <input id="check_name" type="checkbox" value="1" checked="checked"/>
    '; 
}else{
    $prepare_adminwidget = '
    <input id="publish_name" type="hidden" name="callback-settings[adminwidget]" value="0">
    <input id="check_name" type="checkbox" value="0"/>
    ';
} 

if($option['emailcheck'] == "1" )  { 
    $prepare_emailcheck = '
    <input  id="publish_email" type="hidden" name="callback-settings[emailcheck]" value="1">
    <input id="check_email" type="checkbox" value="1" checked="checked"/>
    '; 
}else{
    $prepare_emailcheck = '
    <input id="publish_email" type="hidden" name="callback-settings[emailcheck]" value="0">
    <input id="check_email" type="checkbox" value="0"/>
    ';
} 

if($option['messagecheck'] == "1" )  { 
    $prepare_messagecheck = '
    <input  id="publish_message" type="hidden" name="callback-settings[messagecheck]" value="1">
    <input id="check_message" type="checkbox" value="1" checked="checked"/>
    '; 
}else{
    $prepare_messagecheck = '
    <input id="publish_message" type="hidden" name="callback-settings[messagecheck]" value="0">
    <input id="check_message" type="checkbox" value="0"/>
    ';
} 
//$prepare_sendemails
if($option['sendemails'] == "1" )  { 
    $prepare_sendemails = '
    <input  id="publish_sendemails" type="hidden" name="callback-settings[sendemails]" value="0">
    <input id="check_sendemails" type="checkbox" value="1" checked="checked"/>
    '; 
}else{
    $prepare_sendemails = '
    <input id="publish_sendemails" type="hidden" name="callback-settings[sendemails]" value="1">
    <input id="check_sendemails" type="checkbox" value="0"/>
    ';
} 

//var_dump($option) ;    

 
        $temp .='
        
<script src="'. plugin_dir_url( __FILE__ ) . 'assets/js/jquery-1.12.4.min.js"></script>
<script src="'. plugin_dir_url( __FILE__ ) . 'assets/js/jquery.tabs.min.js"></script>

';


$temp .='<div class="jq-tab-header">
    <div class="jq-tab-logo">
    <h2>'. __( 'Samlab', 'callback-settings' ) .'<?h2>
    </div>
    <div class="jq-tab-namemod">
    <strong>'. __("Сallback","callback-settings") .'</strong><br><a href="http://vseprosto.top/" target="_blank">'. __("Plugin page","сallback-settings") .'</a>
    </div>
</div>
       
<div class="jq-tab-wrapper" id="verticalTab">

    <div class="jq-tab-menu">
        <div class="jq-tab-title active" data-tab="1">'. __("General", "callback-settings") .'</div>
        <div class="jq-tab-title" data-tab="2">'. __("Settings","callback-settings") .'</div>
        <div class="jq-tab-title" data-tab="3">'. __("Help","callback-settings") .'</div>
        
        <div id="clicks" class="jq-tab-title" data-tab="info"></div>
    </div>
    <div class="jq-tab-content-wrapper">
        <div class="jq-tab-content active" data-tab="1">
            <table id="datastable" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>'. __( 'Date', 'callback-settings' ) .'</th>
                        <th>'. __( 'Name', 'callback-settings' ) .'</th>
                        <th>'. __( 'Content', 'callback-settings' ) .'</th>
                        <th><span class="glyphicon glyphicon-trash"></span></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>'. __( 'Date', 'callback-settings' ) .'</th>
                        <th>'. __( 'Name', 'callback-settings' ) .'</th>
                        <th>'. __( 'Content', 'callback-settings' ) .'</th>
                        <th><span class="glyphicon glyphicon-trash"></span></th>
                    </tr>
                </tfoot>
            </table>              
        </div>
        
 
       
        <div class="jq-tab-content" data-tab="2">
          <strong>'. __( 'Module settings', 'callback-settings' ) .'</strong><br />  


            <table class="form-table">
                    <tr valign="top">
                    	<td scope="row">'. __( 'Title Сallback', 'callback-settings' ) .'</td>
                    	<td><input type="text" name="callback-settings[name]" value="'.$option['name'].'" placeholder="'. __( 'Title Сallback', 'callback-settings' ) .'"/></td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'Use bootstrap', 'callback-settings' ) .'</td>
                    	<td>
                        '. $prepare_bootstrap .'
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'Name', 'callback-settings' ) .'</td>
                        </td><td><input type="text" name="callback-settings[namerow]" value="'.$option['namerow'].'" placeholder="'. __( 'Your Name', 'callback-settings' ) .'"/></td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'E-mail', 'callback-settings' ) .'</td>
                    	<td>'. $prepare_emailcheck .'<input type="text" name="callback-settings[emailtext]" value="'.$option['emailtext'].'" placeholder="'. __( 'Your E-mail', 'callback-settings' ) .'"/></td>
                        </td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'Message', 'callback-settings' ) .'</td>
                    	<td>'. $prepare_messagecheck .'<input type="text" name="callback-settings[messagetext]" value="'.$option['messagetext'].'" placeholder="'. __( 'Your Message', 'callback-settings' ) .'"/></td>
                        </td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'The signature at the bottom of the form', 'callback-settings' ) .'</td>
                        </td><td>
                        <textarea style="width: 100%;" name="callback-settings[agreementstext]" rows="5">'.$option['agreementstext'].'</textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'Thank you after sending', 'callback-settings' ) .'</td>
                        </td><td>
                        <textarea style="width: 100%;" name="callback-settings[thankstext]" rows="5">'.$option['thankstext'].'</textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                    	<td scope="row">'. __( 'Use admin widget', 'callback-settings' ) .'</td>
                    	<td>
                        '. $prepare_adminwidget .'
                    </tr>
                    
                    <tr valign="top">
                    	<td scope="row">'. __( 'E-mail', 'callback-settings' ) .'</td>
                    	<td>'. $prepare_sendemails .'<input type="text" name="callback-settings[emailtosend]" value="'.$option['emailtosend'].'" placeholder="'. __( 'E-mail recipient', 'callback-settings' ) .'"/></td>
                        </td>
                    </tr>
                    
                </table>


            <hr />
            
            <br/>
            <!--'. __( 'Text Description', 'callback-settings' ) .'-->
        </div>
        <div class="jq-tab-content" data-tab="3">
        Help:<br/>
<pre><code>'. __( 'Shortcode to add to pages', 'callback-settings' ) .' 
'. __( 'For reference', 'callback-settings' ) .'
    <b class="bcolorred">[samlab_callback]</b>
'. __( 'For button', 'callback-settings' ) .'
    <b class="bcolorred">[samlab_callback_button]</b>
'. __( 'Code for the implementation of the template', 'callback-settings' ) .'

'. __( 'For reference', 'callback-settings' ) .'
    <b class="bcolorred">&lt;?php echo do_shortcode( &#39;[samlab_callback]&#39; ); ?&gt;</b>
'. __( 'For button', 'callback-settings' ) .'
    <b class="bcolorred">&lt;?php echo do_shortcode( &#39;[samlab_callback_button]&#39; ); ?&gt;</b>

'. __( 'If you want to insert a form into an post', 'callback-settings' ) .'
<b class="bcolorred">
&lt;form id=&quot;sbmit1&quot; method=&quot;POST&quot; action=&quot;javascript:void(null);&quot; onsubmit=&quot;callme()&quot;&gt;<br/>    &lt;div class=&quot;form-group&quot;&gt;<br/>        &lt;label class=&quot;control-label&quot;&gt;namerow&lt;/label&gt; <br/>        &lt;input class=&quot;form-control&quot; name=&quot;name&quot; type=&quot;text&quot; autofocus=&quot;&quot; placeholder=&quot;namerow&quot; required /&gt;<br/>    &lt;/div&gt;<br/>    &lt;div class=&quot;form-group&quot;&gt;<br/>        &lt;label class=&quot;control-label&quot;&gt;email&lt;/label&gt; <br/>        &lt;input class=&quot;form-control&quot; name=&quot;email&quot; type=&quot;text&quot; autofocus=&quot;&quot; placeholder=&quot;email&quot; required /&gt;<br/>    &lt;/div&gt;<br/>    &lt;div class=&quot;form-group&quot;&gt;<br/>        &lt;label class=&quot;control-label&quot;&gt;messagetext&lt;/label&gt;<br/>        &lt;textarea class=&quot;form-control&quot; name=&quot;message&quot; rows=&quot;5&quot; required &gt;&lt;/textarea&gt;<br/>    &lt;/div&gt;<br/>        &lt;button value=&quot;sbmit1&quot; class=&quot;btn btn-primary btn-sm&quot; type=&quot;submit&quot;&gt;Send&lt;/button&gt;<br/>&lt;/form&gt;
</b>
'. __( 'or', 'callback-settings' ) .'
<b class="bcolorred">
&lt;form id=&quot;sbmit2&quot; method=&quot;POST&quot; action=&quot;javascript:void(null);&quot; onsubmit=&quot;callme()&quot;&gt;<br/>    &lt;div class=&quot;form-group&quot;&gt;<br/>        &lt;label class=&quot;control-label&quot;&gt;namerow&lt;/label&gt; <br/>        &lt;input id=&quot;names&quot; class=&quot;form-control&quot; name=&quot;name&quot; type=&quot;text&quot; autofocus=&quot;&quot; placeholder=&quot;namerow&quot; required /&gt;<br/>    &lt;/div&gt;<br/>    &lt;div class=&quot;form-group&quot;&gt;<br/>        &lt;label class=&quot;control-label&quot;&gt;email&lt;/label&gt; <br/>        &lt;input class=&quot;form-control&quot; name=&quot;email&quot; type=&quot;text&quot; autofocus=&quot;&quot; placeholder=&quot;email&quot; required /&gt;<br/>    &lt;/div&gt;  <br/>    &lt;button value=&quot;sbmit2&quot; class=&quot;btn btn-primary btn-sm&quot; type=&quot;submit&quot;&gt;Send&lt;/button&gt;<br/>&lt;/form&gt;
</b>
'. __( 'And add shortcode for scripts [samlab_callback_form]', 'callback-settings' ) .'
</code>



</pre>



        </div>
        
        
        
        <div class="jq-tab-content" data-tab="info">
            '. __( 'FAQ', 'callback-settings' ) .' 
        </div>
    </div>
</div>


<div class="jq-tab-footer">
    <div class="jq-tab-logo">
        <ul class="to-social-list">
			<li><a href="https://vseprosto.top/"  target="_blank" class="to-social-list-envato" title="'. __( 'Homepage', 'callback-settings' ) .'"></a></li>
			<li><a href="https://www.facebook.com/mefreelance/" target="_blank" class="to-social-list-facebook" title="'. __( 'Facebook', 'callback-settings' ) .'"></a></li>
            <li><a id="fack" class="to-social-list-info" title="Info"></a></li>
        </ul>
    </div>
    <div class="jq-tab-button">
    
    <input class="to-button" type="submit" value="'. __("Save","callback-settings") .'" name="submit" id="submit">
    
    </div>
</div>
</form>


'. $this->show_script_сallback() .'
<script>

$("#check").on("change", function(){
	$("#publish").val(this.checked ? 1 : 0);
});
$("#check_name").on("change", function(){
	$("#publish_name").val(this.checked ? 1 : 0);
});
$("#check_email").on("change", function(){
	$("#publish_email").val(this.checked ? 1 : 0);
});
$("#check_message").on("change", function(){
	$("#publish_message").val(this.checked ? 1 : 0);
});

$("#check_sendemails").on("change", function(){
	$("#publish_sendemails").val(this.checked ? 1 : 0);
});

$(function () {
$("#verticalTab").jqTabs();
$("#fack").click(function() {
  $("#clicks").trigger("click");
});
$("#horizontalTab").jqTabs({direction: "horizontal", duration: 200});
});
</script>
        ';
        
        
        echo $temp;
	}
    
    
    
    
    
    
public function show_script_сallback (){
     
    wp_register_script('datatables', plugin_dir_url(__FILE__) . '/assets/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_script('datatables');
      
    wp_register_script('datatables_bootstrap', plugin_dir_url(__FILE__) . '/assets/js/dataTables.bootstrap.min.js', array('jquery'), true);
    wp_enqueue_script('datatables_bootstrap');
    wp_register_style('bootstrap_style', plugin_dir_url(__FILE__) . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap_style');
    
    wp_register_script('jquery_popup', plugin_dir_url(__FILE__) . '/assets/js/jquery-confirm.min.js', array('jquery'), true);
    wp_enqueue_script('jquery_popup');
    wp_register_style('jquery_popup_style', plugin_dir_url(__FILE__) . '/assets/css/jquery-confirm.min.css');
    wp_enqueue_style('jquery_popup_style');
      
    wp_register_style('datatables_style', plugin_dir_url(__FILE__) . '/assets/css/dataTables.bootstrap.min.css');
    wp_enqueue_style('datatables_style');
    
    return $temp;

} 
    
   
        
    
    
    
}
