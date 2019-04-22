<?php 
$errors = '';

if( ! empty($_POST['config_form']) && ! empty($_POST['email']) && ! empty($_POST['company']))
{
  $company = $_POST['company'];
  $email = $_POST['email'];
  $logo_url = $_POST['logo_url'];
  $logo_link = $_POST['logo_link'];
  $submit_text = $_POST['submit_text'];
  $confirmation_header = $_POST['confirmation_header'];
  $confirmation_message = $_POST['confirmation_message'];
  $bg_color = $_POST['bg_color'];
  $font_color = $_POST['font_color'];
  $ip_color = $_POST['ip_color'];
  $custom_styles = $_POST['custom_styles'];
  $ga_code = $_POST['ga_code'];
  $use_smtp = $_POST['use_smtp'];
  $smtp_host = $_POST['smtp_host'];
  $smtp_auth = $_POST['smtp_auth'];
  $smtp_user = $_POST['smtp_user'];
  $smtp_pass = $_POST['smtp_pass'];
  $smtp_encryption = $_POST['smtp_encryption'];
  $smtp_port = $_POST['smtp_port'];
  if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email))
  {
      $errors .= '%0A'.htmlentities("Error: Invalid email address");
  }
  // var_dump($errors);
  if( empty($errors))
  {
    // Write config.php
    $file = fopen('config.php', 'w');
    fwrite($file, '<?php'.PHP_EOL);
    fwrite($file, 'class IPConfig {'.PHP_EOL);
    fwrite($file, 'const company = "'.$company.'";'.PHP_EOL);
    fwrite($file, 'const email = "'.$email.'";'.PHP_EOL);
    fwrite($file, 'const logo_url = "'.$logo_url.'";'.PHP_EOL);
    fwrite($file, 'const logo_link = "'.$logo_link.'";'.PHP_EOL);
    fwrite($file, 'const submit_text = "'.$submit_text.'";'.PHP_EOL);
    fwrite($file, 'const confirmation_header = "'.$confirmation_header.'";'.PHP_EOL);
    fwrite($file, 'const confirmation_message = "'.$confirmation_message.'";'.PHP_EOL);
    fwrite($file, 'const ga_code = "'.$ga_code.'";'.PHP_EOL);
    fwrite($file, 'const use_smtp = "'.$use_smtp.'";'.PHP_EOL);
    fwrite($file, 'const smtp_host = "'.$smtp_host.'";'.PHP_EOL);
    fwrite($file, 'const smtp_auth = "'.$smtp_auth.'";'.PHP_EOL);
    fwrite($file, 'const smtp_user = "'.$smtp_user.'";'.PHP_EOL);
    fwrite($file, 'const smtp_pass = "'.$smtp_pass.'";'.PHP_EOL);
    fwrite($file, 'const smtp_encryption = "'.$smtp_encryption.'";'.PHP_EOL);
    fwrite($file, 'const smtp_port = "'.$smtp_port.'";'.PHP_EOL);
    fwrite($file, 'static function hasAnalytics() {');
    fwrite($file, '$gacode = self::ga_code;');
    fwrite($file, 'return !empty($gacode);}');
    fwrite($file, '}');
    fclose($file);

    // Write CSS
    $file = fopen('custom_style.css', 'w');
    // Write bg_color
    (! empty($bg_color)) ? fwrite($file, 'body { background-color: '.$bg_color.';}'.PHP_EOL) : '';
    // Write font_color
    (! empty($font_color)) ? fwrite($file, 'body { color: '.$font_color.';}'.PHP_EOL) : '';
    // Write ip_color
    (! empty($ip_color)) ? fwrite($file, '.starter-template h1 {color: '.$ip_color.';}'.PHP_EOL) : '';
    // Write custom styles
    fwrite($file, $custom_styles);
    fclose($file);

    // Verify the config.php exists, then destroy install.php
    if ( ! file_exists('config.php')) {
      // Config.php did not save correctly - write error and go back to form
      $errors .= '%0A'.htmlentities("Error: Could not write config.php.  Please Try Again.  If this error persists, check folder read/write permissions");
      header('Location: /install.php?'.
        'company='.$company.
        'email='.$email.
        '&logo_url='.$logo_url.
        '&logo_link='.$logo_url.
        '&submit_text='.$submit_text.
        '&confirmation_header='.$confirmation_header.
        '&confirmation_message='.$confirmation_message.
        '&bg_color='.$bg_color.
        '&font_color='.$font_color.
        '&ip_color='.$ip_color.
        '&custom_styles='.$custom_styles.
        '&ga_code='.$ga_code.
        '&error='.$errors);
    }

    unlink('install.php');

    //redirect
    header('Location: ..');
    exit;
  }
}

header('Location: install.php?'.
  'company='.$company.
  'email='.$email.
  '&logo_url='.$logo_url.
  '&logo_link='.$logo_url.
  '&submit_text='.$submit_text.
  '&confirmation_header='.$confirmation_header.
  '&confirmation_message='.$confirmation_message.
  '&bg_color='.$bg_color.
  '&font_color='.$font_color.
  '&ip_color='.$ip_color.
  '&custom_styles='.$custom_styles.
  '&ga_code='.$ga_code.
  '&error='.$errors);
