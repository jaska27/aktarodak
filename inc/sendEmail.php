<?php
$siteOwnersEmail = 'kontakt@aktarodak.pl';

if ($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $phone = trim(stripslashes($_POST['contactPhone']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    if (strlen($name) < 2)
        $error['name'] = "Wpisz imię i nazwisko.";

/*    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error['email'] = "Wpisany adres e-mail jest nieprawidłowy.";*/

    if(strlen($phone) > 0){
        if (!preg_match("/^\d{9}$/", $phone))
            $error['phone'] = "Numer telefonu powinien składać się z 9 cyfr.";
    }

    if (strlen($contact_message) < 15)
        $error['message'] = "Wpisz wiadomość. Powinna mieć minimum 15 znaków.";

    $subject = "Formularz kontaktowy";

    $message .= "Nadawca: " . $name . "<br />";
    $message .= "E-mail: " . $email . "<br />";
    $message .= "Telefon: " . $phone . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> Wiadomość wysłana przez formularz kontaktowy. <br />";

    $from = $name . " <" . $email . ">";

    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


    if (!$error) {
        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Upss... Coś poszło nie tak :( Prosimy, spróbuj ponownie!";
        }
    } else {
        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['phone'])) ? $error['phone'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;

        echo $response;
    }
}

?>