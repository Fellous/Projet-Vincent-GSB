

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
          <th>id</th>
          <th>nom</th>
          <th>mail</th>
        </tr>
      </thead>
      <tbody>  
<?php
    $i = 0;
    while($i < count($levisiteur))
    { 
 ?>     
        <tr>
            <td><?php echo $levisiteur[$i]["idVisiteur"]?></td>
            <td><?php echo $levisiteur[$i]["VIS_NOM"]?></td>
            <td><?php echo $levisiteur[$i]["mail"]?></td>
        </tr>
<?php
        $i = $i + 1;
     }
?>       
       </tbody>       
     </table>    
  </div>

 
