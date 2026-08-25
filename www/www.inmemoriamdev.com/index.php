<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>In Memoriam - Portail d'accès</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #000;
            font-family: Arial, sans-serif;
            color: #e0e0e0;
            background-image: url('xineph_bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            padding: 50px 20px;
            box-sizing: border-box;
        }

        .logo-container {
            text-align: center;
        }

        /* Logo agrandi à 520px */
        .logo-container img {
            width: 520px;
            max-width: 90%;
            filter: brightness(0) invert(1);
        }

        /* Sous-titre Secundus Adventus */
        .subtitle-serif {
            font-family: 'Cinzel', 'Georgia', 'Times New Roman', serif;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 7px;
            text-transform: uppercase;
            color: #cccccc;
            margin-top: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }

        .section-box {
            text-align: center;
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
        }

        h2.title-serif {
            font-family: 'Cinzel', 'Georgia', 'Times New Roman', serif;
            font-size: 21px;
            font-weight: 600;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #ffffff;
            margin: 0 0 8px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }

        .desc-text {
            font-size: 13px;
            color: #cccccc;
            margin-bottom: 16px;
            font-family: Arial, sans-serif;
            text-shadow: 0 1px 3px rgba(0,0,0,0.9);
        }

        .form-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        input[type="text"], select {
            background: rgba(8, 8, 12, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 4px;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            outline: none;
            box-sizing: border-box;
        }

        input[type="text"]::placeholder {
            color: #777777;
        }

        input[type="text"]:focus, select:focus {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(12, 12, 18, 0.9);
        }

        select option {
            background: #111111;
            color: #ffffff;
        }

        .input-webmail { width: 280px; }
        .input-search { width: 320px; }

        input[type="submit"] {
            background: #ffffff;
            color: #000000;
            border: none;
            border-radius: 4px;
            padding: 10px 22px;
            font-size: 13px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.2s;
        }

        input[type="submit"]:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="container">
        
        <!-- HAUT : Logo In Memoriam + Secundus Adventus -->
        <div class="logo-container">
            <img src="In_Memoriam_Logo.png" alt="In Memoriam">
            <div class="subtitle-serif">Secundus Adventus</div>
        </div>

        <!-- MILIEU : Webmail -->
        <div class="section-box">
            <h2 class="title-serif">Webmail</h2>
            <div class="desc-text">Veuillez saisir votre nom d'utilisateur pour accéder à votre messagerie</div>
            <form action="webmail.php" method="post">
                <div class="form-row">
                    <input type="text" name="userid" class="input-webmail" placeholder="ex: baldo.marchesi">
                    <input type="submit" value="OK">
                </div>
            </form>
        </div>

        <!-- BAS : Moteur de Recherche -->
        <div class="section-box">
            <h2 class="title-serif">Moteur de recherche</h2>
            <form action="search.php" method="get" target="_blank">
                <div class="form-row">
                    <input type="text" name="q" id="q" class="input-search" placeholder="Rechercher sur le réseau...">
                    <select name="engine">
                        <option value="google">Google 2006</option>
                        <option value="lycos">Lycos 2006</option>
                        <option value="msn" selected>MSN Search 2006</option>
                    </select>
                    <input type="submit" value="Chercher">
                </div>
            </form>
        </div>

    </div>

</body>
</html>