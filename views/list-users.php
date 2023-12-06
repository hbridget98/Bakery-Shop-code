<?php //$userrole = $_SESSION['userrole']??null;/**Still not done 1/12 */ ?> 
<?php //if (!is_null($userrole)): ?> 

<div class="formback">
<table class="table table-hover table-bordered">
    <h2>List all users</h2>
    <thead class="thead-dark">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Username</th>
        <th scope="col">Role</th>
    </tr>
    </thead>
    <?php
    //display list of items in a table.
    $userList = $params['userList'];
    $message = $params['message']??"";
    if (count($userList) > 0){
       // $params contains variables passed in from the controller.
        foreach ($userList as $elem) {
            echo <<<EOT
            <tbody>
            <tr>
                <td scope="row">{$elem->getId()}</td>
                <td>{$elem->getUsername()}</td>
                <td>{$elem->getRole()}</td>
            </tr>
            </tbody>               
            EOT;
        } 
    }
    
    
    ?>
</table>


<p ><?php echo $message;?></p>
</div>