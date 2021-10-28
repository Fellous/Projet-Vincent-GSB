<?php

// MODIFs A FAIRE
// Ajouter en t�tes 
// Voir : jeu de caract�res � la connection

/** 
 * Se connecte au serveur de donn�es                     
 * Se connecte au serveur de donn�es � partir de valeurs
 * pr�d�finies de connexion (h�te, compte utilisateur et mot de passe). 
 * Retourne l'identifiant de connexion si succ�s obtenu, le bool�en false 
 * si probl�me de connexion.
 * @return resource identifiant de connexion
 */
function connecterServeurBD() 
{
    $PARAM_hote='localhost'; // le chemin vers le serveur
    $PARAM_port='3306';
    $PARAM_nom_bd='baseLafleur1'; // le nom de votre base de donn�es
    $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
    $connect = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
    return $connect;

    //$hote = "localhost";
    // $login = "root";
    // $mdp = "";
    // return mysql_connect($hote, $login, $mdp);
}


/** 
 * Ferme la connexion au serveur de donn�es.
 * Ferme la connexion au serveur de donn�es identifi�e par l'identifiant de 
 * connexion $idCnx.
 * @param resource $idCnx identifiant de connexion
 * @return void  
 */
function deconnecterServeurBD($idCnx) {

}


function lister($categ)
{
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
      
           
      $requete="select * from produit";
      if ($categ!="")
      {
          $requete=$requete." where pdt_categorie='".$categ."';";
      }
      
      $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

      $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
      $i = 0;
      $ligne = $jeuResultat->fetch();
      while($ligne)
      {
          $fleur[$i]['image']=$ligne->pdt_image;
          $fleur[$i]['ref']=$ligne->pdt_ref;
          $fleur[$i]['designation']=$ligne->pdt_designation;
          $fleur[$i]['prix']=$ligne->pdt_prix;
          $ligne=$jeuResultat->fetch();
          $i = $i + 1;
      }
  }
  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $fleur;
}


function listerUti($type_uti)
{
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
      
           
      $requete="select id,nom,cat from utilisateur";
      if ($type_uti!="")
      {
          $requete=$requete." where cat='".$type_uti."';";
      }
      
      $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

      $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
      $i = 0;
      $ligne = $jeuResultat->fetch();
      while($ligne)
      {
          $utilisateur[$i]['unId']=$ligne->id;
          $utilisateur[$i]['unNom']=$ligne->nom;
          $utilisateur[$i]['unCat']=$ligne->cat;
         
          $ligne=$jeuResultat->fetch();
          $i = $i + 1;
      }
  }
  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $utilisateur;
}


function rechercher($des)
{
  $fleur=array();
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
      
           
    $requete="select * from produit";
    $requete=$requete." where pdt_designation='".$des."';";
echo $requete;    
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

    $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
    $i = 0;
    $ligne = $jeuResultat->fetch();
    while($ligne)
    {
        $fleur[$i]['image']=$ligne->pdt_image;
        $fleur[$i]['ref']=$ligne->pdt_ref;
        $fleur[$i]['designation']=$ligne->pdt_designation;
        $fleur[$i]['prix']=$ligne->pdt_prix;
        $ligne=$jeuResultat->fetch();
        $i = $i + 1;
    }

  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $fleur;
}



