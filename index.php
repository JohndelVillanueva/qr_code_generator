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

        .input-text-box {
            opacity: 1 !important;
        }

        .ticket-container {
            width: 50%;
            border-radius: 15px;
        }

        h1 {
            color: purple;
        }

        h2 {
            color: purple;
        }

        label {
            color: purple;
            font-weight: 500;
        }

        .form-control {
            border: solid 2px purple !important;
        }

        .form-control:focus {
            box-shadow: none !important;
            outline: solid 1px purple;
            transition: 62ms linear;
        }

        .form-select {
            border: solid 2px purple !important;
        }

        .form-select:focus {
            box-shadow: none !important;
            outline: solid 1px purple;
            transition: 62ms linear;
        }

        .border-custom {
            border-color: purple !important;
            border-style: solid;
        }

        .btn-customized {
            color: white;
            background-color: purple;
            outline: solid 2px purple;
        }

        .btn-customized1 {
            color: white;
            background-color: purple;
            outline: solid 2px purple;
        }

        .btn-customized1:hover {
            color: purple;
            background-color: transparent;
            outline: solid 2px purple;
        }

        .btn-customized:hover {
            color: purple;
            background-color: transparent;
            outline: solid 2px purple;
        }

        .button-group {
            width: 35%;
        }

        @media screen and (min-width:320px) and (max-width:720px) {
            .ticket-container {
                width: 80%;
                height: 80%;
                border-radius: 15px;
            }
        }
    </style>
</head>

