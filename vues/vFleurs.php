

<!-- Affichage des informations sur les visiteurs-->

<div class="container">

    <table class="table table-bordered table-striped table-condensed">
      <caption>
<?php
    if (isset($cat))
    {
?>
        <h3><?php echo $cat;?></h3>
<?php    
    }
?>
      </caption>
      <thead>
        <tr>
          <th>Image</th>
          <th>Référence</th>
          <th>Libellé</th>
          <th>Prix</th>
        </tr>
      </thead>
      <tbody>  
<?php
    $i = 0;
    while($i < count($lavisiteur))
    { 
 ?>     
        <tr>
            <td align="center"><img class="img-polaroid" src="../images/<?php echo $lavisiteur[$i]["image"]?>" /></td>
            <td><?php echo $lavisiteur[$i]["ref"]?></td>
            <td><?php echo $lavisiteur[$i]["designation"]?></td>
            <td align="right"><?php echo $lavisiteur[$i]["prix"]?></td>
        </tr>
<?php
        $i = $i + 1;
     }
?>       
       </tbody>       
     </table>    
  </div>

 