function ajouter($ref, $des, $prix, $image, $cat,&$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
    // V�rifier que la r�f�rence saisie n'existe pas d�ja
    $requete="select * from produit";
    $requete=$requete." where pdt_ref = '".$ref."';"; 
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

    $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
    
    $ligne = $jeuResultat->fetch();
    if($ligne)
    {
      $message="Echec de l'ajout : la r�f�rence existe d�j� !";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      // Cr�er la requ�te d'ajout 
       $requete="insert into produit"
       ."(pdt_ref,pdt_designation,pdt_prix,pdt_image, pdt_categorie) values ('"
       .$ref."','"
       .$des."',"
       .$prix.",'"
       .$image."','"
       .$cat."');";
       
        // Lancer la requ�te d'ajout 
        $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
       
        // Si la requ�te a r�ussi
        if ($ok)
        {
          $message = "La fleur a �t� correctement ajout�e";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'ajout de la fleur a �chou� !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    // deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "probl�me � la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}



function ajouterUti($unId,$unNom,$unMdp,$unMdpVerif,$unCat,&$tabErr)
{

    // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
    if ($unMdpVerif==$unMdp)
    {
              $requete="select * from utilisateur";
            $requete=$requete." where id = '".$unId."';"; 
            $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

            $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
            
            $ligne = $jeuResultat->fetch();
            if($ligne)
            {
              $message="Echec de l'ajout : l ID existe déja !";
              ajouterErreur($tabErr, $message);
            }
            else
            {
              // Cr�er la requ�te d'ajout 
              $requete="insert into utilisateur"
              ."(id,nom,mdp,cat) values ('"
              .$unId."','"
              .$unNom."',"
              .$unMdp.",'"
              .$unCat."');";
              
                // Lancer la requ�te d'ajout 
                $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
              
                // Si la requ�te a r�ussi
                if ($ok)
                {
                  $message = "l utilisateur a �t� correctement ajout�e";
                  ajouterErreur($tabErr, $message);
                }
                else
                {
                  $message = "Attention, l'ajout de l uti a �chou� !!!";
                  ajouterErreur($tabErr, $message);
                } 

            }
            // fermer la connexion
            // deconnecterServeurBD($idConnexion);
          }
          else
    {
      $message = "les mdp sont diferents !!!!!! <br />";
    ajouterErreur($tabErr, $message);
    }
        }
    }
   
    // V�rifier que la r�f�rence saisie n'existe pas d�ja



    
function modifierUti($unId,$unNom,$unMdp,$unMdpVerif,$unCat ,&$tabErr)
{
       // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
    if ($unMdpVerif==$unMdp)
    {
              $requete="select * from utilisateur";
            $requete=$requete." where id = '".$unId."';"; 
            $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

            $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
            
            $ligne = $jeuResultat->fetch();
            if($ligne)
            {
               // Cr�er la requ�te d'ajout 
              //  $requete="update utilisateur"
              //  ."SET
              //  id,nom,mdp,cat values ('"
              //  .$unId."','"
              //  .$unNom."',"
              //  .$unMdp.",'"
              //  .$unCat."')
              // where id = '".$unId."'
              //  ;";
              $requete="update utilisateur SET id=".$unId.",nom='".$unNom."',mdp=".$unMdp.",cat='".$unCat."' where id = ".$unId.";";
               echo $requete;
                //  // Lancer la requ�te d'ajout 
                 $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
               
                 // Si la requ�te a r�ussi
                 if ($ok)
                 {
                   $message = "l utilisateur a �t� correctement modifier";
                   ajouterErreur($tabErr, $message);
                 }
                 else
                 {
                   $message = "Attention, la modif  de l uti a �chou� !!!";
                   ajouterErreur($tabErr, $message);
                 } 
            }
            else
            {
             

                $message="Echec de l'ajout l ID n existe pas !";
              ajouterErreur($tabErr, $message);

            }
            // fermer la connexion
            // deconnecterServeurBD($idConnexion);
          }
          else
    {
      $message = "les mdp sont diferents !!!!!! <br />";
    ajouterErreur($tabErr, $message);
    }
        }
    }
   
    // V�rifier que la r�f�rence saisie n'existe pas d�ja






function supprimer($ref, &$tabErr)
{
    $connexion = connecterServeurBD();
    
    $fleur = array();
          
    $requete="delete from produit";
    $requete=$requete." where pdt_ref='".$ref."';";
    
    // Lancer la requ�te supprimer
    $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
      
    // Si la requ�te a r�ussi
    if ($ok)
    {
      $message = "La fleur a �t� correctement supprim�e";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      $message = "Attention, la suppression de la fleur a �chou� !!!";
      ajouterErreur($tabErr, $message);
    }      
}


function rechercherUtilisateur($log, $psw, &$tabErr)
{
    $connexion = connecterServeurBD();
      
    $requete="select * from utilisateur";
      $requete=$requete." where nom='".$log."' and mdp ='".$psw."';";
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
  
    // Initialisationd e la cat�gorie trouv�e � : "aucune"
    $cat = "nulle";
    
    $ligne = $jeuResultat->fetch();
    
    // Si un utilisateur est trouv�, on initialise une variable cat avec la cat�gorie de cet utilisateur trouv�e dans la table utilisateur
    if ($ligne)
    {
        $cat = $ligne['cat'];
    }
    $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  
  return $cat;
}



?>
