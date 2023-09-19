<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ WebSoo - Notes</title>
    <link rel="icon" href="img\logo.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #29326F;
            position: relative;
            margin-bottom: 20px;
        }

        /* Styles communs pour les deux versions (mobile et desktop) */
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        textarea {
            width: 98%;
            height: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .btn {
            width: 100%;
            margin-top: 10px;
            background-color: #54c458;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }

        /* Styles spécifiques à la version desktop */
        @media screen and (min-width: 768px) {
            .container {
                max-width: 800px;
                background-color: rgba(255, 255, 255, 0.8);
            }
            textarea {
                height: 300px;
            }
        }

        /* CSS pour le logo en bas à gauche (commun aux deux versions) */
        #logo {
            position: absolute;
            bottom: 350px;
            right: 10px;
            width: 250px;
        }

        /* Ajoutez du CSS pour le bouton de retour */
        #retour-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #54c458;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        #retour-btn:hover {
            background-color: #45a049;
        }

        /* CSS pour l'overlay de chargement */
        #overlay {
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
    </style>
</head>
<body>
<div id="overlay">
    <div class="loader"></div>
</div>
<div class="container">
    <!-- Bouton de retour -->
    <button id="retour-btn" onclick="retourPagePrincipale()">Retour vers la page principale</button>
    <h1>Bloc-Notes 📝</h1>
    <textarea id="textArea" placeholder="Commencez à écrire ici..."></textarea>
    <input type="text" id="fileName" placeholder="Nom de la note">
    <button class="btn" onclick="downloadText()">📝 Télécharger en TXT</button>
    <button class="btn" onclick="saveText()">✅ Sauvegarder</button>
    <button class="btn" onclick="clearText()">🗑️ Effacer</button>
</div>
<a href="index.php"><img id="logo" src="img\logo.png" alt="Logo" /></a>
<script>
    window.onload = function() {
        const savedText = localStorage.getItem('savedText');
        if (savedText) {
            document.getElementById('textArea').value = savedText;
        }
        const overlay = document.getElementById('overlay');
        overlay.style.display = 'none';
    }

    function downloadText() {
        const textToSave = document.getElementById('textArea').value;
        const fileName = document.getElementById('fileName').value || 'bloc-notes';
        const blob = new Blob([textToSave], { type: 'text/plain' });
        const a = document.createElement('a');
        a.style.display = 'none';
        document.body.appendChild(a);
        const url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = fileName + '.txt';
        a.click();
        window.URL.revokeObjectURL(url);
    }

    function saveText() {
        const textToSave = document.getElementById('textArea').value;
        localStorage.setItem('savedText', textToSave);
        alert('⚡ Soo Notes : Le texte a été sauvegardé avec succès. ✅');
    }

    function clearText() {
        document.getElementById('textArea').value = '';
        localStorage.removeItem('savedText');
        document.getElementById('fileName').value = '';
        alert('⚡ Soo Notes : Le texte va être supprimé avec succès. 🗑️');
    }

    function retourPagePrincipale() {
        window.location.href = "index.php";
    }
</script>
</body>
</html>
