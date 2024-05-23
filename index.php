

<!DOCTYPE html>
<html>

<head>
    <title>Send QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        .input-text-box{
            opacity: 1!important;
        }
    </style>
</head>

<body class="bg-secondary-subtle">
    <div class="wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="container border border-2 border-white py-5 text-bg-warning">
            <form method="post" action="qr_generator.php">
                <h1 class="text-center">QR Code Generator</h1>
                    <div class="input-text-box">
                        <label for="first_name">First Name:</label><br>
                        <input class="form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="first_name" name="first_name"><br><br>
                        <label for="last_name">Last Name:</label><br>
                        <input class="form-control form-control-lg rounded-0 border border-2 border-dark" type="text" id="last_name" name="last_name"><br><br>
                        <label for="email">Email:</label><br>
                        <input class="form-control form-control-lg rounded-0 border border-2 border-dark" type="email" id="email" name="email"><br><br>
                    </div>
                <div class="d-flex justify-content-center ">
                <input class="btn btn-outline-light btn-lg rounded-0" id="submit" type="submit" value="Generate Qr-Code">
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