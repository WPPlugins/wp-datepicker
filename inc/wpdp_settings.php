<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	if ( !current_user_can( 'update_core' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'wp-dp' ) );
	}
// Save the field values
	if ( isset( $_POST['wpdp_fields_submitted'] ) && $_POST['wpdp_fields_submitted'] == 'submitted' ) {
			
			if($wpdp_pro){
				foreach ( $_POST as $key => $value ) {		
					if(is_array($value)){
						$value = array_map( 'esc_attr', $value );
						//pree($value);
						update_option( sanitize_text_field($key), ($value) );
					}else{
						if ( get_option( $key ) != $value ) {
							update_option( sanitize_text_field($key), sanitize_text_field($value) );
						} else {
							add_option( sanitize_text_field($key), sanitize_text_field($value), '', 'no' );
						}
					}
				}
			}else{
			
				update_option( 'wp_datepicker', sanitize_text_field($_POST['wp_datepicker']));
				update_option( 'wp_datepicker_language', sanitize_text_field($_POST['wp_datepicker_language']));
				update_option( 'wp_datepicker_readonly', sanitize_text_field($_POST['wp_datepicker_readonly']));
			}
			
		
		
		
	}
	$wpdp_selectors = get_option( 'wp_datepicker');
	
	$wp_datepicker_language = wpdp_slashes(get_option( 'wp_datepicker_language'));
	
	$wpdb_string = wpdp_slashes($wpdp_selectors);
	
	$wpdb_arr = explode(',', $wpdb_string);
	
	$wpdb_arr = array_filter($wpdb_arr, 'strlen');
	
	if(empty($wpdb_arr)){
		$wpdb_arr = array('.datepicker');
	}
	
	$attrib = array('type'); //array('accept', 'align', 'right', 'top', 'middle', 'bottom', 'alt ', 'autocomplete ', 'autofocus', 'checked', 'disabled', 'max', 'maxlength', 'min', 'multiple', 'name', 'pattern', 'placeholder', 'readonly', 'required', 'size', 'src', 'step', 'type', 'value', 'width');
	$inputs = array(
		'class' => array('symbol' => '.',),
		'id' => array('symbol' => '#',),
		'input' => array(
			'symbol' => 'input',
			'type' => array(
			'button', 'checkboxcolor', 'date', 'datetime', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'text', 'time', 'url', 'week')
			),
		'textarea' => array('symbol' => 'textarea',),
		'select' => array('symbol' => 'select',),		
	);

	
	
?>	
<div class="wrap wpdp">

<?php if(!$wpdp_pro): ?>
<a title="Click here to download pro version" style="background-color: #25bcf0;    color: #fff !important;    padding: 2px 30px;    cursor: pointer;    text-decoration: none;    font-weight: bold;    right: 0;    position: absolute;    top: 0;    box-shadow: 1px 1px #ddd;" href="http://shop.androidbubbles.com/download/" target="_blank">Already a Pro Member?</a>
<?php endif; ?>
	
    
  <div class="head_area">
	<h2><?php _e( '<span class="dashicons dashicons-welcome-widgets-menus"></span>WP Datepicker '.'('.$wpdp_data['Version'].($wpdp_pro?') Pro':')'), 'wp-dp' ); ?> - Settings</h2>
    
    
    </div>
<form method="post" action="">  
<input type="hidden" name="wpdp_fields_submitted" value="submitted" />
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-dp' ); ?>" /></p> 
<div class="wpdp_settings">