<body class="bg-secondary-subtle">
    <div class="wrapper d-flex justify-content-center align-items-center vh-100">
        <div class="ticket-container border border-2 border-custom py-4 text-bg-warning">
            <form method="post" action="qr_generator.php">
                <div class="row p-0 m-0"><img src="./assets/logo.PNG" alt="" style="width:40%; height:75%; margin:auto;"></div>
                <h2 class="text-center">E-Ticket Generator</h2>
                <div class="input-text-box">
                    <!-- First Name  -->
                    <div class="row mx-auto">
                        <div class="col-8 m-auto">
                            <label for="first_name">First Name:</label><br>
                            <input class="form-control form-control-lg rounded-0 border border-2 " type="text" id="first_name" name="first_name" placeholder="First name: John"><br>
                        </div>
                        <!-- Last Name  -->
                        <div class="col-8 m-auto">
                            <label for="last_name">Last Name:</label><br>
                            <input class="form-control form-control-lg rounded-0 border border-2 " type="text" id="last_name" name="last_name" placeholder="Last name: Doe"><br>
                        </div>

                    </div>
                    <div class="row col-12 mx-auto">
                        <div class="col-8 m-auto">
                            <label for="first_name">Phone Number:</label><br>
                            <input class="col-lg-8 form-control form-control-lg rounded-0 border border-2" type="text" id="phone_number" name="phone_number" placeholder="Contact #: ex. 09*********"><br>
                        </div>
                    </div>
                    <div class="row col-12 mx-auto">
                        <div class="col-8 m-auto">
                            <label for="email">Email:</label><br>
                            <input class="form-control form-control-lg rounded-0 border border-2 " type="email" id="email" name="email" placeholder="Email Address: JohnDoe@gmail.com"><br>
                        </div>
                    </div>
                    <div class="row col-12 mx-auto pb-4">
                        <div class="col-8 m-auto">
                            <label for="play">Choose Ticket Type:</label>
                            <select name="play" id="play" class="form-select form-select-lg rounded-0">
                                <option disabled hidden selected>Select Ticket Type</option>
                                <option value="matinee">Matinee: 1:30pm</option>
                                <option value="gala">Gala: 6:30pm</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center justify-content-around">
                        <div class="input-group button-group d-flex flex-row align-items-center mb-4">
                            <label for="seat" class="pe-1">Seat Number:</label>
                            <input type="text" readonly id="seatNumber" name="seat_number" class="assignseat form-control form-control-lg text-center">
                            <button type="button" class="btn btn-customized1 btn-lg rounded-0" data-bs-target="#assignseat" data-bs-toggle="modal"> Assign Seat</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-evenly align-items-center">


                    <!-- Modal -->
                    <div class="modal fade" id="assignseat" tabindex="-1" aria-labelledby="assignseat">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Assign Seat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <style>
                                        .grid {
                                            display: grid;
                                            grid-template-columns: auto auto auto auto auto auto auto auto 5% auto auto auto auto auto auto auto auto;
                                            grid-template-rows: auto auto auto auto auto auto auto;
                                            row-gap: auto;
                                            column-gap: auto;
                                            justify-content: center;
                                            align-items: center;
                                            width: 100%;
                                            gap: 20px;
                                        }

                                        .grid2 {
                                            display: grid;
                                            grid-template-columns: auto auto auto auto auto auto auto auto auto 5% auto auto auto auto auto auto auto auto auto;
                                            grid-template-rows: auto auto auto auto;
                                            row-gap: auto;
                                            column-gap: auto;
                                            width: 100%;
                                            gap: 20px;
                                        }

                                        .grid3 {
                                            display: grid;
                                            grid-template-columns: auto auto auto auto auto auto auto auto auto auto auto 5% auto auto auto auto auto auto auto auto auto auto auto;
                                            grid-template-rows: auto auto auto auto;
                                            row-gap: auto;
                                            column-gap: auto;
                                            justify-content: center;
                                            align-items: center;
                                            width: 100%;
                                            gap: 20px;
                                        }

                                        .grid>.castseat {
                                            background-color: purple;
                                            border: 1px solid white;
                                            padding: 20%;
                                            height: auto;
                                            width: auto;
                                            color: white;
                                            text-align: center;

                                        }


                                        .grid>.seat {
                                            background-color: green;
                                            border: 1px solid white;
                                            padding: 15%;
                                            height: auto;
                                            width: auto;
                                            color: white;
                                            text-align: center;
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .grid2>.seat {
                                            background-color: green;
                                            border: 1px solid white;
                                            padding: 15%;
                                            height: auto;
                                            width: auto;
                                            color: white;
                                            text-align: center;
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .grid3>.seat {
                                            background-color: green;
                                            border: 1px solid white;
                                            padding: 15%;
                                            height: auto;
                                            width: auto;
                                            color: white;
                                            text-align: center;
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .open {
                                            background-color: green;
                                            color: white;
                                        }

                                        .selected {
                                            background-color: brown !important;
                                            color: white !important;
                                            transition: 240ms linear;
                                        }

                                        .stage {
                                            height: 200px;
                                        }
                                    </style>

                                    <div class="container-fluid p-0 m-0">

                                        <div class="row py-5 m-0 bg-dark">
                                            <div class="col-12 mx-auto pb-5">
                                                <div class="stage border border-2 border-light text-light d-flex justify-content-evenly align-items-center display-1">
                                                    <p>Stage Area</p>
                                                    <p>Stage Area</p>
                                                    <p>Stage Area</p>
                                                </div>
                                            </div>
                                            <div class="grid mb-4" id="grid">
                                            </div>
                                            <div class="grid2 mb-4" id="grid2">
                                            </div>
                                            <div class="grid3 mb-4" id="grid3">
                                            </div>
                                        </div>
                                    </div>


                                    <script>
                                        var selectedState = 0;
                                        let lastseatID = null;
                                        let selectedSeat = null;

                                        function handleSeatClick(event) {
                                            if (selectedState == 1 && lastseatID !== null) {
                                                console.log("Already Stored an ID");
                                                let lastSelectedSeat = document.getElementById(lastseatID);
                                                let currentSeat = document.getElementById(selectedSeat);
                                                console.log(lastSelectedSeat);
                                                console.log(currentSeat)
                                                if (lastSelectedSeat) {
                                                    console.log("Triggered");
                                                    lastSelectedSeat.classList.remove('selected');
                                                }
                                                selectedState -= 1;
                                            }
                                            let seatName = event.target.getAttribute('name');
                                            let seatID = event.target.id;
                                            let seatClass = event.target.className;
                                            event.target.classList.add('selected');
                                            console.log("Seat Name:", seatName);
                                            console.log("Seat ID: ", seatID);
                                            console.log("Seat Class:", seatClass);
                                            selectedState += 1;
                                            // let seatNumber = document.getElementById('seat_number');
                                            // seatNumber.value = seatName;
                                            selectedSeat = seatName;
                                            lastseatID = seatID;
                                            // document.getElementById('seatNumber').value = seatID;

                                        }


                                        let grid = document.querySelector('#grid');
                                        // Seat Element Creation Loop for First 7 rows
                                        for (let i = 1; i <= 112; i++) {
                                            // Seperator Addition 
                                            if (i == 9 || i == 25 || i == 41 || i == 57 || i == 73 || i == 89 || i == 105) {
                                                let seperator = document.createElement('div');
                                                seperator.className = 'hidden';
                                                grid.appendChild(seperator);
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid.appendChild(seat);
                                                // Normal Seat Addition
                                            } else {
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid.appendChild(seat);
                                            }
                                            // Conditional for adding castseat class
                                            if (i >= 1 && i <= 64) {
                                                let seatid = document.getElementById(i);
                                                seatid.classList.add('castseat');
                                                seatid.classList.remove('seat');
                                            }
                                            // // Conditional for adding castseat class
                                        }
                                        let grid2 = document.querySelector('#grid2');
                                        // Seat Element Creation Loop for the succeeding 4 rows with 9 seats
                                        for (let i = 113; i <= 184; i++) {
                                            // Seperator Addition 
                                            if (i == 122 || i == 140 || i == 158 || i == 176) {
                                                let seperator = document.createElement('div');
                                                seperator.className = 'hidden';
                                                grid2.appendChild(seperator);
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid2.appendChild(seat);
                                                // Normal Seat Addition
                                            } else {
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid2.appendChild(seat);
                                            }
                                        }
                                        let grid3 = document.querySelector('#grid3');
                                        // Seat Element Creation Loop for the succeeding 4 rows with 9 seats
                                        for (let i = 185; i <= 272; i++) {
                                            // Seperator Addition 
                                            if (i == 196 || i == 218 || i == 240 || i == 262) {
                                                let seperator = document.createElement('div');
                                                seperator.className = 'hidden';
                                                grid3.appendChild(seperator);
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid3.appendChild(seat);
                                                // Normal Seat Addition
                                            } else {
                                                let seat = document.createElement('div');
                                                seat.className = 'seat';
                                                seat.setAttribute('name', i);
                                                seat.id = i;
                                                seat.textContent = 'Seat No: ' + i;
                                                seat.addEventListener('click', handleSeatClick);
                                                grid3.appendChild(seat);
                                            }
                                        }
                                    </script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="generate" onclick="setSeat()">Save Seat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-customized btn-lg rounded-0" id="submit" type="submit" onclick="return confirmation()" value="Generate QR Code">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    function setSeat() {
        let seatNumber = document.getElementById('seatNumber');
        seatNumber.value = selectedSeat;
        console.log(seatNumber);
    }

    function confirmation() {
        var fnameinput = document.getElementById("first_name").value;
        var lnameinput = document.getElementById("last_name").value;
        var numberinput = document.getElementById("phone_number").value;
        var emailinput = document.getElementById("email").value;
        var ticketselected = document.getElementById("play").value;
        var seatselected = document.getElementById("seatNumber").value;
        
        //Condition Starts here
        if (fnameinput.trim() != "" && lnameinput.trim() != "" && numberinput.trim() != "" && emailinput.trim() != "" && ticketselected.trim() != "" && seatselected.trim() != "") {
            if (confirm("Generate a Ticket with the following information?\n Name: " + fnameinput + " " + lnameinput + "\n Contact Number: " + numberinput + "\n Email: " + emailinput + "\n Ticket Type: " + ticketselected + "\n Seat Number: " + seatselected) == true) {
                alert("Processing, please wait.....");
                return true;
            } else {
                return false;
            }
        }
        else {
            alert("Complete the form first");
            return false;
        } 
}
</script>

</html>