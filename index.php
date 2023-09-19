<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ WebSoo</title>
    <link rel="icon" href="img\logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles pour l'animation de chargement */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #29326F; /* Couleur de fond */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 6px solid #54c458; /* Couleur de la bordure */
            border-top: 6px solid transparent; /* Bordure transparente */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Styles existants */
        .paris-time {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 36px;
            font-weight: bold;
            color: #29326F;
            background-color: #54c458;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Élément de chargement -->
    <div class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="paris-time" id="paris-time"></div>

    <div class="container">
        <a href="index.php"><img id="logo" src="img\princip.png" alt="Logo" /></a>
        <div class="button-container">
            <button class="button" onclick="showNotification(1)">Convert YT 📱</button>
            <button class="button" onclick="window.location.href='blocnotes.php'">Bloc Notes 📝</button>
            <button class="button" onclick="window.location.href='drawing.php'">Drawing 🖌️</button>
            <button class="button" onclick="showNotification(4)">Soon</button>
            <!--<button class="button" onclick="showNotification(3)">Soon</button>-->
            <!--<button class="button" onclick="showNotification(4)">Soon</button>-->
        </div>
    </div>

    <div class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeNotification()">&times;</span>
            <p></p>
        </div>
    </div>

    <script>
        function showNotification(buttonNumber) {
            let message;
            if (buttonNumber === 3) {
                message = "⚙️ Ce bouton est en cours de développement.";
            } else if (buttonNumber === 4) {
                message = "⚙️ Ce bouton est en cours de développement.";
            } else {
                message = "❌ En Maintenance ! Indisponible pour le moment.";
            }

            const modal = document.querySelector(".modal");
            const modalContent = document.querySelector(".modal-content p");
            modalContent.textContent = message;
            modal.classList.add("active");
        }

        function closeNotification() {
            const modal = document.querySelector(".modal");
            modal.classList.remove("active");
        }

        function updateParisTime() {
            const parisTimeElement = document.getElementById("paris-time");
            
            // Obtenez la date actuelle
            const now = new Date();
            
            // Obtenez le décalage horaire de Paris par rapport à UTC, en prenant en compte l'heure d'été
            const parisTimeZoneOffset = now.getTimezoneOffset() / 60 + 2;
            
            // Calculez l'heure de Paris en ajoutant le décalage horaire
            const parisTime = new Date(now.getTime() + parisTimeZoneOffset * 60 * 60 * 1000);

            const hours = parisTime.getHours().toString().padStart(2, '0');
            const minutes = parisTime.getMinutes().toString().padStart(2, '0');
            const seconds = parisTime.getSeconds().toString().padStart(2, '0');

            const parisTimeString = `${hours}:${minutes}:${seconds}`;
            
            parisTimeElement.textContent = parisTimeString;
        }

        // Mettez à jour l'heure de Paris toutes les secondes (1000 millisecondes)
        setInterval(updateParisTime, 1000);

        // Appelez la fonction une fois au chargement de la page pour afficher l'heure immédiatement.
        updateParisTime();

        // Supprime l'élément de chargement lorsque la page est complètement chargée
        window.addEventListener("load", function () {
            const loaderContainer = document.querySelector(".loader-container");
            loaderContainer.style.display = "none";
        });
    </script>
</body>
</html>
