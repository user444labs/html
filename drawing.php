<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>⚡ WebSoo - Drawing</title>
    <link rel="icon" href="img\logo.png" type="image/png">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #29326F;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

#canvas-container {
    background-color: white;
    border: 2px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    border-radius: 10px; /* Coins arrondis */
    padding: 20px;
    text-align: center;
}

#canvas {
    border: 2px solid #000;
}

.controls {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
}

.controls > div {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.button {
    font-weight: bold;
    background-color: #54c458;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    border-radius: 5px; /* Coins arrondis */
}

.button:hover {
    background-color: #0056b3;
    transform: scale(1.1); /* Légère augmentation de la taille au survol */
}

input[type="color"] {
    width: 30px;
    height: 30px;
    padding: 0;
    border: none;
    cursor: pointer;
}

input[type="range"] {
    width: 150px; /* Augmentation de la largeur du curseur de ligne */
}

        /* CSS pour le logo en bas à gauche (commun aux deux versions) */
        #logo {
            position: absolute;
            bottom: 350px;
            right: 10px;
            width: 250px;
        }

.active {
    background-color: #54c458;
}

/* Style pour le bouton de retour */
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

/* Style pour l'élément de chargement */
#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Assure que l'élément est au-dessus de tout le reste */
}

.loader-animation {
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

#title {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    background-color: #54c458; /* Couleur de fond */
    padding: 10px 20px; /* Espacement autour du texte */
    border-radius: 10px; /* Coins arrondis */
    color: white; /* Couleur du texte */
}
/* Style pour les balises label */
label {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    border-radius: 10px; /* Coins arrondis */
    color: white; /* Couleur du texte */
}

span {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 5px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    border-radius: 10px; /* Coins arrondis */
    color: white; /* Couleur du texte */
}
    </style>
</head>
<body>
<a href="index.php"><img id="logo" src="img\logo.png" alt="Logo" /></a> 
    <!-- Titre -->
    <div id="title">Drawing 🖌️</div>

    <!-- Bouton de retour -->
    <a href="index.php">
    <button id="retour-btn">Retour vers la page principale</button>
