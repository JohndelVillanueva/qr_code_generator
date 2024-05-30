<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket</title>
        <!-- Bootstrap CDN  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Javascript CDN  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">
        <link rel="stylesheet" href="reset.css">
        <!-- Custom CSS  -->
        <style>
            *{
                color:darkblue;
            }
            .bg-custom{
                background-color: bisque;
            }
            .text-detail{
                color:darkblue;
                font-size:20px;
                font-weight: 600;
                height:43px;
            }
            /* container layout  */
            .table-container {
                width: 610px;
                height: auto;
                position: absolute;
                transform: translate(-50%, -50%);
                top: 20%;
                left: 50%;
            }
    
            .wis-image>img{
                width:320px;
                height: 80px;
            }
            .qr-image>img{
                width:281px;
                height:286px;
            }    
        </style>
    </head>
    
    <!-- 492 px for width and 189 px for height  -->
    
    <body>
        <table class="table-container border bordered border-black bg-custom">
            <tbody>
                <tr>
                    <td class="wis-image" style="padding-top:10px;"><img src="http://localhost/qr_code_generator/assets/logo.PNG" alt="wis LOGO"></td>
                    <td rowspan="6" class="qr-image px-2"><img src="http://localhost/qr_code_generator/assets/frame.png" alt="qr" class="border border-2 border-black"></td>
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
                    <td class="text-detail text-wrap text-center" style="padding-bottom:10px;"> Mr. Albert Sanchez De Leon Alfaro Del Mundo</td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>