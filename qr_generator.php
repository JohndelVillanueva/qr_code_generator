<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Nesk\Puphpeteer\Puppeteer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }
    if (empty($first_name) || empty($last_name)) {
        echo "First name and last name are required.";
        exit;
    }

    // Generate QR code data
    $codeContents = "Email: $email\tName: $first_name $last_name";
    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    // Generate PDF with the QR code
    $pdfFilePath = generate_pdf($qrCodeDataUri, $first_name, $last_name);

    // Send email with PDF attachment
    send_email_with_pdf($email, $pdfFilePath);
}

// function generate_img(){
//     $puppeteer = new Puppeteer();
//     $browser = $puppeteer->launch();
//     $page = $browser->newPage();
//     $page->goto('ticket.php');

//     $container = $page->querySelector('ticket-wrapper');

//     if ($container) {
//         $container->screenshot(['images/' => 'screenshot.png']);
//     }
// }


function generate_pdf($qrCodeDataUri, $first_name, $last_name) {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket</title>
        <style>
            .ticket-container {
                width: 610px;
                border: 1px solid black;
                padding: 20px;
                background-color: blanchedalmond;
                color: darkblue;
            }
            .qrcode {
                width: 254px;
                min-width: 214px;
                min-height: 200px;
                border: 2px solid black;
            }
            p {
                font-size: 18px;
                line-height: 1.1;
                margin: 0;
            }
            .text-center {
                text-align: center;
            }
            .fw-medium {
                font-weight: 500;
            }
            .fw-bold {
                font-weight: bold;
            }
            .d-flex {
                display: flex;
            }
            .flex-column {
                flex-direction: column;
            }
            .flex-row {
                flex-direction: row;
            }
            .justify-content-center {
                justify-content: center;
            }
            .align-items-center {
                align-items: center;
            }
            .w-100 {
                width: 100%;
            }
            .p-0 {
                padding: 0;
            }
            .py-2 {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }
            .col-12 {
                width: 100%;
            }
            .col-sm-7 {
                width: 58.333333%;
            }
            .col-sm-5 {
                width: 41.666667%;
            }
            .pe-sm-3 {
                padding-right: 1rem;
            }
            .pt-3 {
                padding-top: 1rem;
            }
            .pt-sm-0 {
                padding-top: 0;
            }
        </style>
    </head>
    
    <body>
        <div class="d-flex flex-row justify-content-center">
            <div class="ticket-container">
                <div class="row p-0 m-0 col-12 py-2">
                    <div class="col-sm-7 col-12 text-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <img src="http://localhost/qr_code_generator/logo.PNG" alt="Westfields Logo" class="w-100 h-100 logo">
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center p-0 pb-2 w-100">
                                <p class="fw-medium h5"> What: Into the Woods</p>
                                <p class="fw-medium h5">Where: Westfields Event Center </p>
                                <p class="fw-medium h5">When: May 28 at 9:30 AM </p>
                            </div>
                            <div class="d-flex flex-row justify-content-center p-0 w-100">
                                <div>
                                    <p class="fw-medium pb-2">Thank you for purchasing!</p>
                                    <p class="fw-bold">Mr. ' . $first_name . ' ' . $last_name . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-12 p-0 m-0 pe-sm-3 pt-3 pt-sm-0">
                        <div class="d-flex flex-column justify-content-center align-items-center w-100">
                            <img src="'. $qrCodeDataUri . '" alt="qr" class="qrcode">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $output = $dompdf->output();
    $pdfFilePath = 'images/ticket_' . uniqid() . '.pdf';
    file_put_contents($pdfFilePath, $output);

    return $pdfFilePath;
}

function send_email_with_pdf($email, $pdfFilePath) {
    $sender = 'noreply@westfields.edu.ph';
    $subject = 'E-Ticket: QR Code ';
    $body = 'Please keep the attached PDF containing your QR code. <b> CHECK THE SPAM OPTION IF THERE IS NO EMAIL RECEIVED.</b>';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@westfields.edu.ph';
        $mail->Password = 'kzeh yyam yhfr xrqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($sender);
        $mail->addAddress($email);

        $mail->addAttachment($pdfFilePath);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        echo "Email has been sent successfully.";
        header('location: index.php' );
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
