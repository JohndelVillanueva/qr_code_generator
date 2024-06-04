<?php 
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize counts
$count1 = 0;
$countVip1 = 0;
// $count2 = 0;
// $countVip2 = 0;

// Read the current count from the files
$countFile = 'ticket_count.txt';
$countFileVip = 'ticket_countVIP.txt';
// $countFile2 = 'ticket_count2.txt';
// $countFileVip2 = 'ticket_countVIP2.txt';

if (file_exists($countFile)) {
    $count1 = (int)file_get_contents($countFile);
}

if (file_exists($countFileVip)) {
    $countVip1 = (int)file_get_contents($countFileVip);
}

// if (file_exists($countFile2)) {
//     $count2 = (int)file_get_contents($countFile2);
// }

// if (file_exists($countFileVip2)) {
//     $countVip2 = (int)file_get_contents($countFileVip2);
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $seat_type = $_POST['seat_type'];//seat type
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    // $attendance = $_POST['attend'];

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
    $ticketNumber = $count1 + 1; // Temporarily increment for display
    
    $codeContents = "Ticket: $ticketNumber\t $email\t $first_name $last_name\t $phone_number";
    // if ($seat_type == 1 && $attendance == 'day1') {
    //     $normalTicket1 = $count1 + 1; // Temporarily increment for display
    //     $codeContents = "Regular Ticket: $normalTicket1\t $email\t $first_name $last_name\t $phone_number\t $attendance";
    //     $ticketNumber = $normalTicket1;
    // }  if ($seat_type == 1 && $attendance === 'day2'){
    //     $normalTicket2 = $count2 + 1; // Temporarily increment for display
    //     $codeContents = "Regular Ticket: $normalTicket2\t $email\t $first_name $last_name\t $phone_number\t $attendance";
    //     $ticketNumber = $normalTicket2;
    // }  if ($seat_type == 2 && $attendance === 'day1'){
    //     $vipTicket1 = $countVip1 + 1; // Temporarily increment for display
    //     $codeContents = "Premium Ticket: $vipTicket1\t $email\t $first_name $last_name\t $phone_number\t $attendance";
    //     $ticketNumber = $vipTicket1;
    // } else {
    //     $vipTicket1 = $countVip1 + 1; // Temporarily increment for display
    //     $codeContents = "Premium Ticket: $vipTicket1\t $email\t $first_name $last_name\t $phone_number\t $attendance";
    //     $ticketNumber = $vipTicket1;
    // }

    $qrCode = QrCode::create($codeContents);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Convert QR code to base64
    $qrCodeDataUri = $result->getDataUri();

    // Debugging statement
    error_log("Seat_type: " . $seat_type); // Log the seat number

    // Generate PDF with the QR code
    // $normalTicketLabel = "Normal Ticket";
    // $vipTicketLabel = "VIP Ticket";
    // $ticketType = $seat_type == 1 ? $normalTicketLabel : $vipTicketLabel;

    // Debugging statement
    error_log("Ticket Type: " . $ticketType); // Log the ticket type

    $pdfFilePath = generate_pdf($qrCodeDataUri, $ticketNumber, $first_name);

    // Attempt to send email with PDF attachment
    $emailSent = send_email_with_pdf($email, $pdfFilePath);

    // If email sent successfully, increment the count
    if ($emailSent) {
        file_put_contents($countFile, $count1 + 1);
    }
}

function generate_pdf($qrCodeDataUri, $ticketNumber, $first_name ) {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('dpi', 120);
    $dompdf = new Dompdf($options);
    //Day 1
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
        
                .wis-image>img {
                    width: 320px;
                    height: 80px;
                }
        
                .qr-image>img {
                    width: 281px;
                    height: 286px;
                }
        
                .qrcode {
                    top: 29px;
                    left: 40px;
                    width: 205px;
                    height: 204px;
                    border-radius: 10px;
                }
            </style>
        </head>
        
        <body>
            <table class="table" style="width:600px;">
                <tbody style="height:233px;">
                    <td style="padding:0; margin:0;">
                        <img style="width:720px; height: 233px; margin:0; padding: 0;" src="http://localhost/qr_code_generator/assets/3.png">
                        <img style="width:196px; height:195px; position:fixed; z-index:0; top:24px; left:16px; border-radius:8px" src="'.$qrCodeDataUri.'">
                    </td>
                    <td style="padding:0; margin:0; background-color:#334e3b; border-left:2px; border-color:white;">
                        <div style="width:150px;">
                            <p class="fw-bold text-center" style="font-size:20pt; width:130px; height:80px; color:white; margin-top: 52px; line-height:40px; margin-left:10px; border:solid 2px white; background-color:black; margin-bottom:0;"> Seat Number</p>
                            <p class="fw-bold text-center" style="font-size:20pt; width:130px; height:50px; padding-top:2px; color:black; margin-top:0px; margin-left:10px; border:solid 2px white; background-color:white;"> '. $ticketNumber .'</p>
                        </div>
                    </td>
                </tbody>
            </table>
        </body>
        
        </html>';
    
    

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $output = $dompdf->output();
    $pdfFilePath = 'images/ticket_' . $first_name . $ticketNumber . '.pdf';

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
