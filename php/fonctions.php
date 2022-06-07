<?php
  // Listes des étudiants de chaque groupe dans deux tableaux asssociative multidimentionnelle 
  $NotesGroupe1 = array(
  "HARG200181" => array("Guillaume", "Harvey", "M", 36, 90, 70, 76),
  "CHAM010283" => array("Marc-André", "Charpentier", "M", 34, 80, 73, 96),
  "TREV290991" => array("Valérie", "Tremblay", "F", 26, 70, 71, 69),
  "PELL180584" => array("Laurence", "Pelletier", "F", 30, 65, 89, 76),
  "MALF110194" => array("Francis", "Maltais", "M", 20, 61, 50, 59),
  "GAUM220654" => array("Martine", "Gauthier", "F", 60, 65, 40, 76)
  );
  $NotesGroupe2 = array(
  "GIRM230383" => array("Marc-Olivier", "Girard", "M", 31, 75, 85, 56),
  "TREM300878" => array("Michel", "Tremblay", "M", 36, 50, 50, 55),
  "POID250468" => array("Diane", "Poitras", "F", 46, 61, 75, 59),
  "LEML180586" => array("Laurence", "Lemieux", "F", 31, 80, 89, 100),
  "VANL130395" => array("Jeff", "Van Cleef", "M", 19, 61, 68, 33)
  );
  // Affichage des notes par travil
  function NotesParTravail($groupeInput, $travailInput){
    global $NotesGroupe1;
    global $NotesGroupe2;
    $notes =[];
    if ($groupeInput == 0) {
      $groupeTab =  $NotesGroupe1;
      $classe = "Group 1";
    }else {
      $groupeTab =  $NotesGroupe2;
      $classe = "Group 2";
    }
    if ($travailInput == 0) {
      //si l'utilisateur à demander la note du travail 1, mettre l'index $n à 4 (index de l'information dans le tableau)
      $travail = "Ttravail 1";
      $n = 4;
    }elseif ($travailInput == 1) {
      $travail = "Ttravail 2";
      $n = 5;
    }else {
      $travail = "Examen Final";
      $n = 6;
    }
    $thead = ["$classe" => ["Nom", "Prénom","$travail (%)"]];
    foreach ($groupeTab as $key => $value) {
       array_push($notes, $value[$n]);
      // Construiur le tableau à afficher selon la demande de l'utilisateur
      $tbody[]= array_merge(array_slice($value,0,2), array_slice($value,$n,1));
    }
    $moyenne = number_format(array_sum($notes)/count($notes),2);
    // construire table HTML
    ConstruireTable($thead, $tbody,$moyenne);
  }
  // Affichage des notes finales
  function NotesFinales($groupeInput, $sexInput, $isChecked){
    global $NotesGroupe1;
    global $NotesGroupe2;
    $setGroupeTab = [];
    $groupeTab = [];
    $gender = "";
    $tbody = [];
    $sommeNote = 0;
    $noteMoyenne = 0;
    // Verrifier les entrées de l'utilisateur est affecter les variables selon ce qu'il a demander  
    switch ($groupeInput) {
      case '0':
        $groupeTab =  $NotesGroupe1;
        $classe = "Group 1";
        break;
      case '1':
        $groupeTab =  $NotesGroupe2;
        $classe = "Group 2";
        break;
      default:
        $groupeTab = array_merge($NotesGroupe1, $NotesGroupe2);
        $classe = "Group 1 et Groupe 2";
        break;
    }
    switch ($sexInput) {
      case '0':
        $gender = "M";
        break;
      case '1':
        $gender = "F";
        break;
        default:
        $gender = false;
        break;
    }
    // Trier la liste du tableau à afficher selon le sexe choisi par l'utilisateur
    foreach ($groupeTab as $value) {
      // si on a specifier le sexe
      if ($gender != false) {
        // fait un tri selon la selection 
        if (in_array($gender,$value)) {
          $setGroupeTab[] = $value;
          }
      }else {
        // Si non selectionner toute la liste
        $setGroupeTab[] = $value;
      }
    }
    // Construire le corps du tableau a afficher et aussi calculer la note final 
    $index = 0;
    foreach ($setGroupeTab as $value) {
      $name = array_merge(array_slice($value,0,2),array_slice($value,2,1));
      $noteFinale = calculNoteFinal(array_slice($value,4,3));
      array_push($name,$noteFinale);
      // si l'utilisateur a checker le checkbox input
      if ($isChecked) {
        // Trier seulement les étudiant ayant une note finale < 60 % 
        if ($noteFinale < 60) {
          $tbody[] = $name;
          $sommeNote += $noteFinale;
          $index++;
        }
      }else {
        // Si le checkbox input n'est pas checker par l'utilisateur, selectionner tout les informations
        $tbody[] = $name;
        $sommeNote += $noteFinale;
        $index++;
      }
    }
    // Calcul la moyennes des notes finales
    if ($sommeNote != 0) {
      $noteMoyenne = number_format(($sommeNote/$index),2);
    }
    // Construir l'entete du tableau à afficher
    $thead = ["$classe" => ["Nom", "Prénom","Sexe","Note Finale (%)"]];
    // construire table HTML
    ConstruireTable($thead, $tbody,$noteMoyenne);
  }
  // Affichages des notes par recherche 
  function RechercheNotes($key){
    global $NotesGroupe1;
    global $NotesGroupe2;
    // Regex : Selectionner seulement une suite de 4 lettres de A à Z en majuscule et qui sont suivie par une suite de 6 chiffres entre 0 et 9 inclus 
    $reg = "/^[A-Z]{4}[0-9]{6}?/m";
    // Verrifier si la chaine de caractere reçue en parametre correspond à $reg
    // récuperer le code permanent correcte et fusionner les tableaux des deux groupe 
    if (preg_match($reg, $key)) {
      $codePermanent = $key;
      $listeEtudiants = array_merge($NotesGroupe1,$NotesGroupe2);
    // verrifier si le code permanent existe dans la liste des etudiants, ensuite
    // récuperer les informations de l'élement à afficher, les mettres dans les tableaux pour construire la table HTML
    if (array_key_exists($codePermanent, $listeEtudiants)) {
      $thead = ["Code permanent : $codePermanent" =>["Nom","Prénom", "Sexe", "Age","Travail 1 (%)","Travail 2 (%)","Examen final (%)","Note Finale (%)"]];
      $noteFinale = calculNoteFinal(array_slice( $listeEtudiants[$codePermanent],4,3));
      $tbody[$codePermanent] = $listeEtudiants[$codePermanent];
      array_push($tbody[$codePermanent], $noteFinale);
      ConstruireTable($thead, $tbody);
    }else {
    // Si le code ne se trouve pas dans la liste des étudiants, l'utilisateur en est informé
      echo "<p>L'étudiant  $codePermanent n'existe pas !</p>";
    }
    }else {
    // Si l'entré de l'utilisateur ne corespond pas à l'expression réguliere $reg, l'utilisateur en est informé avec l'instruction sur le format du code attendu.
      echo "<p>Le code permanent entré est invalide !</p><p>Veuillez svp entrer un code ex. ABCD111111.</p>";
    }
  }
  // fonction qui prend en paramétre deux tableau et une variable mixte optionnelle et construit un tableau HTML 
  function ConstruireTable($thead, $tbody, $moyenne = false){
    $titre = array_keys($thead);
    $colspan = count($thead[$titre[0]]);
    // Construire l'entete du tableau à afficher
    echo "<table><thead><tr><th class=\"titre-tableau\" colspan=\"$colspan\">$titre[0] </th></tr><tr>";
    foreach ($thead as $value) {
      foreach ($value as $v) {
        echo "<th>$v</th>";
      }
    }
    echo "</tr></thead>";
    // Construire le corps du tableau à afficher
    echo "<tbody>";
    if (count($tbody) != 0) {
      // Parcourrir et afficher la liste des etudiants 
      foreach ($tbody as $info) {
        echo "<tr>";
        foreach ($info as $v) {
          echo "<td>$v</td>";
        }
        echo "</tr>";
      }
    }else {
      echo "<tr><td colspan=\"$colspan\">Vide !</td>";
    }
    echo "</tbody>";
    // Verrifier si la fonction reçois le parametre $moyenne
    if ($moyenne != false) {
    // construire un pied de tableau pour afficher la note moyenne des notes affichées
      echo "<tfoot><tr><th colspan=".($colspan-1).">Note Moyenne</th><th>$moyenne %</th></tr></tfoot>";
    }
    echo "</table>";
  }
  // fonction qui prend un tableau en paramétre et retourne un entier 
  // Elle calcul la note finale des notes envoyer dans un tableau en parametre
  function calculNoteFinal($tabNotes){
    $point = [0.15, 0.35, 0.5];
    $noteFinale = 0;
    for ($i = 0; $i < count($tabNotes); $i++) {
      $noteFinale += $tabNotes[$i] * $point[$i];
    }
    return $noteFinale;
  }
?>