<?php 
	if(!empty($wpdb_arr)){
?>
		<div class="wpdp_cg">
		<h3>Code Generator: <small>(Optional)</small></h3>
<?php        		
		foreach($wpdb_arr as $vals){
			$label = '';
			$type = substr($vals, 0, 1);
			$type_d = '';
			switch($type){
				case "#":
					$label = $type_d = 'id';
				break;	
				case ".":
					$label = $type_d = 'class';
				break;	
				case "i":
				case "s":
				case "t":
					$type_d = explode('[', $vals);
					$label = current($type_d);
				break;	
			}
?>

        <?php if(!empty($inputs)): ?>
        <div class="wpdp_demo_div">
		<select name="wpdp_sel[]" style="width:200px;">
        <?php foreach($inputs as $tag_type => $input): ?>
        	<option style="background-color:#CCC; font-weight:bold;" data-tag="<?php echo $tag_type; ?>" data-type="<?php echo $inputs[$tag_type]['symbol']; ?>" value=""><?php echo $tag_type; ?></option>
            <?php if(!empty($attrib)): ?>
            <?php foreach($attrib as $attr): ?>
            
            <?php if(!empty($input) && isset($input[$attr])): ?>
            <option style="padding-left:20px;" data-type="<?php echo $attr; ?>" value="<?php echo $attr; ?>" <?php selected( $type, $attr ); ?>><?php echo $attr; ?></option>            
            <?php foreach($input as $t => $t_array): ?>
            <?php if(!empty($t_array)): ?>
            <?php foreach($t_array as $tag_elem): ?>
            	<option style="padding-left:40px;" data-tag="<?php echo $tag_type; ?>" data-type="<?php echo $t; ?>" value="<?php echo $tag_elem; ?>" <?php selected( $type, $tag_elem ); ?>><?php echo $tag_elem; ?></option>
            <?php endforeach; ?>	
        	<?php endif; ?>   
            <?php endforeach; ?>	
        	<?php endif; ?>    
            
         	<?php endforeach; ?>	
        	<?php endif; ?>               
        <?php endforeach; ?>
        </select>
        <?php endif; ?>
        <input name="wpdp_demo_str[]" class="" placeholder="" type="text" value="" />
		<input name="wpdp_demo_output[]" type="text" value="<?php echo $vals; ?>" style="width:300px" /><small>Insert the output text below and glue with comma for next.</small>
        </div>
<?php			
		}
?><br />
Video Tutorial:<br />
<iframe width="200" height="120" src="https://www.youtube.com/embed/eILaObbYucU" frameborder="0" allowfullscreen></iframe>
</div>
<?php 		
	}

?>

<?php
global $wpdp_dir;

?>

<select name="wp_datepicker_language" class="wpdp_selectors">
<option>Select Language</option>
<?php
foreach (glob($wpdp_dir."js/i18n/*.js") as $filename) {
    $content = file_get_contents($filename);
	$lines = nl2br($content);
	$lines = explode('<br>', $lines);
	$line = explode(' ', $lines[0]);
	$title = $line[1];
	
	$code = str_replace(array('datepicker-', '.js'), '', basename($filename));
	$val = $code.'|'.basename($filename);
?>
	<option value="<?php echo $val; ?>" <?php echo ($wp_datepicker_language==$val?'selected="selected"':''); ?>><?php echo $code.' ('.$title.')'; ?></option>
<?php	
}
?>
</select>		
<input type="text" width="100%" value="<?php echo wpdp_slashes($wpdp_selectors); ?>" class="wpdp_selectors" name="wp_datepicker" placeholder="Enter id, class, name based and/or type based CSS selector" /><br />
<small>
You can enter multiple selectors as CSV (Comma Separated Values).<br />

e.g. <br />
<span class="wpdp_1">#datepicker</span><br />
or<br />
<span class="wpdp_2">#datepicker, .hasDatepicker, .date-field</span><br />
and<br />
<span class="wpdp_3">Sample HTML: &lt;input type=&quot;text&quot; id=&quot;datepicker&quot; /&gt;</span>
</small>


<?php if($wpdp_pro){ wpdp_pro_settings(); } ?>


<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-dp' ); ?>" /></p>
</div>
</form>
</div>
<style type="text/css">
.update-nag, #message{ display:none; }
</style>