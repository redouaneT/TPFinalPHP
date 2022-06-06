<?php
  //Inclure le fichier fonction.php
  include_once("php/fonctions.php");
  //Déclarrer les variables 
  $groupeInput = -1;
  $sexInput = 2;
  $isChecked = false;
  //vérifier si on arrive du formulaire 
    if (isset($_GET["selectGroupe"]) & isset( $_GET["sexInput"])) {
      $groupeInput = $_GET["selectGroupe"];
      $sexInput =  $_GET["sexInput"];
      if (isset($_GET["checkNoteFinal"])) {
        $isChecked = true;
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Affichage des notes finales</title>
</head>
<body>
  <div class="container">
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Acceuil</a></li>
          <li><a href="notes_par_travail.php">Notes par travail</a></li>
          <li><a class="active" href="notes_finales.php">Notes finales</a></li>
          <li><a href="recherche_notes.php">Recherche de notes</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="titre">
        <h1>582-11B-MA INTRODUCTION À LA PROGRAMMATION WEB</h1>
        <h2>Affichage des notes finales</h2>
      </div>
      <div class="main-wrapper">
        <form action="notes_finales.php" method="get">
          <div class="form-wrapper">
            <div>
              <label for="select-groupe">Selectionner un groupe : </label>
              <select name="selectGroupe" id="select-groupe" required>
                <option value="">---Sélectionner un groupe---</option>
                <option value="0" <?php if( $groupeInput == 0) echo "selected"; ?>>Groupe 1</option>
                <option value="1" <?php if( $groupeInput == 1) echo "selected"; ?>>Groupe 2</option>
                <option value="2" <?php if( $groupeInput == 2) echo "selected"; ?>>Les deux</option>
              </select>
            </div>
            <div class="checkbox">
              <input type="checkbox" id="check_notes_final" name="checkNoteFinal" value="0" <?php if( $isChecked == true) echo "checked";?>>
              <label for="check_notes_final">Afficher seulemnt les notes finales des étudiants qui sont
                en situation d’échec.</label>
            </div>
            <fieldset>
              <legend>Afficher les notes de :</legend>
                <div>
                  <input type="radio" id="homme" name="sexInput" value="0" <?php if( $sexInput == 0) echo "checked"; ?>>
                  <label for="homme">Homme</label>
                </div>
                <div>
                  <input type="radio" id="femme" name="sexInput" value="1" <?php if( $sexInput == 1) echo "checked"; ?>>
                  <label for="femme">Femme</label>
                </div>
                <div>
                  <input type="radio" id="deux-sexes" name="sexInput" value="2" <?php if( $sexInput == 2) echo "checked"; ?>>
                  <label for="deux-sexes">Les deux sexes</label>
                </div>
              </fieldset>
          </div>
          <input  class="btn"  type="submit" name="validerFormulaire" value="Afficher">
        </form>
        <div class="table">
          <?php
            if (isset($_GET["validerFormulaire"])) {
              NotesFinales($groupeInput,$sexInput, $isChecked);
            }
          ?>
        </div>
      </div>
    </main>
    <footer>
      <p>Tous les droits sont reservés</p>
    </footer>
  </div>
</body>
</html>