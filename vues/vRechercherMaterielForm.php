<!--Formulaire de recherche � partir du nom-->

<div class="container">
  <form class="form-search" action="" method=post>
    <legend>Entrez la designation du matériéle à recherché </legend>
    <div class="input-append">
      <label>id</label> <input type="text" name="id" size="20" /><br />
      <br>
      <label>modele :</label> <input type="text" name="modele" size="20" /><br />
      <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>
  </form>
</div>





<!-- Affichage des informations sur les visiteurs-->

<div class="container">

    <table class="table table-bordered table-striped table-condensed">
      <caption>
<?php
    if (isset($unid))
    {
?>
        <h3><?php echo $unid;?></h3>
<?php    
    }
?>
      </caption>
      <thead>
        <tr>
          <th>id</th>
          <th>marque</th>
          <th>modele</th>
        </tr>
      </thead>
      <tbody>  
<?php
    $i = 0;
    while($i < count($lemateriel))
    { 
 ?>     
        <tr>
            <td><?php echo $lemateriel[$i]["id"]?></td>
            <td><?php echo $lemateriel[$i]["marque"]?></td>
            <td><?php echo $lemateriel[$i]["modele"]?></td>
        </tr>
<?php
        $i = $i + 1;
     }
?>       
       </tbody>       
     </table>    
  </div>

 


 

