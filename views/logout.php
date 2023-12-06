<?php 
$message = $params['message'] ??'';

if (!isset($_SESSION["name"])) {  //user not logged
    echo "<div class= 'formback'>";
    echo "<p style='color:red;'>$message</p>";  
    echo "</div>";

}else {  //user logged.
    echo <<<EOT
    <div class= 'formback'>
    <h2>Logout</h2>
    <form action="index.php" method="post">
    <p>Are you sure to logout?</p>
    <button type = "submit" name = "action" value ="user/out" class="button-64" role="button"><span class="text">Exit</span></button>
    </form>
    </div>
    EOT;  
}
?>
