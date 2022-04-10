<!DOCTYPE html>
<html>

<head>
    <title>Welcome User - Elfi</title>
    <!-- Google font : poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="userStyle.css">
</head>

<body>

    <div id="u_header">
        <div id="u_logoUser">

        </div>
        <p id="u_username">
            Utilisateur
        </p>
    </div>

    <div class="u_upperBoards">
        <div id="u_dashBoard">
            <h2>Mon Dashboard</h2>
            <div id="u_imc">
                <h3>IMC</h3>
                <div id="u_box">
                    <p>N/C</p>
                </div>
            </div>
        </div>
        <div id="u_sugg">
            <h2>Suggestion</h2>
        </div>
    </div>

    <div class="u_upperBoards">
        <div id="u_inventaire" class="u_lowerBoardStyle">
            <div class="u_searchbar">
                <h2>Mon inventaire</h2>
                <input class="u_searchStyle" type="search" placeholder="Rechercher ..." />
            </div>

        </div>
        <div id="u_recette" class="u_lowerBoardStyle">
            <div class="u_searchbar">
                <h2>Mes recettes</h2>
                <input class="u_searchStyle" type="search" placeholder="Rechercher ..." />
            </div>

        </div>
    </div>

</body>

</html>