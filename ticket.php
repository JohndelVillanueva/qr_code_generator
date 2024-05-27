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
        /* container layout  */
        .ticket-container {
            width: 510px;
            height: 210px;
            border: 1px solid black;
        }
        .qrcode{
            width:135px;
            height: 135px;
        }
        .bg-custom{
            background-color:blanchedalmond;
        }
        *{
            color:darkblue;
        }
    </style>
</head>

<!-- 492 px for width and 189 px for height  -->

<body>
    <div class="d-flex flex-row justify-content-center">
        <div class="ticket-container bg-custom">
            <div class="row p-0 m-0 col-12 pt-2">
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="p-1">
                            <img src="./assets/logo.PNG" alt="Westfields Logo" class="w-100 h-100 logo">
                        </div>
                        <div class="border border-1 border-black d-flex flex-column justify-content-evenly align-items-center p-2">
                            <p class="fw-medium text-wrap text-center m-0 h4"> Into the Woods</p>
                            <p class="fw-medium text-wrap text-center m-0 h5">Event Center</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center align-items-end">
                        <img src="./images/005_file_664dae93bea94.png" alt="qr" class="qrcode border border-2 border-black">
                    </div>
                </div>
            </div>
            <div class="row p-0 m-0 col-12 pt-1">
                <div class="d-flex flex-row justify-content-center p-1">
                    <div class="col-10">
                        <p class="fw-medium h5 text-center m-0">Thank you for purchasing!</p>
                        <p class="fw-medium h5 text-center m-0">Mr. Albert Sanchez</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>