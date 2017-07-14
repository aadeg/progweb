<?php
require_once 'core/init.php';

use \Form\Form;
use \Form\Field\TextField;
use \Form\Field\PasswordField;
use \Form\Field\BooleanField;
use \Form\Field\SelectField;

$form = new Form(array(
        new TextField('username', 'Username', array("required" => "")),
        new PasswordField('password', 'Password', array("required" => "")),
        new BooleanField('rememberme', 'Ricordami', array(), true),
        new SelectField('select', 'Scegli',
                        array(1 => "Prova 1", 2 => "Prova 2", 3 => "Option 3"),
                        array("class" => "input-field"))
    ));

$loginFail = false;

if(Input::isSubmit()){
    $form->setValues(Input::getAll());

    // Login
    $user = AuthManager::checkLogin(Input::get('username'), Input::get('password'));
    if ($user){
        // Valid login
        AuthManager::login($user->id);

        // Reindirizzamento
        $next = Input::get('next', 'GET');
        if ($next == null || $next[0] !== '/')
            $next = Config::get('authmanager.index_page');
        Redirect::to($next);

    } else {
        $loginFail = true;
    }
}

?>
<?php require 'includes/base_start.php'; ?>

<?php if ($loginFail){ ?><p>Username o password errati</p><?php } ?>

<form action="#" method="POST">
    <?php echo $form->as_p(); ?>
    <input type="submit" value="Login">
</form>

<?php require 'includes/base_end.php'; ?>