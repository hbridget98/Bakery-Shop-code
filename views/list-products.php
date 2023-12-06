
<div class="formback">
<table class="table table-hover table-bordered">
    <h2>List all products</h2>
    <thead class="thead-dark">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Description</th>
        <th scope="col">Price</th>
    </tr>
    </thead>

<?php
//todo
$prodList = $params['prodList']??array();
$message = $params['message'] ??'';


// if (count($prodList) == 0){
//     echo "No data found ";
// }
// echo $message;

// var_dump($prodList);
if (count($prodList) > 0){
    // $params contains variables passed in from the controller.
     foreach ($prodList as $elem) {
         echo <<<EOT
         <tbody>
         <tr>
             <td scope="row">{$elem->getId()}</td>
             <td>{$elem->getDescription()}</td>
             <td>{$elem->getPrice()} €</td>
         </tr>
         </tbody>               
         EOT;
     } 
 }
 
 
 ?>
 </table>

<p ><?php echo $message;?></p>
</div>