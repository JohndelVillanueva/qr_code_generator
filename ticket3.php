<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <style>
        .ticket-wrapper{
            width:770px;
            height:249px;
        }
        .bg-custom{
            background-image: url(http://localhost/qr_code_generator/assets/1.png);
            background-size: contain;
            background-repeat: no-repeat;
        }
        .qr-code{
            min-width: 27%;
            min-height: 84%;
            width:27%;
            height:84%;
            border-radius: 10px;
            position:relative;
            top:12.1%;
            left:2.5%;
            z-index: 1;
            background-color: transparent;
        }
    </style>
    <!-- Bootstrap CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Javascript CDN  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">
    <link rel="stylesheet" href="reset.css">
</head>

<body>
    <div class="container-fluid">
        <div class="ticket-wrapper bg-custom">
        <div class="ticket-container h-100 w-100">
            <img src="http://localhost/qr_code_generator/assets/frame.png" class="qr-code">
        </div>
        <div class="ticket-stab">
            <p>Seat No.</p>
        </div>
        </div>

    </div>
</body>

</html>