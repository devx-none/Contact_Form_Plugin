<?php
/*
Plugin Name: Contact Form Plus 
Description: Contact Form Plus plugin
Author: elmahdi rammach
Text Domain: Contact-Form-Plus
Version: 0.1
*/
wp_register_style('namespace', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

add_action('admin_menu', 'contact_form_page');
add_action('wp_enqueue_scripts','load_assets');


function contact_form_page(){
    add_menu_page( 'Contact From Plus', 'Contact From Plus', 'manage_options', 'contact-form', 'contact_form_html','dashicons-media-text',8 );
    add_submenu_page( 'contact-form','Data Mail','Data Mail', 'manage_options','data-form','dataMail');
}

 function dataMail(){
  wp_enqueue_style('namespace'); 

  $result = getDataContact();
  ?>
  <table class="table" style="width: 600px;margin-left:300px;">
  <thead class="thead-dark bg-primary text-white">
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Subject</th>
      <th scope="col">Message</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($result as $row){?>
    <tr>
      <th><?php echo $row['id']?></th>
      <td><?php echo $row['name']?></td>
      <td><?php echo $row['email']?></td>
      <td><?php echo $row['subject']?></td>
      <td><?php echo $row['message']?></td>
    </tr>
   <?php } ?>
  </tbody>
</table>

 
  <?php
}

function load_assets(){
//     wp_enqueue_style('contact-form-plus',
//     plugin_url(__FILE__).'/css/contact-form-plus.css',
//     array(),
//     1,
//     'all'
// );
// wp_enqueue_script(
//     'contact-form-plus',
//     plugin_url( __FILE__ ).'/js/contact-form-plus.js',
//     array('jquery'),
//     1,
//     true
// );
$js = plugins_url('/js/contact-form-plus.js', __FILE__);
$css = plugins_url('/css/contact-form-plus.css', __FILE__);

        wp_enqueue_script('plugin_script', $js, '', '', true);
        wp_enqueue_style('plugin_style', $css);
}
function contact_form_html(){
  wp_enqueue_style('namespace'); 

  ?>
  <h1 class=" mb-3">Contact Form</h1>
  
  <form method="post" action  >

   <div class="choices">
   
   <label class="" for="choices">Name</label>
    <input class="form-check-input" type="checkbox" name="name" value="" id="name">
    <label class="" for="choices">Email</label>
    <input class="form-check-input" type="checkbox" name="email" value="" id="email">
    <label class="" for="choices">Subject</label>
    <input class="form-check-input" type="checkbox" name="subject" value="" id="subject">
    <label class="" for="choices">Message</label>
    <input class="form-check-input" type="checkbox" name="message" value="" id="message">
  
   </div>
   <div class="contact_form_plus card border-primary bg-primary text-white">
    <div class="name" style="display: none"><br><label for="name">Name</label> <br> <input type="text" name="" value=""></div>
    <div class="email" style="display: none"><br><label for="email">Email</label> <br> <input type="email" name="" value=""></div>
    <div class="subject" style="display: none"><br> <label for="subject">Subject</label> <br> <input type="text" name="" value=""></div>
    <div class="message" style="display: none"><label for="message">Message</label> <br> <textarea name="" value=""></textarea></div>
   </div>
   <div class="m-1 bd-highlight d-inline-block" >
   <!-- <button type="button" class="btn btn-primary" name="save_contact">Save</button> -->
   <input type="submit" class="btn btn-primary" name="save_contact" value="save">
    </div>
   </form>
<script >
let name = document.querySelector('#name');
let email = document.querySelector('#email');
let subject = document.querySelector('#subject');
let message = document.querySelector('#message');

name.addEventListener('change',function(){
if(name.checked==true){
   document.querySelector('.name').style.display='block';
}else
if(!name.checked){
 document.querySelector('.name').style.display="none";
}
});

email.addEventListener('change',function(){
if(email.checked){
   document.querySelector('.email').style.display="block";
}else
if(!email.checked){
 document.querySelector('.email').style.display="none";
}
});

subject.addEventListener('change',function(){
if(subject.checked==true){
   document.querySelector('.subject').style.display="block";
}else
if(!subject.checked){
 document.querySelector('.subject').style.display="none";
}
});

message.addEventListener('change',function(){
if(message.checked){
   document.querySelector('.message').style.display="block";
}else
if(!message.checked){
 document.querySelector('.message').style.display="none";
}
});



</script>
  <?php
      echo '<div >shortcode : ' . '[contact_form]';

}

// create table fields
function createtable()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $tablename = 'contact_fields';
    $sql = "CREATE TABLE $wpdb->wordpress$tablename (
        id INT,
        name BOOLEAN,
        email BOOLEAN,
        subject BOOLEAN,
        message BOOLEAN
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    maybe_create_table($wpdb->base_prefix . $tablename, $sql);
}
//Create Table
function createDataTable()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $tablename = 'Contact_data';
    $sql = "CREATE TABLE $wpdb->wordpress$tablename (
         id INT AUTO_INCREMENT,
        name varchar(100) DEFAULT null,
        email varchar(100) DEFAULT null,
        subject varchar(100) DEFAULT null,
        message varchar(100) DEFAULT null,
        PRIMARY key(id)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    maybe_create_table($wpdb->wordpress . $tablename, $sql);
}

