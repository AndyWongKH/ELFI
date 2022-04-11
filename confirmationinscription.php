<!DOCTYPE html>
<html>

<head>
    <title>User Inscription - Elfi</title>
    <!-- Google font : poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="userStyle.css">
    <meta charset="utf-8">
</head>

<body>
    
    <section id= "connexion">
      <div id="container">
        <?php
        require ('BD.php');
          $email=$_POST["email"];
          $nom=$_POST["nomE"];
          $prenom=$_POST["prenomE"];
          $pwd=$_POST["pwd"];
          $date=$_POST["dateE"];
          $adresse=$_POST["AdresseE"];
          $taille=$_POST["tailleE"];
          $poids=$_POST["poidsE"];
          $sexe=$_POST["sexeE"];

          $imc= $poids/($taille*$taille);

          $insertion="INSERT INTO `utiilisateur` (`email_user`, `nom_user`, `prenom_user`, `mdp_user`, `datenaiss_user`, `adresse_user`, `imc_user`, `sexe_user`) VALUES ('$email', '$nom', '$prenom', '$pwd', '$date', '$adresse', '$imc', '$sexe') ";
          $execute=mysqli_query($session,$insertion);
      if($execute==true){
        echo("</br>L'inscription a été enregistrée !</br>");
      }else{
        echo("L'inscription n'as pas pu être effectué");
      };  

          
        ?>
        <button id="fermer" onclick="FermerPopUp()">x</button>  
       <input type="submit" id='submit' value='Se Connecter' >
      </div>
    </section>
  

</body>
</html>