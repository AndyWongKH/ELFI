<?php
// session_start();
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
?>