//insertion data
function insertData()
{
    global $wpdb;
    $wpdb->insert(
        'contact_fields',
        [
            'id' => 1,
            'name' => true,
            'email' => true,
            'subject' => true,
            'message' => true
        ]
    );
}
//get data
function getData()
{

    global $wpdb;
    $fields = $wpdb->get_row("SELECT * FROM contact_fields WHERE id = 1");
    return $fields;
}

// function updateFields(){
  if (isset($_POST['save_contact'])) {


    // $name = filter_var($_POST['name'], FILTER_VALIDATE_BOOLEAN);
    if(!isset($_POST['name'])){
      $name = false;
    }else{
      $name = true;
    }
    if(!isset($_POST['email'])){
      $email = false;
    }else{
      $email = true;
    }
    if(!isset($_POST['subject'])){
      $subject = false;
    }else{
      $subject = true;
    }
    if(!isset($_POST['message'])){
      $message = false;
    }else{
      $message = true;
    }
    // $email = filter_var($_POST['email'], FILTER_VALIDATE_BOOLEAN);
    // $subject = filter_var($_POST['subject'], FILTER_VALIDATE_BOOLEAN);
    // $message = filter_var($_POST['message'], FILTER_VALIDATE_BOOLEAN);
  
    global $wpdb;
    $wpdb->update(
        'contact_fields',
        [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ],
        ['id' => 1]
    );
  }

  function getDataContact()
{

    global $wpdb;
    $data = $wpdb->get_results("SELECT * FROM contact_data ", ARRAY_A);
    return $data;
}

  if(isset($_POST['send'])){
    $name = $_POST['name'] ? $_POST['name'] :null;
    $email = $_POST['email'] ? $_POST['email'] :null;
    $subject = isset($_POST['subject']) ? $_POST['subject'] :null;
    $message = isset($_POST['message']) ? $_POST['message'] :null;
    global $wpdb;
    $wpdb->insert(
        'contact_data',
        [ 
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]
    );
  }



function loadShortcode(){
 

    getData();


    echo '<form action="" method="post">';

    if (getData()->name) {
      echo '<div class="form-group">
      <p>Your Name (required)</p>
      <input type="text" placeholder="Name" required name="name">
      <br>
      
      ';
    }
    if(getData()->email) {
      echo ' <p>Your Email (required) </p>
      <input type="email" placeholder="Email " required name="email">';
    }
    if(getData()->subject){
      echo ' <p>Subject </p>
      <input type="text" placeholder="Subject" required name="subject">';
    }
    if(getData()->message){
     echo '<p>Message </p>
             <textarea placeholder="Message" required name="message"></textarea>';
    }
    echo '<input type="submit" name="send" value="Send">';
    echo '</div>';
    echo '</form>';
}
function shortcode()
{
    ob_start();
    loadShortcode();

    return ob_get_clean();
}
add_shortcode('contact_form','shortcode');

register_activation_hook(__FILE__, 'createDataTable');
register_activation_hook(__FILE__, 'createtable');
register_activation_hook(__FILE__, 'insertData');
// register_activation_hook(__FILE__, 'updateFields');


