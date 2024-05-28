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
            width: 610px;
            /* height: 230px; */
            border: 1px solid black;
        }

        .qrcode {
            width: 254px;
            min-width: 214px;
            min-height: 200px;
        }

        .bg-custom {
            background-color: blanchedalmond;
        }

        * {
            color: darkblue;
        }

        p {
            font-size: 18px;
            line-height: 1.1;
            margin: 0;
        }

        /* Custom CSS Mobile Port  */
        .ticket-mobile-container {
            width: 100%;
            min-height: 800px;
            max-height: 800px;
        }

        div.details {
            writing-mode: vertical-lr;
        }

        .details>p {
            text-orientation: mixed;
        }

        img.qrcode-mobile {
            transform: rotate(90deg);
        }

        .qrcode-mobile {
            min-width: 200px;
            min-height: 200px;
            max-width: 300px;
            /* writing-mode: vertical-lr; */
        }
    </style>
</head>

<!-- 492 px for width and 189 px for height  -->

<body>
    <!-- Webport  -->
    <div class="ticket-wrapper d-flex flex-row justify-content-center">
        <div class="ticket-container bg-custom h-auto text-wrap">

            <div class="row p-0 m-0 col-12 py-2">
                <div class="col-sm-7 col-12 text-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">

                        <div>
                            <img src="./assets/logo.PNG" alt="Westfields Logo" class="w-100 h-100 logo">
                        </div>

                        <div class="d-flex flex-column justify-content-center align-items-center p-0 pb-2 w-100">
                            <p class="fw-medium h5"> What: Into the Woods</p>
                            <p class="fw-medium h5">Where: Westfields Event Center </p>
                            <p class="fw-medium h5">When: May 28 at 9:30 AM </p>
                        </div>

                        <div class="d-flex flex-row justify-content-center p-0 w-100">
                            <div>
                                <p class="fw-medium pb-2">Thank you for purchasing!</p>
                                <p class="fw-bold">Mr. Albert Sanchez De Leon Alfaro Del Mundo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- QR Code -->
                <div class="col-sm-5 col-12 p-0 m-0 pe-sm-3 pt-3 pt-sm-0">
                    <div class="d-flex flex-column justify-content-center align-items-center w-100">
                        <img src="./images/005_file_665444e6472ef.png" alt="qr" class="qrcode border border-2 border-black">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>