<?php
namespace View;

use \Input;
use \Session;
use \Redirect;
use \Model\Ticket;
use \Model\TicketCategory;
use \Model\CustomField;
use \Form\Form;
use \Form\Field\BaseInputField;
use \Form\Field\TextField;
use \Form\Field\EmailField;
use \Form\Field\SelectField;
use \Form\Field\TextAreaField;
use \Email\EmailSender;


class UserView {
    public static function checkTicket(){
        $view = new \stdClass();

        $form = new Form(array(
            new EmailField('email', 'Indirizzo email*',
                           array("placeholder" => "Email con la quale ha aperto la pratica",
                                 "required" => "", "autofocus" => "")),
            new BaseInputField('number', 'ticket', 'Numero della pratica*',
                          array('placeholder' => 'Numero della pratica',
                                'required' => ''))
        ));

        $view->form = $form;
        if (Input::isSubmit()){
            $view->form->setValues(Input::getAll());

            $requiredFields = ['email', 'ticket'];
            foreach ($requiredFields as $field){
                if (!Input::get($field)){
                    Session::flash('Compila tutti i campi richiesti', 'error');
                    return $view;
                }
            }

            $email = Input::get('email');
            $ticketId = Input::get('ticket'); 

            $ticket = Ticket::getById($ticketId);
            if (!$ticket || $ticket->cust_email != $email){
                Session::flash("I dati inseriti non sono corretti", "error");
                return $view;
            }

            // Valid input
            Session::put('cust_ticket_id', $ticketId);
            Redirect::to('ticket_view.php?id=' . $ticketId);
        }
        
        return $view;
    }

    public static function ticketView(){
        $view = new \stdClass();

        $inputTicketId = Input::get('id');
        
        if (!$inputTicketId || !Session::exists('cust_ticket_id'))
            Redirect::to('/check_ticket.php');

        $ticketId = Session::get('cust_ticket_id');
        if ($ticketId != $inputTicketId){
            Session::flash('Errore durante la Visualizzazione della pratica. ' .
                           'Si prega di riprovare', 'error');
            Redirect::to('/check_ticket.php');
        }

        $ticket = Ticket::getById($ticketId);
        if (!$ticket){
            Session::flash('Pratica non trovata', 'error');
            Session::delete('cust_ticket_id');
            Redirect::to('/check_ticket.php');
        }

        $attribs = array("required" => "");
        if ($ticket->status == 'CLOSE'){
            $attribs['placeholder'] = "La pratica è stata chiusa. Non puoi inviare nuovi messaggi.";
            $attribs['readonly'] = '';
            $attribs['disabled'] = '';
            $view->btnDisabled = "disabled";
        } else {
            $attribs['placeholder'] = 'Invia una risposta';
            $view->btnDisabled = "";
        }
        
        $form = new Form(array(
            new TextAreaField('message', '', $attribs)
        ));
        
        $view->ticket = $ticket;
        $view->form = $form;
        
        return $view;
    }

    public static function recoverTicket(){
        $view = new \stdClass();

        $form = new Form(array(
            new EmailField('email', 'Indirizzo email*',
                           array("placeholder" => "Email con la quale ha aperto la pratica",
                                 "required" => "", "autofocus" => ""))
        ));
        $view->form = $form;

        if (Input::isSubmit()){
            $view->form->setValues(Input::getAll());

            $email = Input::get('email');
            if (!$email){
                Session::flash('Compila tutti i campi richiesti', 'error');
                return $view;
            }

            $tickets = Ticket::getByEmail($email);
            if  (count($tickets) == 0){
                Session::flash("Non è stata aperta alcuna pratica con l'email inserita", 'error');
                return $view;
            }

            // Email
            $fullName = "{$tickets[0]->cust_first_name} {$tickets[0]->cust_last_name}";
            $addr = array(array("email" => $email, "name" => $fullName));
            $subject = "Elenco delle pratiche aperte";

            $body = <<<EOD
Buongiorno,
come da lei richiesto, le abbiamo inviato l'elenco delle pratica attualmente aperte con i relativi numeri:

NUMERO    OGGETTO PRATICA

EOD;
            var_dump($tickets);
            foreach ($tickets as $t){
                $code = $t->id;
                for ($i = strlen($code); $i <= 15; $i++)
                    $code .= " ";
                $body .= "{$code} {$t->subject}\n";
            }
            $body .= "\n\nSimpleTicket";
            
            if (EmailSender::send($addr, $subject, $body)){
                Session::flash("È stata inviata un'email a {$email} con il numero della sua pratica.");
                Redirect::to("/check_ticket.php");
            } else {
                Session::flash("Errore imprevisto durante l'invio dell'email", "error");
                return $view;
            }
        }
        
        return $view;
    }
}
?>
