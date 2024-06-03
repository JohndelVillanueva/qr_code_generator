<!DOCTYPE html>
<html>

<head>
    <title>Send QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="assets/header.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url("./D2.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            opacity: .7;
        }

        .input-text-box {
            opacity: 1 !important;
        }

        .btn-customized {
            color:white;
            background-color: purple;
            outline: solid 2px purple;
        }

        .btn-customized:hover{
            color:purple;
            background-color: transparent;
            outline: solid 2px purple;
        }
    </style>
</head>

<body class="bg-secondary-subtle">
    <div class="wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="container border border-2 border-white py-5 text-bg-warning">
            <form method="post" action="qr_generator.php">
                <h1 class="text-center">QR Code Generator</h1>
                <div class="input-text-box">
                    <div class="row col-12">
                        <div class="col-6">
                            <label for="first_name">First Name:</label><br>
                            <input class="col-lg-6 form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="first_name" name="first_name" placeholder="First name: John"><br><br>
                        </div>
                        <div class="col-6">
                            <label for="last_name">Last Name:</label><br>
                            <input class="col-6 form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="last_name" name="last_name" placeholder="Last name: Doe"><br><br>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-6">
                            <label for="first_name">Phone Number:</label><br>
                            <input class="col-lg-6 form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="phone_number" name="phone_number" placeholder="Contact #: ex. 09*********"><br><br>
                        </div>
                        <div class="col-6">
                            <label for="last_name">Attend:</label><br>
                            <input class="col-6 form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="attend" name="attend" placeholder="Attend : Day 1"><br><br>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-6">
                            <label for="seat_no.">Seat Type:</label>
                            <select name="seat_number" id="seat_number" class="form-select form-select-lg border border-2 border-dark rounded-0">
                                <option value="" selected hidden disabled>Select Seat Type</option>
                                <option value="1">Regular Seat</option>
                                <option value="2">Premium Seat</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="email">Email:</label><br>
                            <input class="form-control form-control-lg rounded-0 border border-2 border-dark" type="email" id="email" name="email" placeholder="Email Address: JohnDoe@gmail.com"><br><br>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <input class="btn btn-customized btn-lg rounded-0" id="submit" type="submit" value="Generate QR Code">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    document.getElementById("submit").addEventListener("click", function() {
        // Show the alert
        alert("Press Okay!");
    });
</script>

</html>