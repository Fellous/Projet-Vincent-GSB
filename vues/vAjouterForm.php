<script type="text/javascript">
//<![CDATA[

function valider(){
 frm=document.forms['formAjout'];
  // si le prix est positif
  if(frm.elements['prix'].value >0) {
    // les donn�es sont ok, on peut envoyer le formulaire    
    return true;
  }
  else {
    // sinon on affiche un message
    alert("Le prix doit �tre positif !");
    // et on indique de ne pas envoyer le formulaire
    return false;
  }
}
//]]>
</script>

<!--Saisie des informations dans un formulaire!-->
<div class="container">

<form name="formAjout" action="" method="post" onSubmit="return valider()">
  <fieldset>
    <legend>Entrez les données sur le visiteur à ajouter </legend>
    <label>Nom :</label> <input type="text" name="nom" size="10" /><br />
    <label>Adresse mail :</label> <input type="text" name="mail" size="10" /><br>
    <label>Mot de passe :</label> <input type="text" name="mdp" size="20" /><br>   
  </fieldset>
  <button type="submit" class="btn btn-primary">Enregistrer</button>
  <button type="reset" class="btn">Annuler</button>
  <p>
</form>
</div>


