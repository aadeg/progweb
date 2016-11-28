<?php
require_once 'core/init.php';
use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\PasswordField;
use \Model\User;

$form = new Form(array(
        new TextField('username', 'Username'),
        new PasswordField('password', 'Password')
    ));

if(Input::isSubmit()){
    $form->setValues(Input::getAll());
    
    // Login
    $user = User::checkLogin($db, Input::get('username'), Input::get('password'));
    if ($user){
        // Valid login
        User::login($db, $user->id);
        Redirect::to('index.php');
    } else {
        echo "Login fail";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>ProgWeb</title>
</head>
<body>
    <form action="#" method="POST">
        <?php echo $form->as_p(); ?>
        <input type="submit" value="Register">
    </form>
</body>
</html>