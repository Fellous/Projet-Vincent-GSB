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
    $PARAM_nom_bd='gsbvisiteurs'; // le nom de votre base de donn�es
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






function lister($idVisiteur)
{
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
      
           
      $requete="select * from visiteur";
      if ($idVisiteur!="")
      {
          $requete=$requete." where idVisiteur='".$idVisiteur."';";
      }
      
      $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

      $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
      $i = 0;
      $ligne = $jeuResultat->fetch();
      while($ligne)
      {
          $levisiteur[$i]['Vis_id']=$ligne->Vis_id;
          $levisiteur[$i]['VIS_NOM']=$ligne->VIS_NOM;
          $levisiteur[$i]['Vis_mail']=$ligne->Vis_mail;
          $ligne=$jeuResultat->fetch();
          $i = $i + 1;
      }
  }
  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $levisiteur;
}
function listerMD($idMateriel)
{
  $connexion = connecterServeurBD();
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
      
           
      $requete="SELECT m.marque , m.modele , m.dimensionLongueur
      FROM materiel m WHERE m.id  NOT IN (SELECT e.id FROM emprunt e where e.Date_Fin_Empr is null )
      or m.id not in(SELECT emprunt.id FROM emprunt) ;";
     
      
      $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

      $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
      $i = 0;
      $ligne = $jeuResultat->fetch();
      while($ligne)
      {
          $leMaterielD[$i]['marque']=$ligne->marque;
          $leMaterielD[$i]['modele']=$ligne->modele;
          $leMaterielD[$i]['dimensionLongueur']=$ligne->dimensionLongueur;
          $ligne=$jeuResultat->fetch();
          $i = $i + 1;
      }
  }
  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $leMaterielD;

}


function emprunter($idVis, $RefMat,$DateEmprunt, &$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
    // V�rifier que la r�f�rence saisie n'existe pas d�ja
   
    $requete="SELECT m.marque , m.modele , m.dimensionLongueur
    FROM materiel m
     where ".$RefMat." NOT IN (SELECT e.id FROM emprunt e where e.Date_Fin_Empr is null )
    or m.id not in(SELECT emprunt.id FROM emprunt);"; 
    echo $requete;
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

    $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récup�rable sous forme d'objet     
    
    $ligne = $jeuResultat->fetch();
    if($ligne)
    {
      // // Créer la requ�te d'ajout 
      // $requete="insert into visiteur"
      // ."(VIS_NOM,Vis_mail) values ('"
      // .$nom."','"
      // .$mail."');";
      // echo $requete;
      
      //   // Lancer la requ�te d'ajout 
      //   $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
      
      //   // Si la requ�te a r�ussi
      //   if ($ok)
      //   {
          $message = "Le visiteur a été correctement ajoutée";
          ajouterErreur($tabErr, $message);
        // }
        // else
        // {
        //   $message = "Attention, l'ajout de le visiteur a échoué !!!";
        //   ajouterErreur($tabErr, $message);
        // } 
    }
    else
    {
      
        $message="Echec de l'emprunt : le matériel est deja emprunter ";
        ajouterErreur($tabErr, $message);

    }
    // fermer la connexion
    // deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}

// function lister($categ)
// {
//   $connexion = connecterServeurBD();
  
//   // Si la connexion au SGBD � r�ussi
//   if (TRUE) 
//   {
      
           
//       $requete="select * from produit";
//       if ($categ!="")
//       {
//           $requete=$requete." where pdt_categorie='".$categ."';";
//       }
      
//       $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

//       $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
//       $i = 0;
//       $ligne = $jeuResultat->fetch();
//       while($ligne)
//       {
//           $visiteur[$i]['image']=$ligne->pdt_image;
//           $visiteur[$i]['ref']=$ligne->pdt_ref;
//           $visiteur[$i]['designation']=$ligne->pdt_designation;
//           $visiteur[$i]['prix']=$ligne->pdt_prix;
//           $ligne=$jeuResultat->fetch();
//           $i = $i + 1;
//       }
//   }
//   $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
//   // deconnecterServeurBD($idConnexion);
//   return $visiteur;
// }


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


function rechercher($unNom, $unMail)
{
  $levisiteur=array();
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
      
           
    $requete="select * from visiteur";
    $requete=$requete." where Vis_mail='".$unMail."';";
    //echo $requete;    
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

    $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
    $i = 0;
    $ligne = $jeuResultat->fetch();
    while($ligne)
    {
        $levisiteur[$i]['VIS_NOM']=$ligne->VIS_NOM;
        $levisiteur[$i]['Vis_mail']=$ligne->Vis_mail;
        $ligne=$jeuResultat->fetch();
        $i = $i + 1;
    }

  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $levisiteur;
  }
  function recherchera($idVisiteur)
{
$connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
      
           
      $requete="select * from visiteur";
      if ($idVisiteur!="")
      {
          $requete=$requete." where Vis_id='".$idVisiteur."';";
      }
      
      $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

      $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
      $i = 0;
      $ligne = $jeuResultat->fetch();
      while($ligne)
      {
          $levisiteur[$i]['Vis_id']=$ligne->Vis_id;
          $levisiteur[$i]['VIS_NOM']=$ligne->VIS_NOM;
          $levisiteur[$i]['Vis_mail']=$ligne->Vis_mail;
          $ligne=$jeuResultat->fetch();
          $i = $i + 1;
      }
  }
  $jeuResultat->closeCursor();   // fermer le jeu de r�sultat
  // deconnecterServeurBD($idConnexion);
  return $levisiteur;
}



