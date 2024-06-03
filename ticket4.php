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

        .seat {
            font-size: 16pt;
            font-weight: bold;
            writing-mode: vertical-lr;
            transform: rotate(180deg);

        }
    </style>
</head>

<!-- 492 px for width and 189 px for height  -->

<body>
    <table class="table table-bordered border border-2 border-black" style="width:600px;">
        <tbody>
            <td class="seat" style="width:2%; height:20%; padding:0; margin:0;">Seat No: </td>
            <td style="width:10%; height: 200px; padding:0; margin:0;"><img style="width:200px; height:240px;" src="./assets/frame.png" alt="no-image"></td>
            <td style="width:30%; height: 200px; padding:0; margin:0;"><img style="width:600px; height: 240px;" src="./assets/Act 1.png" alt="no image"></td>
        </tbody>
    </table>
</body>

</html>