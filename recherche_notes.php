<?php
  //Inclure le fichier fonction.php
  include_once("php/fonctions.php");
  //Déclarrer les variables 
  $recherche_input = "";
  //vérifier si on arrive du formulaire 
  if($_GET)
  {
    if (isset($_GET["rechercheInput"])) {
      $recherche_input = $_GET["rechercheInput"];
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
  <title>Recherche de notes par etudiantl</title>
</head>
<body>
  <div class="container">
    <header>
      <nav>
        <ul>
          <li><a href="index.php">Acceuil</a></li>
          <li><a href="notes_par_travail.php">Notes par travail</a></li>
          <li><a href="notes_finales.php">Notes finales</a></li>
          <li><a class="active" href="recherche_notes.php">Recherche de notes</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="titre">
        <h1>582-11B-MA INTRODUCTION À LA PROGRAMMATION WEB</h1>
        <h2>Recherche des notes par étudiant</h2>
      </div>
      <div class="main-wrapper">
        <form action="recherche_notes.php" method="get">
          <div class="form-wrapper">
            <div>
              <label for="recherche-notes">Code permanent de l'étudiant : </label>
              <input type="text" id="recherche-notes" name="rechercheInput" value="<?=$recherche_input?>" maxlength="10" required >
            </div>
          </div>
          <input class="btn" type="submit" name="validerFormulaire" value="Afficher">
        </form>
        <div class="table">
          <?php
            if (isset($_GET["validerFormulaire"])) {
              RechercheNotes($recherche_input);
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