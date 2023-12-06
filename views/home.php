<?php 
?>
<div class= "home">
<h1 >Welcome to Andrea's Bakery</h1>
<hr>
<?php if (isset($_SESSION['name']) ): ?>
<p><?php echo "Welcome ".$_SESSION['name']." ".$_SESSION['surname'] ?></p>
</div>
<?php endif; ?>