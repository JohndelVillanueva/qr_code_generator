<?php 
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize counts
$count = 0;
$countVip = 0;

// Read the current count from the files
$countFile = 'ticket_count.txt';
$countFileVip = 'ticket_countVIP.txt';

if (file_exists($countFile)) {
    $count = (int)file_get_contents($countFile);
}

if (file_exists($countFileVip)) {
    $countVip = (int)file_get_contents($countFileVip);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seat_number = $_POST['seat_number'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $attendance = $_POST['attend'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }
    if (empty($first_name) || empty($last_name)) {
        echo "First name and last name are required.";
        exit;
    }

    // Generate QR code data with ticket number
    if ($seat_number == 1) {
        $normalTicket = $count + 1; // Temporarily increment for display
        $codeContents = "Ticket Number: $normalTicket\tEmail: $email\tName: $first_name $last_name\tPhoneNumber: $phone_number\tAttend Date: $attendance";
    } else {
        $vipTicket = $countVip + 1; // Temporarily increment for display
        $codeContents = "Ticket Number: $vipTicket\tEmail: $email\tName: $first_name $last_name\tPhoneNumber: $phone_number\tAttend Date: $attendance";
    }

    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    // Debugging statement
    error_log("Seat Number: " . $seat_number); // Log the seat number

    // Generate PDF with the QR code
    $normalTicketLabel = "Normal Ticket";
    $vipTicketLabel = "VIP Ticket";
    $ticketType = $seat_number == 1 ? $normalTicketLabel : $vipTicketLabel;

    // Debugging statement
    error_log("Ticket Type: " . $ticketType); // Log the ticket type

    $pdfFilePath = generate_pdf($qrCodeDataUri, $first_name, $last_name, $ticketType);

    // Attempt to send email with PDF attachment
    $emailSent = send_email_with_pdf($email, $pdfFilePath);

    // If email sent successfully, increment the count
    if ($emailSent) {
        if ($seat_number == 1) {
            file_put_contents($countFile, $count + 1);
        } else {
            file_put_contents($countFileVip, $countVip + 1);
        }
    }
}

function generate_pdf($qrCodeDataUri, $first_name, $last_name, $ticketType) {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('dpi', 120);
    $dompdf = new Dompdf($options);
    $html = '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket</title>
        <!-- Bootstrap CDN  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">
        <style>
            * {
                color: darkblue;
            }
            .bg-custom {
                background-color: bisque;
            }
            .text-detail {
                color: darkblue;
                font-size: 20px;
                font-weight: 600;
                height: 43px;
            }
            .table-container {
                width: 610px;
                height: 315px;
                position: absolute;
                transform: translate(-50%, -50%);
                top: 20%;
                left: 50%;
            }
            .wis-image > img {
                width: 320px;
                height: 80px;
            }
            .qr-image > img {
                width: 281px;
                height: 286px;
            }
        </style>
    </head>
    
    <body>
        <table class="table-container border bordered border-black bg-custom">
            <tbody>
                <tr>
                    <td class="text-detail text-wrap text-center" style="padding-bottom:10px;"> ' . htmlspecialchars($ticketType) . '</td>
                </tr>
                <tr>
                    <td class="wis-image" style="padding-top:10px;"><img src="http://localhost/qr_code_generator/assets/logo.PNG" alt="wis LOGO"></td>
                    <td rowspan="6" class="qr-image px-2"><img src="' . htmlspecialchars($qrCodeDataUri) . '" alt="QR Code" class="border border-2 border-black"></td>
                </tr>
                <tr>
                    <td class="text-detail text-wrap text-center">Into The Woods</td>
                </tr>
                <tr>
                    <td class="text-detail text-wrap text-center"> Westfields Event Center</td>
                </tr>
                <tr>
                    <td class="text-detail text-wrap text-center"> May 28 at 9:30 AM</td>
                </tr>
                <tr>
                    <td class="text-detail text-wrap text-center"> Thank you for purchasing!</td>
                </tr>
                <tr>
                    <td class="text-detail text-wrap text-center" style="padding-bottom:10px;"> Mr. ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</td>
                </tr>
            </tbody>
        </table>
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
    $subject = 'E-Ticket: QR Code';
    $body = 'Please keep the attached PDF containing your QR code. <b>CHECK THE SPAM OPTION IF THERE IS NO EMAIL RECEIVED.</b>';

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
        header('location: index.php');
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Book Your Ticket</h2>
        <form action="" method="post">
