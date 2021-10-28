<?php
/** 
 * Script de contr�le et d'affichage du cas d'utilisation "Rechercher"
 * @package default
 * @todo  RAS
 */
 
  $repInclude = './include/';
  $repVues = './vues/';
  
  require($repInclude . "_init.inc.php");
 
  $cat="";
  if (isset($_GET['categ']))
  {
  $cat = $_GET['categ'];
  }  
  $lavisiteur = lister($cat);
  
  // Construction de la page Rechercher
  // pour l'affichage (appel des vues)
  include($repVues."entete.php") ;
  include($repVues."menu.php") ;
  include($repVues."vvisiteurs.php");
  include($repVues."pied.php") ;
  ?>
    
