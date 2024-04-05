<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

function enviarCorreo($nombre, $correo, $codigo_verificacion) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pedidos@proyectoinutvm.com';
        $mail->Password   = 'Aezakmi1?';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('pedidos@proyectoinutvm.com', 'Mandaditos Xhate');
        $mail->addAddress($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Codigo de verificacion';

        $cuerpo_mail = '
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Estilos personalizados */
            body {
                font-family: \'Arial\', sans-serif;
                background-color: #f8f9fa; /* Fondo gris claro */
                color: #333; /* Texto negro */
                padding: 20px;
            }
    
            h2 {
                color: #007bff;
                font-size: 28px;
                margin-bottom: 10px;
            }
    
            p {
                font-size: 16px;
                line-height: 1.5;
                margin-bottom: 15px;
            }
    
            .codigo-verificacion {
                background-color: #28a745;
                color: #fff;
                font-size: 24px;
                font-weight: bold;
                padding: 5px 10px;
                border-radius: 5px;
            }
    
            .logo {
                max-width: 150px;
                height: auto;
                margin-top: 20px;
            }
        </style>
        <div>
        <h2>¡Hola ' .$nombre. ' 👋!</h2>
        <p>¡Gracias por registrarte en la aplicación de Mandaditos Xhate 🤗!</p>
        <p>A continuación, te proporcionamos tu código de verificación:</p>
        <!-- Aquí se insertará el código de verificación con la clase CSS personalizada -->
        <p>Tu código de verificación es: <span class="codigo-verificacion">'.$codigo_verificacion.'</span></p>
        <p>Para continuar tienes que iniciar sesion con el correo que ingresaste y la aplicacion hara el resto</p>
        <p>Solo se te pedira este codigo de verificacion, y una vez ingresado puedes comenzar a ordenar😊</p>
        <p>Buena Suerte 😁</p>
        </div>';
        $mail->Body    = $cuerpo_mail;
        $mail->send();
        return "success";
    } catch (Exception $e) {
        return "error";
    }
}
?>