</a>


    <!-- Élément de chargement -->
    <div id="loader">
        <div class="loader-animation"></div>
    </div>

    <div id="canvas-container">
        <canvas id="canvas" width="800" height="600"></canvas>
    </div>
    <div class="controls">
        <div>
            <label for="colorPicker">Couleur du feutre :</label>
            <input type="color" id="colorPicker" value="#000000">
        </div>
        <div>
            <label for="lineWidth">Taille du feutre :</label>
            <input type="range" id="lineWidth" min="1" max="20" value="5">
            <span id="lineWidthValue">5</span>
        </div>
        <div>
            <button id="clearButton" class="button">🗑️ Effacer</button>
        </div>
        <div>
            <button id="downloadButton" class="button">✅ Télécharger</button>
        </div>
        <div>
            <button id="penButton" class="button active">✏️ Feutre</button>
        </div>
        <div>
            <button id="eraserButton" class="button">🧽 Gomme</button>
        </div>
        <div>
            <button id="fillButton" class="button">🧺 Sceau</button>
        </div>
    </div>

    <script>
        // JavaScript pour la gestion du chargement
        window.addEventListener('load', function () {
            // Masquer l'élément de chargement lorsque la page est chargée
            const loader = document.getElementById('loader');
            loader.style.display = 'none';
        });

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const clearButton = document.getElementById('clearButton');
        const downloadButton = document.getElementById('downloadButton');
        const lineWidthInput = document.getElementById('lineWidth');
        const lineWidthValue = document.getElementById('lineWidthValue');
        const penButton = document.getElementById('penButton');
        const eraserButton = document.getElementById('eraserButton');
        const fillButton = document.getElementById('fillButton');
        const colorPicker = document.getElementById('colorPicker');

        let drawing = false;
        let lastX = 0;
        let lastY = 0;
        let isErasing = false;
        let isFilling = false;
        let isDrawing = false;

        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            [lastX, lastY] = [e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top];
            if (isFilling) {
                fillCanvas(lastX, lastY);
            }
        });

        canvas.addEventListener('mouseup', () => {
            isDrawing = false;
            ctx.closePath();
        });

        canvas.addEventListener('mousemove', draw);

        clearButton.addEventListener('click', clearCanvas);
        downloadButton.addEventListener('click', downloadImage);
        lineWidthInput.addEventListener('input', setLineWidth);
        penButton.addEventListener('click', () => toggleTool('pen'));
        eraserButton.addEventListener('click', () => toggleTool('eraser'));
        fillButton.addEventListener('click', () => toggleTool('fill'));
        colorPicker.addEventListener('input', setColor);

        function draw(e) {
            if (!isDrawing) return;
            if (isErasing) {
                ctx.strokeStyle = 'white';
            } else {
                ctx.strokeStyle = colorPicker.value;
            }
            ctx.lineWidth = lineWidthInput.value;
            ctx.lineCap = 'round';
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            [lastX, lastY] = [e.clientX - canvas.getBoundingClientRect().left, e.clientY - canvas.getBoundingClientRect().top];
            ctx.lineTo(lastX, lastY);
            ctx.stroke();
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function downloadImage() {
            const dataURL = canvas.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = dataURL;
            a.download = 'mon_dessin.png';
            a.click();
        }

        function setLineWidth() {
            const lineWidth = lineWidthInput.value;
            lineWidthValue.textContent = lineWidth;
            ctx.lineWidth = lineWidth;
        }

        function toggleTool(tool) {
            penButton.classList.remove('active');
            eraserButton.classList.remove('active');
            fillButton.classList.remove('active');
            isErasing = false;

            switch (tool) {
                case 'pen':
                    penButton.classList.add('active');
                    break;
                case 'eraser':
                    eraserButton.classList.add('active');
                    isErasing = true;
                    break;
                case 'fill':
                    fillButton.classList.add('active');
                    isFilling = true;
                    break;
                default:
                    penButton.classList.add('active');
                    break;
            }
        }

        canvas.addEventListener('click', (e) => {
            if (isFilling) {
                const x = e.clientX - canvas.getBoundingClientRect().left;
                const y = e.clientY - canvas.getBoundingClientRect().top;
                fillCanvas(x, y);
            }
        });

        function fillCanvas(x, y) {
            const targetColor = ctx.getImageData(x, y, 1, 1).data;
            const fillColor = colorPicker.value;
            const pixelStack = [[x, y]];

            if (colorsMatch(targetColor, fillColor)) {
                return;
            }

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            while (pixelStack.length) {
                const newPos = pixelStack.pop();
                const [x, y] = newPos;

                const pixelPos = (y * canvas.width + x) * 4;

                while (y-- >= 0 && colorsMatch(targetColor, getPixelColor(pixelPos))) {
                    pixelPos -= canvas.width * 4;
                }
                pixelPos += canvas.width * 4;
                ++y;

                let reachLeft = false;
                let reachRight = false;

                while (y++ < canvas.height - 1 && colorsMatch(targetColor, getPixelColor(pixelPos))) {
                    colorPixel(pixelPos);

                    if (x > 0) {
                        if (colorsMatch(targetColor, getPixelColor(pixelPos - 4))) {
                            if (!reachLeft) {
                                pixelStack.push([x - 1, y]);
                                reachLeft = true;
                            }
                        } else if (reachLeft) {
                            reachLeft = false;
                        }
                    }

                    if (x < canvas.width - 1) {
                        if (colorsMatch(targetColor, getPixelColor(pixelPos + 4))) {
                            if (!reachRight) {
                                pixelStack.push([x + 1, y]);
                                reachRight = true;
                            }
                        } else if (reachRight) {
                            reachRight = false;
                        }
                    }

                    pixelPos += canvas.width * 4;
                }
            }

            ctx.putImageData(imageData, 0, 0);
        }

        function colorsMatch(color1, color2) {
            for (let i = 0; i < 3; i++) {
                if (Math.abs(color1[i] - color2[i]) > 10) {
                    return false;
                }
            }
            return true;
        }

        function getPixelColor(pixelPos) {
            return [
                imageData.data[pixelPos],
                imageData.data[pixelPos + 1],
                imageData.data[pixelPos + 2]
            ];
        }

        function colorPixel(pixelPos) {
            for (let i = 0; i < 3; i++) {
                imageData.data[pixelPos + i] = parseInt(colorPicker.value.substr(1 + i * 2, 2), 16);
            }
        }
    </script>
</body>
</html>
