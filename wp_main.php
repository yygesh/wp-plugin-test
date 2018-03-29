<?php
/*
Plugin Name: mikesautoshack
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Basic WordPress Plugin Header Comment
Version:     1.0
Author:      WordPress.org
Author URI:  https://developer.wordpress.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

// ======= FORM REGISTER =====>

// function insert_user() {

//     // if the submit button is clicked, send the email
//     if ( isset( $_POST['submitted'] ) ) {

//         // sanitize form values
//         $firstName = sanitize_text_field( $_POST["first_name"] );
//         $lastName = sanitize_text_field( $_POST["last_name"] );
//         $email   = sanitize_email( $_POST["email"] );
//         $password = sanitize_text_field( $_POST["password"] );
//         $phone = sanitize_text_field($_POST['phone']);
//         $user_id = username_exists( $firstName );
// 		if ( !$user_id and email_exists($email) == false ) {
// 			$userdata = array(
// 				'user_email'=>$email,
// 				'user_pass'=>$password,
// 				'user_login'=> $firstName,
// 				'user_nicename'=>$firstName,
// 			    'first_name'  =>  $firstName
// 			);
// 			$user_id =wp_insert_user($userdata);
// 		}
// 		if($user_id)
// 		{
// 			$key=array('first_name','last_name','phone');
// 			$value= array($firstName, $lastName , $phone);
// 			add_user_meta( $user_id, $key, $value);

// 		}
		
        
//     }
// }
// function get_form_register() {
  
//   if (!is_user_logged_in()) :
//     $return .= '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
//     $return .= '<p>';
//     $return .= 'First Name (required) <br/>';
//     $return .= '<input type="text" name="first_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["first_name"] ) ? esc_attr( $_POST["first_name"] ) : '' ) . '"  /><br/>';
//     $return .= 'Last Name (required) <br/>';
//     $return .= '<input type="text" name="last_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["last_name"] ) ? esc_attr( $_POST["last_name"] ) : '' ) . '"  /> <br/>';
//     $return .= '</p>';
//     $return .= 'Phone  <br/>';
//     $return .= '<input type="text" name="phone" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["last_name"] ) ? esc_attr( $_POST["phone"] ) : '' ) . '" />';
//     $return .= '</p>';
//     $return .= '<p>';
//     $return .= 'Your Email (required) <br/>';
//     $return .= '<input type="email" name="email" value="' . ( isset( $_POST["email"] ) ? esc_attr( $_POST["email"] ) : '' ) . '"  />';
//     $return .= '</p>';
//     $return .= 'Password (required) <br/>';
//     $return .= '<input type="password" name="password" id="password" class="regular-text" autocomplete="off" data-reveal="1" value="' . ( isset( $_POST["password"] ) ? esc_attr( $_POST["password"] ) : '' ) . '"  aria-describedby="pass-strength-result" />';
//     $return .= '<p><input type="submit" name="submitted" value="Send"></p>';
//     $return .= '</form>';
//   else : 
//     echo $return = __('User is logged in.','tiny_login');
//   endif;
//   echo $return;
// }


// function cf_shortcode() {
//      ob_start();
//      insert_user();
//      get_form_register();
//     return ob_get_clean();
// }

// add_shortcode( 'login_register_form', 'cf_shortcode' );

function insert_user( $atts, $content = null){
  
  if(defined('REGISTRATION_ERROR'))
  {
    foreach(unserialize(REGISTRATION_ERROR) as $error)
    {
      echo "<div class=\"error\">{$error}</div>";
    }
  }
  elseif(defined('REGISTRATION_SUCCESS'))
  {
    foreach(unserialize(REGISTRATION_SUCCESS) as $success)
    {
      echo "<div class=\"Message\">{$success}</div>";
    }
  }
  $atts= shortcode_atts(
    array(
      'title' => 'Currnet job openings in ...',
      'type'=>'',
      'name'=>'',
      'class'=>'',
      'label'=>'',
      'value'=>''
      ), $atts
    );

    $displaylist='<form action="' .add_query_arg('do', 'register', home_url('/login')). '" method="post">';
     # code...
     // var_dump($atts['type']);
      $displaylist .= '<label>'.$atts['label'].'</label><br/>';
      $displaylist .= '<input type="'.$atts['type'].'" name="'.$atts['name'].'" class="'.$atts['class'].'" value="'.$atts['value'].'" /><br/>';
      
  return $displaylist;
}


add_shortcode('login_register_form', 'insert_user');

// Register a new shortcode: [cr_custom_registration]
//add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
 
// The callback function that will replace [book]
// function custom_registration_shortcode() {
//     ob_start();
//     //custom_registration_function();
//     return insert_user($atts, $content = null);
//     return ob_get_clean();
// }
 function custom_registration_function() {

    // if the submit button is clicked, send the email
    if ( isset( $_POST) ) {

      global $reg_errors;
      $reg_errors = new WP_Error;

      if ( empty( $_POST['user_login'] ) || empty( $_POST['user_pass'] ) || empty( $_POST['user_email'] ) ) {
        $reg_errors->add('field', 'Required form field is missing');
      }
      if ( username_exists( $_POST['user_login'] ) ){
        $reg_errors->add('user_name', 'Sorry, that username already exists!');
      }
      if ( !is_email( $_POST['user_email'] ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
      }
      if ( email_exists( $_POST['user_email'] ) ) {
        $reg_errors->add( 'user_email', 'Email Already in use' );
      }

      if ( is_wp_error( $reg_errors ) ) {
 
      foreach ( $reg_errors->get_error_messages() as $error ) {
       
          echo '<div>';
          echo '<strong>ERROR</strong>:';
          echo $error . '<br/>';
          echo '</div>';
           
      }}

      // // sanitize form values
      // $firstName = sanitize_text_field( $_POST["first_name"] );
      // $lastName = sanitize_text_field( $_POST["last_name"] );
      // $email   = sanitize_email( $_POST["email"] );
      // $password = sanitize_text_field( $_POST["password"] );
      // $phone = sanitize_text_field($_POST['phone']);

      if ( 1 > count( $reg_errors->get_error_messages() ) ) {
      $userdata = array(
      'user_login'    =>   $_POST['user_login'],
      'user_email'    =>   $_POST['user_email'],
      'user_pass'     =>   $_POST['user_pass'],
      'first_name'    =>   $_POST['first_name'],
      'last_name'     =>   $_POST['last_name'],
      'phone'         =>   $_POST['phone']
      );
      $user_id= wp_insert_user($userdata);
      if($user_id && $_POST['phone'])
      {
        add_user_meta( $user_id, 'phone',$_POST['phone']);
      }
      return 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
   
  }
}
add_action('template_redirect', 'register_a_user');
function register_a_user(){
  if(isset($_GET['do']) && $_GET['do'] == 'register'):
    //var_dump($_POST);
    $errors = array();
    if ( empty( $_POST['user_login'] ) || empty( $_POST['user_pass'] ) || empty( $_POST['user_email'] ) ) {
        return $errors[] ='Required form field is missing';
      }
      if ( username_exists( $_POST['user_login'] ) ){
       return $errors[] ='Sorry, that username already exists!';
      }
      if ( !is_email( $_POST['user_email'] ) ) {
       return $errors[] ='Email is not valid' ;
      }
      if ( email_exists( $_POST['user_email'] ) ) {
       return $errors[] ='Email Already in use' ;
      }
// var_dump($errors);
    if(empty($errors)):
      $userdata = array(
      'user_login'    =>   $_POST['user_login'],
      'user_email'    =>   $_POST['user_email'],
      'user_pass'     =>   $_POST['user_pass'],
      'first_name'    =>   $_POST['first_name'],
      'last_name'     =>   $_POST['last_name'],
      'phone'         =>   $_POST['phone']
      );
      $user_id= wp_insert_user($userdata);
      if($user_id && $_POST['phone'])
      {
        add_user_meta( $user_id, 'phone',$_POST['phone']);
      }
    endif;
    return 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
  endif;
}