<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name)  OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Por gentileza preencha o formulário e tente novamente.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "caroldosreis97@gmail.com";
        //$recipient = "david.vitora@gmail.com";

        // Set the email subject.
        $subject = "Nova mensagem recebida de  $name";

        // Build the email content.
        $email_content = "Nome: $name\n";
        $email_content .= "Telefone: $telephone\n\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Assunto: $subject\n\n";
        $email_content .= "Menssagem:\n$message\n";

        // Build the email headers.
        $email_headers = "De: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Mensagem enviada com sucesso.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Algo ocorreu de errado durante o envio da mensagem.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Ocorreu algo ao enviar a mensagem, por gentileza tentar novamente.";
    }

?>
