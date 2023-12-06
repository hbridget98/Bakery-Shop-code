<?php
$message = $params['message'] ??'';
$userObj = $params['userObj'] ??'';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (isset($_SESSION['rol'])){
    if ($_SESSION['rol'] === 'admin'){

        if ($_SESSION['id'] === $id){

        }else{
            
        }
        if ($userObj){
            echo <<<EOT
            <div class= 'formback'>
                    <form action="index.php" method="post">
                    <h2>Form users</h2>
                    <div class="form-row d-flex  align-items-center flex-column gap-4">
                    <div class="col-md-7">
                    <label for='id'>Id: </label>
                    <div class="d-flex form-group">
                    <input type='text' name='id' class="form-control d-flex" value="{$userObj->getId()}">
                    <button class="btn btn-dark " type="submit"  value ="user/search" name = "action">
                        <i class="fa-solid fa-magnifying-glass "></i>
                    </button>
                    </div>
                    </div><br>
                    <div class="form-group col-md-7 ">
                    <label for='user'>User: </label>
                    <input type='text' name='user' class="form-control"  value="{$userObj->getUsername()}">
                    </div>
                    <div class=" form-group col-md-7">
                    <label for='password'>Password: </label>
                    <input type='password' name='pass' class="form-control"  value="{$userObj->getPassword()}">
                    </div>
                    <div class="form-group col-md-7">
                    <label for='rol'>Rol: </label>
                    <input type='text' name='rol' class="form-control"  value="{$userObj->getRole()}">
                    </div>
                    <div class="form-group col-md-7">
                    <label for='name'>Name: </label>
                    <input type='text' name='name' class="form-control"  value="{$userObj->getName()}">
                    </div>
                    <div class="form-group col-md-7">
                    <label for='surname'>Surname: </label>
                    <input type='text' name='surname' class="form-control"  value="{$userObj->getSurname()}">
                    </div>
                    </div>
                    <div class="form-group col-md-3 d-flex" style="margin-left: 20%;">
                    <button type = "submit" name = "action" value ="user/add" class="button-64" role="button"><span class="text">Add</span></button>
                    <button type = "submit" name = "action" value ="user/modify" class="button-64" role="button"><span class="text">Modify</span></button>
                    <button type = "submit" name = "action" value ="user/delete" class="button-64" role="button"><span class="text">Delete</span></button>
                    <button type = "submit" name = "action" value ="user/reset" class="button-64" role="button"><span class="text">Erase</span></button>
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
                    <h2>Form users</h2>
                    <div class="form-row d-flex  align-items-center flex-column gap-4">
                    <div class="col-md-7">
                    <label for='id'>Id: </label>
                    <div class="d-flex form-group">
                    <input type='text' name='id' class="form-control d-flex" >
                    <button class="btn btn-dark " type="submit"  value ="user/search" name = "action">
                        <i class="fa-solid fa-magnifying-glass "></i>
                    </button>
                    </div>
                    </div><br>
                    <div class="form-group col-md-7 ">
                    <label for='user'>User: </label>
                    <input type='text' name='user' class="form-control" >
                    </div>
                    <div class=" form-group col-md-7">
                    <label for='password'>Password: </label>
                    <input type='password' name='pass' class="form-control" >
                    </div>
                    <div class="form-group col-md-7">
                    <label for='rol'>Rol: </label>
                    <input type='text' name='rol' class="form-control">
                    </div>
                    <div class="form-group col-md-7">
                    <label for='name'>Name: </label>
                    <input type='text' name='name' class="form-control" >
                    </div>
                    <div class="form-group col-md-7">
                    <label for='surname'>Surname: </label>
                    <input type='text' name='surname' class="form-control" >
                    </div>
                    </div>
                    <div class="form-group col-md-3 d-flex" style="margin-left: 20%;">
                    <button type = "submit" name = "action" value ="user/add" class="button-64" role="button"><span class="text">Add</span></button>
                    <button type = "submit" name = "action" value ="user/modify" class="button-64" role="button"><span class="text">Modify</span></button>
                    <button type = "submit" name = "action" value ="user/delete" class="button-64" role="button"><span class="text">Delete</span></button>
                    <button type = "submit" name = "action" value ="user/reset" class="button-64" role="button"><span class="text">Erase</span></button>
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
}else{
    echo "<div class= 'formback'>";
    echo "<p style='color:red;'>$message</p>";  
    echo "</div>";
}




?>




