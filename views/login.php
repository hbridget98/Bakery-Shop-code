<?php
$message = $params['message'] ??'';
$username = filter_input(INPUT_POST, 'username');
?>
<div class="formback">
    <div >
    <form action="index.php" method="post">
    <h2>Login</h2>
    <div class="form-row d-flex  align-items-center flex-column gap-4">
    <div class="form-group col-md-6">
    <label for='user'>User: </label>
    <input type='text' id='user' name="username" value="<?php echo $username ?>" class="form-control">
    </div>
    <div class="form-group col-md-6">
    <label for='password'>Password: </label>
    <input type='password' id='password' name= "password" class="form-control">
    </div>
    </div>
    <?php if (isset($_SESSION['name'])){
        echo "<div class='form-group col-md-3 d-flex' style='margin-left: 23%;'>";
        echo "<button type = 'submit' name = 'action' value ='user/check' class='button-64' role='button' disabled><span class='text'>Login</span></button>";
        echo "</div";
    }else{
        echo "<div class='form-group col-md-3 d-flex' style='margin-left: 23%;'>";
        echo "<button type = 'submit' name = 'action' value ='user/check' class='button-64' role='button'><span class='text'>Login</span></button>";
        echo "</div";
    }?>
    
    </form>
    </div><br>
    <div style = 'display: block; margin-left: 25%;'>
        <p style='color:red;' class="text-center" ><?php echo "<p style='color:red;'>$message</p>";?></p>
    </div>
    </div>

</div>

