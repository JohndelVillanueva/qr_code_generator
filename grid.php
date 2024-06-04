<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="assets/header.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<style>
    .grid {
        display: grid;
        grid-template-columns: auto auto auto auto auto auto auto auto 5% auto auto auto auto auto auto auto auto;
        grid-template-rows: auto auto auto auto auto;
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

    .grid>.vipseat {
        background-color: orange;
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
    }

    .open {
        background-color: green;
        color: white;
    }

    .closed {
        background-color: brown;
        color: white;
    }

    .stage{
        height: 200px;
    }

</style>

<body>
    <div class="container-fluid p-0 m-0">

        <div class="row py-5 m-0 bg-dark">
            <div class="col-12 mx-auto pb-5">
                <div class="stage border border-2 border-light text-light d-flex justify-content-evenly align-items-center display-1">
                    <p>Stage Area</p>
                    <p>Stage Area</p>
                    <p>Stage Area</p>
                </div>
            </div>
            <div class="grid" id="grid">

            </div>
        </div>
    </div>

    <script>
        let grid = document.querySelector('#grid');
        // Seat Element Creation Loop
        for (let i = 1; i <= 272; i++) {
            // Seperator Addition 
            if (i == 9 || i == 25 || i == 41 || i == 57 || i == 73 || i == 89 || i == 105 || i == 121 || i == 137 || i == 153 || i == 169 || i == 185 || i == 201 || i == 217 || i == 233 || i == 249 || i == 265) {
                let seperator = document.createElement('div');
                seperator.className = 'hidden';
                grid.appendChild(seperator);
                let seat = document.createElement('div');
                seat.className = 'seat';
                seat.id = 'seat' + i;
                seat.textContent = 'Seat No: ' + i;
                grid.appendChild(seat);
                // Normal Seat Addition
            } else {
                let seat = document.createElement('div');
                seat.className = 'seat';
                seat.id = 'seat' + i;
                seat.textContent = 'Seat No: ' + i;
                grid.appendChild(seat);
            }
            // Conditional for adding castseat class
            if (i >= 1 && i <= 32) {
                let seatid = document.getElementById('seat' + i);
                seatid.classList.add('castseat');
                seatid.classList.remove('seat');
            }
            // Conditional for adding castseat class
            else if (i >= 37 && i <= 44) {
                let seatid = document.getElementById('seat' + i);
                seatid.classList.add('castseat');
                seatid.classList.remove('seat');
            } else if (i >= 33 && i <= 36) {
                let seatid = document.getElementById('seat' + i);
                seatid.classList.add('vipseat');
                seatid.classList.remove('seat');
            } else if (i >= 45 && i <= 80) {
                let seatid = document.getElementById('seat' + i);
                seatid.classList.add('vipseat');
                seatid.classList.remove('seat');
            }
        }


    </script>
</body>


</html>