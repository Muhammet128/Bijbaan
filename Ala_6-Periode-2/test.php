<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #container {
            position: relative;
            display: inline-block;
        }

        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Donkere overlay kleur */
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        #buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .image:hover #overlay {
            display: flex;
        }
    </style>
</head>
<body>

<div id="container" class="image">
    <img src="https://www.fotografie-reizen.nl/wp-content/uploads/Fotografietips-Licht-tijdens-ondergaande-zon.jpg" alt="Afbeelding" width="300" height="200">
    <div id="overlay">
        <p>Maak hier je keuze:</p>
        <div id="buttons">
            <button onclick="optie1()">Optie 1</button>
            <button onclick="optie2()">Optie 2</button>
        </div>
    </div>
</div>

<script>
    function optie1() {
        alert('Je hebt Optie 1 gekozen!');
    }

    function optie2() {
        alert('Je hebt Optie 2 gekozen!');
    }
</script>

</body>
</html>
