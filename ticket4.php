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
            }
    
            /* container layout  */
            .table-container {
                width: 610px;
                height: 300px;
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
    
            .qrcode{
                top:29px;
                left:40px;
                width: 205px;
                height: 204px;
                border-radius: 10px;
            }
    
        </style>
    </head>
    
    <!-- 492 px for width and 189 px for height  -->
    
    <body>
        <table class="table" style="width:600px;">
            <tbody style="height:233px;">
                <td style="padding:0; margin:0;"><img style="width:720px; height: 233px; margin:0; padding: 0; " src="http://localhost/qr_code_generator/assets/1.png"><img style="width:198px; height:194px; position:fixed; z-index:0; top:27px;left:17px; border-radius: 8px" src="http://localhost/qr_code_generator/assets/frame.png"></td>
                <td style="padding:0; margin:0; background-color:#334e3b;"><div style="width:150px;"><p class="fw-bold text-center" style="font-size:20pt; width:130px; height:60.5px; color:white; margin-top: 60px; margin-left:10px; border:solid 2px white; background-color:black; margin-bottom:0;"> Seat Number</p><p class="fw-bold text-center" style="font-size:20pt; width:130px; height:50px; padding-top:9px; color:black; margin-bottom:50px; margin-left:10px; border:solid 2px white; background-color:white;"> 001</p></div></td>
            </tbody>
        </table>
    </body>
    
    </html>