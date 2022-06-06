<?php
  //Inclure le fichier fonction.php
  include_once("php/fonctions.php");

  //Déclarrer les variables 
  $groupe_input = -1;
  $travail_input = -1;

  //vérifier si on arrive du formulaire 
  if($_GET)
  {
    if (isset($_GET["selectGroupe"]) & isset($_GET["selectTravail"])) {
      $groupe_input = $_GET["selectGroupe"];
      $travail_input = $_GET["selectTravail"];
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
  <title>Affichage des notes par travail</title>
</head>
<body>
  <div class="container">
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Acceuil</a></li>
          <li><a class="active" href="notes_par_travail.php">Notes par travail</a></li>
          <li><a href="notes_finales.php">Notes finales</a></li>
          <li><a href="recherche_notes.php">Recherche de notes</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="titre">
        <h1>582-11B-MA INTRODUCTION À LA PROGRAMMATION WEB</h1>
        <h2>Affichage des notes par travail</h2>
      </div>
      <div class="main-wrapper">
        <form action="notes_par_travail.php" method="get">
          <div class="form-wrapper">
            <div>
              <label for="select-groupe">Selectionner un groupe : </label>
              <select name="selectGroupe" id="select-groupe" required>
                <option value="">---Sélectionner un groupe---</option>
                <option value="0" <?php if( $groupe_input == 0) echo "selected"; ?>>Groupe 1</option>
                <option value="1" <?php if( $groupe_input == 1) echo "selected"; ?>>Groupe 2</option>
              </select>
            </div>
            <div>
              <label for="select-travail">Selectionner un Travail : </label>
              <select name="selectTravail" id="select-travail" required>
                <option value="" >---Sélectionner un travail---</option >
                <option value="0" <?php if($travail_input == 0) echo "selected"; ?>>Travail 1</option>
                <option value="1" <?php if($travail_input == 1) echo "selected"; ?>>Travail 2</option>
                <option value="2" <?php if($travail_input == 2) echo "selected"; ?>>Examen Final</option>
              </select>
            </div>
          </div>
          <input  class="btn"  type="submit" name="validerFormulaire" value="Afficher">
        </form>
        <div class="table">
          <?php
            if (isset($_GET["validerFormulaire"])) {
              NotesParTravail($groupe_input, $travail_input);
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