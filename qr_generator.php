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
    $codeContents = "$first_name $last_name";
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

function generate_img(){
    $puppeteer = new Puppeteer();
    $browser = $puppeteer->launch();
    $page = $browser->newPage();
    $page->goto('ticket.php');

    $container = $page->querySelector('ticket-wrapper');

    if ($container) {
        $container->screenshot(['images/' => 'screenshot.png']);
    }
}


function generate_pdf($qrCodeDataUri, $first_name, $last_name) {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);
    
    $dompdf = new Dompdf();
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .ticket-container { width: 510px; height: 210px; border: 1px solid black; }
            .qrcode { width: 135px; height: 135px; }
            .bg-custom { background-color: blanchedalmond; }
            * { color: darkblue; }
        </style>
    </head>
    <body>
        <div class="d-flex flex-row justify-content-center">
            <div class="ticket-container bg-custom">
                <div class="row p-0 m-0 col-12 pt-2">
                    <div class="col-6">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="p-1">
                                <img src="assets/logo.PNG" alt="Westfields Logo" class="w-100 h-100 logo">
                            </div>
                            <div class="border border-1 border-black d-flex flex-column justify-content-evenly align-items-center p-2">
                                <p class="fw-medium text-wrap text-center m-0 h4"> Into the Woods</p>
                                <p class="fw-medium text-wrap text-center m-0 h5">Event Center</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column justify-content-center align-items-end">
                            <img src="' . $qrCodeDataUri . '" alt="qr" class="qrcode border border-2 border-black">
                        </div>
                    </div>
                </div>
                <div class="row p-0 m-0 col-12 pt-1">
                    <div class="d-flex flex-row justify-content-center p-1">
                        <div class="col-10">
                            <p class="fw-medium h5 text-center m-0">Thank you for purchasing!</p>
                            <p class="fw-medium h5 text-center m-0">Mr. ' . $first_name . ' ' . $last_name . '</p>
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
