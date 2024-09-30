<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desarrolladores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e3d7bf; 
            border-top: 70px solid #3F2817; 
        }
        
        .developer-container {
            text-align: center;
            margin-top: 50px; 
            background-color: #c7b69f;
            padding: 20px;
            border-radius: 0px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            margin: 0px auto;
        }

        .circle {
            width: 150px;
            height: 150px;
            background-color: #fff;
            border-radius: 50%; 
            margin: 0 auto 20px; 
            overflow: hidden; 
            border: 3px solid #2E1503; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .circle img {
            width: 100%; 
            border-radius: 50%; 
        }

        .developer-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px; 
            color: #2E1503; 
        }

        .developer-description {
            font-size: 16px;
            color: #2E1503; 
        }
    </style>
</head>
<body>
    <div class="developer-container">
        <div class="circle">
            <img src="imagenes/perfil.jpg" alt=""> 
        </div>
        <div class="developer-name">Daniel Pino</div> 
        <div class="developer-description">
            Estudiante de Desarrollo de software 
        </div>
    </div>
</body>
</html>
