<?php
    class Produit{
        public $id;
        public $image;
        public $marque;
        public $nom;
        public $score;
        public $quantite = 0;
        function set_id($id){
            $this->id = $id;
        }
        function get_id(){
            return $this->id;
        }
        function set_image($image){
            $this->image = $image;
        }
        function get_image(){
            return $this->image;
        }
        function set_marque($marque){
            try {
                $this->marque = $marque;
            } catch (\Throwable $th) {
                $this ->marque = "";
            }
            return $marque;
        }
        function get_marque(){
            return $this->marque;
        }
        function set_nom($nom){
            $this->nom = $nom;
        }
        function get_nom(){
            return $this->nom;
        }
        function set_score($score){
            $this->score = $score;
        }
        function get_score(){
            return $this->score;
        }
        function set_quantite($quantite){
            $this->quantite = $quantite;
        }
        function get_quantite(){
            return $this->quantite;
        }
    };

    // Ajouter un produit dans la bd
    // $panier : variable de session
    // $id,$nom,$marque,$image,$score,$quantite : attributs du produit et qte choisi pat l'utilisateur
    // $message : 
    function InsererProduit($session,$panier){
        foreach ($panier as $produit) {
            $id = $produit[0];
            $nom = $produit[1];
            $marque = $produit[2];
            $image = $produit[3];
            $score = $produit[4];
            $quantite = $produit[5]; 
            // Code d'insertion BD ...
            // Ajouter les produits dans la base si ils ne sont pas déjà enregistrés
            $requeteProduit = ("INSERT IGNORE INTO produit(id_prod, lib_prod, nutriscore_prod, image_prod, marque_prod)
                                VALUES('$id','$nom','$score','$image','$marque');");
            if(mysqli_query($session, $requeteProduit) == TRUE){
                $message = "Votre inventaire a bien été mis à jour !";
            }
            else{
                $message = "Une erreur est survenue, veuillez reconstituer votre panier";
            };
        };

        return $message;
    }

    // Insertion des produits dans l'armoire utilisateur
    function InsererPanier($session, $panier, $idArmoire){
        foreach ($panier as $produit) {
            $id = $produit[0];
            $nom = $produit[1];
            $marque = $produit[2];
            $image = $produit[3];
            $score = $produit[4];
            $quantite = $produit[5]; 
            echo($id);
            echo("<br>");
            echo($idArmoire);
            echo("<br>");
            echo("quantité : $quantite");
            echo("<br>");
            // Code d'insertion BD ...
            // Ajouter les produits dans l'inventaire
            $requeteInventaire = ("INSERT INTO contenir(id_prod,id_armoire,qte_prod) VALUES($id,$idArmoire,$quantite)");
            if(mysqli_query($session, $requeteInventaire) == TRUE){
                $message = "Votre inventaire a bien été mis à jour !";
            }
            else{
                $message = "Une erreur est survenue, veuillez reconstituer votre panier !";
            };
        };
        return $message;
    };


?>