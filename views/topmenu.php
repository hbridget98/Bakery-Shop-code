
<?php
$disabled = 'class = "disabled"';
$pointer = 'style = "pointer-events:none;"';

?>
<?php if (!isset($_SESSION['rol']) ): ?>
<nav>
    
    <ul>
        <li style="float: left;" ><a href="#" class="user">Andrea's Bakery</a></li>
        <li><a href="index.php?action=home">Home</a></li>
        <li><a href="index.php?action=product/listAll">List all products</a></li>
        <li><a href="index.php?action=product/form" <?php echo $disabled; echo $pointer?>>Product form</a></li>
        <li><a href="index.php?action=user/listAll" <?php echo $disabled; echo $pointer?>>List all users</a></li>
        <li><a href="index.php?action=user/form" <?php echo $disabled; echo $pointer?>>User form</a></li>
        <li><a href="index.php?action=login/form">Login</a></li>
        <li><a href="index.php?action=logout">Logout</a></li>
        
    </ul>
</nav>
<?php endif; ?>
<?php if (isset($_SESSION['rol']) ): ?>
<?php if ($_SESSION['rol'] === 'staff'): ?>
   
<nav>
    <ul>
        <li style="float: left;" ><a href="#" class="user">Andrea's Bakery</a></li>
        <li><a href="index.php?action=home">Home</a></li>
        <li><a href="index.php?action=product/listAll">List all products</a></li>
        <li><a href="index.php?action=product/form" >Product form</a></li>
        <li><a href="index.php?action=user/listAll" >List all users</a></li>
        <li><a href="index.php?action=user/form"  <?php echo $disabled; echo $pointer?>>User form</a></li>
        <li><a href="index.php?action=login/form">Login</a></li>
        <li><a href="index.php?action=logout">Logout</a></li>
        <li><a class="user" href="#" ><?php echo "Logged user: ".$_SESSION['name']." ".$_SESSION['surname'] ?></a></li>
    </ul>
</nav>
           

<?php endif; ?>

<?php if ($_SESSION['rol'] === 'admin'): ?>
   
   <nav>
       <ul>
            <li style="float: left;" ><a href="#" class="user">Andrea's Bakery</a></li>
           <li><a href="index.php?action=home">Home</a></li>
           <li><a href="index.php?action=product/listAll">List all products</a></li>
           <li><a href="index.php?action=product/form" >Product form</a></li>
           <li><a href="index.php?action=user/listAll" >List all users</a></li>
           <li><a href="index.php?action=user/form"  >User form</a></li>
           <li><a href="index.php?action=login/form">Login</a></li>
           <li><a href="index.php?action=logout">Logout</a></li>
           <li><a href="#" class="user" ><?php echo "Logged user: ".$_SESSION['name']." ".$_SESSION['surname'] ?></a></li>
       </ul>
   </nav>
              
   
   <?php endif; ?>
   <?php endif; ?>

