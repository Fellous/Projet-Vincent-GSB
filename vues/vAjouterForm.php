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
    <legend>Entrez les données sur le visiteurur à ajouter </legend>
    <label> Référence : </label> <input type="text" placeholder="Entrer la référence �"name="ref" size="10" /><br />
    <label>Désignation :</label> <input type="text" name="des" size="20" /><br />
    <label>Prix :</label> <input type="text" name="prix" size="10" /><br />
    <label>Image :</label> <input type="text" name="image" size="20"/><br />    
    <label>Cat�gorie :</label>
    <select name="cat">
       <option selected value = "bul">Bulbes</option>
       <option value = "mas">Plantes � massif</option>
       <option value = "ros">Rosiers</option>
    </select> 
  </fieldset>
  <button type="submit" class="btn btn-primary">Enregistrer</button>
  <button type="reset" class="btn">Annuler</button>
  <p>
</form>
</div>