function ajouter($nom, $mail, &$tabErr)
{
  // Ouvrir une connexion au serveur mysql en s'identifiant
  $connexion = connecterServeurBD();
  
  // Si la connexion au SGBD � r�ussi
  if (TRUE) 
  {
    // V�rifier que la r�f�rence saisie n'existe pas d�ja
    $requete="select * from visiteur";
    $requete=$requete." where Vis_mail = '".$mail."';"; 
    echo $requete;
    $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

    $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récup�rable sous forme d'objet     
    
    $ligne = $jeuResultat->fetch();
    if($ligne)
    {
      $message="Echec de l'ajout : la référence existe déja !";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      // Créer la requ�te d'ajout 
       $requete="insert into visiteur"
       ."(VIS_NOM,Vis_mail) values ('"
       .$nom."','"
       .$mail."');";
       echo $requete;
       
        // Lancer la requ�te d'ajout 
        $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
       
        // Si la requ�te a r�ussi
        if ($ok)
        {
          $message = "Le visiteur a été correctement ajoutée";
          ajouterErreur($tabErr, $message);
        }
        else
        {
          $message = "Attention, l'ajout de le visiteur a échoué !!!";
          ajouterErreur($tabErr, $message);
        } 

    }
    // fermer la connexion
    // deconnecterServeurBD($idConnexion);
  }
  else
  {
    $message = "problème à la connexion <br />";
    ajouterErreur($tabErr, $message);
  }
}



// function ajouterUti($unId,$unNom,$unMdp,$unMdpVerif,$unCat,&$tabErr)
// {

//     // Ouvrir une connexion au serveur mysql en s'identifiant
//   $connexion = connecterServeurBD();
  
//   // Si la connexion au SGBD � r�ussi
//   if (TRUE) 
//   {
//     if ($unMdpVerif==$unMdp)
//     {
//               $requete="select * from utilisateur";
//             $requete=$requete." where id = '".$unId."';"; 
//             $jeuResultat=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant

//             $jeuResultat->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet     
            
//             $ligne = $jeuResultat->fetch();
//             if($ligne)
//             {
//               $message="Echec de l'ajout : l ID existe déja !";
//               ajouterErreur($tabErr, $message);
//             }
//             else
//             {
//               // Cr�er la requ�te d'ajout 
//               $requete="insert into utilisateur"
//               ."(id,nom,mdp,cat) values ('"
//               .$unId."','"
//               .$unNom."',"
//               .$unMdp.",'"
//               .$unCat."');";
              
//                 // Lancer la requ�te d'ajout 
//                 $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
              
//                 // Si la requ�te a r�ussi
//                 if ($ok)
//                 {
//                   $message = "l utilisateur a �t� correctement ajout�e";
//                   ajouterErreur($tabErr, $message);
//                 }
//                 else
//                 {
//                   $message = "Attention, l'ajout de l uti a �chou� !!!";
//                   ajouterErreur($tabErr, $message);
//                 } 

//             }
//             // fermer la connexion
//             // deconnecterServeurBD($idConnexion);
//           }
//           else
//     {
//       $message = "les mdp sont diferents !!!!!! <br />";
//     ajouterErreur($tabErr, $message);
//     }
//         }
//     }
   
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






function supprimer($id, &$tabErr)
{
    $connexion = connecterServeurBD();
    
    $visiteur = array();
          
    $requete="delete from visiteur";
    $requete=$requete." where Vis_id='".$id."';";
    
    // Lancer la requ�te supprimer
    $ok=$connexion->query($requete); // on va chercher tous les membres de la table qu'on trie par ordre croissant
      
    // Si la requ�te a r�ussi
    if ($ok)
    {
      $message = "La visiteur a été correctement supprimée";
      ajouterErreur($tabErr, $message);
    }
    else
    {
      $message = "Attention, la suppression de la visiteur a échoué !!!";
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
