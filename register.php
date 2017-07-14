<?php
require_once 'core/init.php';

use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\PasswordField;


$form = new Form(array(
    new TextField('last_name', 'Cognome',
                  array("required" => "")),
    new TextField('first_name', 'Nome',
                  array('required' => '')),
    new TextField('username', 'Username',
                  array("required" => "")),
    new PasswordField('password1', 'Password',
                      array("required" => "")),
    new PasswordField('password2', 'Conferma password',
                      array("required" => "")),
    new EmailField('email', 'Email',
                   array('required' => ''))
));

if (Input::isSubmit()){
    $form->setValues(Input::getAll());

    // Validation
    // TODO

    try {
        AuthManager::register(Input::get('username'), Input::get('password1'),
                              Input::get('first_name'), Input::get('last_name'),
                              Input::get('email'), false);

        Redirect::to('index.php');
    } catch (Exception $e){
        die($e->getMessage());
    }
}

?>

<?php require 'includes/base_start.php'; ?>

<form action="#" method="POST">
    <?php echo $form->as_p(); ?>
    <input type="submit" value="Register">
</form>

<?php require 'includes/base_end.php'; ?>