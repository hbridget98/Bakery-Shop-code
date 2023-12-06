<?php
$message = $params['message'] ??'';
$productObj = $params['productObj'] ??'';

//Aqui surt tota la descripcio, pero en el formulari esta tallat
// var_dump($productObj);

if (isset($_SESSION['rol'])){

        if ($productObj){
            echo <<<EOT
            <div class= 'formback'>
            <form action="index.php" method="post">
            <h2>Form products</h2>
            <div class="form-row d-flex  align-items-center flex-column gap-4">
            <div class="col-md-7">
            <label for='idp'>Id: </label>
            <div class="d-flex form-group">
            <input type='text' name='idp' class="form-control d-flex"  value={$productObj->getId()}>
            <button class="btn btn-dark " type="submit"  value ="product/search" name = "action" >
                <i class="fa-solid fa-magnifying-glass "></i>
            </button>
            </div>
            </div><br>
            <div class="form-group col-md-7 ">
            <label for='description'>Description: </label>
            <input type='text' name='description' class="form-control"  value={$productObj->getDescription()}>
            </div>
            <div class=" form-group col-md-7">
            <label for='price'>Price: </label>
            <input type='text' name='price' class="form-control"  value={$productObj->getPrice()}>
            </div>
            <div class="form-group col-md-7">
            <label for='rol'>Stock: </label>
            <input type='text' name='stock' class="form-control"  value={$productObj->getStock()}>
            </div>
            </div>
            <div class="form-group col-md-3 d-flex" style="margin-left: 20%;">
            <button type = "submit" name = "action" value ="product/add" class="button-64" role="button"><span class="text">Add</span></button>
            <button type = "submit" name = "action" value ="product/modify" class="button-64" role="button"><span class="text">Modify</span></button>
            <button type = "submit" name = "action" value ="product/delete" class="button-64" role="button"><span class="text">Delete</span></button>
            <button type = "submit" name = "action" value ="product/reset" class="button-64" role="button"><span class="text">Erase</span></button>
            </div>
            </form>
            <br>
            <div style = 'display: block;'>
            <p style='color:red;' class="text-center">{$message}</p>
            </div>
            </div>
            EOT;            
                    
        }else{
            echo <<<EOT
                    <div class= 'formback'>
                    <form action="index.php" method="post">
                    <h2>Form products</h2>
                    <div class="form-row d-flex  align-items-center flex-column gap-4">
                    <div class="col-md-7">
                    <label for='idp'>Id: </label>
                    <div class="d-flex form-group">
                    <input type='text' name='idp' class="form-control d-flex">
                    <button class="btn btn-dark " type="submit"  value ="product/search" name = "action" >
                        <i class="fa-solid fa-magnifying-glass "></i>
                    </button>
                    </div>
                    </div><br>
                    <div class="form-group col-md-7 ">
                    <label for='description'>Description: </label>
                    <input type='text' name='description' class="form-control" >
                    </div>
                    <div class=" form-group col-md-7">
                    <label for='price'>Price: </label>
                    <input type='text' name='price' class="form-control" >
                    </div>
                    <div class="form-group col-md-7">
                    <label for='rol'>Stock: </label>
                    <input type='text' name='stock' class="form-control" >
                    </div>
                    </div>
                    <div class="form-group col-md-3 d-flex" style="margin-left: 20%;">
                    <button type = "submit" name = "action" value ="product/add" class="button-64" role="button"><span class="text">Add</span></button>
                    <button type = "submit" name = "action" value ="product/modify" class="button-64" role="button"><span class="text">Modify</span></button>
                    <button type = "submit" name = "action" value ="product/delete" class="button-64" role="button"><span class="text">Delete</span></button>
                    <button type = "submit" name = "action" value ="product/reset" class="button-64" role="button"><span class="text">Erase</span></button>
                    </div>
                    </form>
                    <br>
                    <div style = 'display: block;'>
                    <p style='color:red;' class="text-center">{$message}</p>
                    </div>
                    </div>
                    
                    EOT;
        };
}else{
    echo "<div class= 'formback'>";
    echo "<p style='color:red;'>$message</p>";  
    echo "</div>";
}




?>
