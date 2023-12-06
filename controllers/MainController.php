<?php

//Main controller of the app
//Author: Andrea

require_once 'lib/ViewLoader.php';
require_once 'model/Model.php';


class MainController {

    private ViewLoader $view;
    private Model $model;

    private string $action;


    public function __construct() {
        $this->view  = new ViewLoader();
        $this->model = new Model();
    }

    public function processRequest(){
        
        //GET REQUEST METHOD
        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        switch ($requestMethod) {
            case 'get':
            case 'GET':
                $this->processGet();
                break;
            case 'post':
            case 'POST':
                $this->processPost();
                break;
            default:
                $this->processError();
                break;        
        }
    }

    //Show the views
    private function processGet(){

        $this->action = "";
        if (filter_has_var(INPUT_GET, 'action')){
            $this->action = filter_input(INPUT_GET, 'action');
        }
        switch ($this->action) {
            case 'home':
                $this->doHomePage();
                break;
            case 'product/listAll':
                $this->doListAllProducts();
                break;
            case 'product/form':
                $this->doProductForm();   
                break;
            case 'user/listAll':
                $this->doListAllUsers();
                break;
            case 'user/form':
                $this->doUserForm();
                break;
            case 'login/form':
                $this->doLoginForm();
                break;    
            case 'logout':
                $this->doLogout();
                break;               
            default:
                $this->doHomePage();
                break;    
        }
    }

    
    private function processPost(){
        
        $this->action = "";
        if (filter_has_var(INPUT_POST, 'action')){
            $this->action = filter_input(INPUT_POST, 'action');
        }
        switch ($this->action) {
            case 'home':
                $this->doHomePage();
                break;
            case 'user/out':
                $this->doExit();
                break;    
            case 'user/add': 
                $this->doAddUser();
                break;
            case 'user/check': 
                $this->doSearchUser();
                break;
            case 'user/search': 
                $this->doFindUser();
                break;
            case 'user/delete': 
                $this->doDeleteUser();
                break;
            case 'user/modify': 
                $this->doModifyUser();
                break;
            case 'user/reset': 
                $this->doUserForm();
                break;
            case 'product/add':
                $this->doAddProduct();
                break;
            case 'product/search':
                $this->doFindProduct();
                break;
            case 'product/delete':
                $this->doDeleteProduct();
                break;
            case 'product/modify':
                $this->doModifyProduct();
                break;
            case 'product/reset':
                $this->doProductForm();
                break;                                              
            default:
                $this->doHomePage();
                break;    
        }
    }

    //FUNCTIONS
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * processes error.
     */
    private function processError() {
        trigger_error("Bad method", E_USER_NOTICE);
    } 

    /**
     * Displays homepage
     */
    private function doHomePage() {
        $this->view->show('home.php');
    }



    //USERS
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Displays logout
     * Message if not logged
     */
    private function doLogout() {
        $this->view->show('logout.php');
        if (!isset($_SESSION["name"])){
            $data['message'] = "Not logged yet";
            $this->view->show('logout.php', $data); 
        }
    }

    /**
     * Destroys session redirect to index
     */
    private function doExit() {
        if (isset($_SESSION["name"])) {  //user valid
            session_destroy();
            header("Location: index.php");   

        }
    }

   

    /**
     * Displays page with a user form, admin view
     */


    private function doUserForm(){

        if (!isset($_SESSION['rol'])){
            $data['message'] = "You must be logged to see this page! ";
            $this->view->show('form-user.php', $data); 
        }else if ($_SESSION['rol'] === 'staff') {
            $data['message'] = "Only admins have access to this page!";
            $this->view->show('form-user.php', $data); 
        }else{
            $this->view->show('form-user.php');
        }
        
    }

    
    /**
     * Displays page with a login form, public view
     */


     private function doLoginForm(){
        
        if (isset($_SESSION["name"])){
            $data['message'] = "Already logged! ";
            $this->view->show('login.php', $data); 
        }else{
            $this->view->show('login.php');
        }
    }

      
    /**
     * List all users from data source
     */

     private function doListAllUsers(){
        
        //Array with all users in the datbase
        $userlist = $this->model->searchAllUsers();
        
        if (!is_null($userlist)){
            $data['userList'] = $userlist;
            $this->view->show("list-users.php",$data);
        }else {
            $data['userList'] = array();
            $data['message'] = "Data is null";
            $this->view->show("list-users.php",$data);
        }

     }

    /**
     * Search user in the database with username and password
     */ 

     private function doSearchUser(){

        //Get paameters from form
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        $validata = ($username !== false ) && ($password !== false);
        
        if ($validata){
            //search by username, checks matching password
            $userfound = $this->model->searchUser($username, $password);
            if ($userfound){
                //$this->view->show("home.php"); nomes carrega el body
                header("Location: index.php");
                $_SESSION['id'] = $userfound->getId();
                $_SESSION['name'] = $userfound->getName();
                $_SESSION['surname'] = $userfound->getSurname();
                $_SESSION['rol'] = $userfound->getRole();

            }else if (is_null($userfound)){
                $data['message'] = "User not found";
                $this->view->show("login.php", $data);
            }else if ($userfound === false){
                $data['message'] = "Invalid credentials";
                $this->view->show("login.php", $data);
            }
        } else{
            $data['message'] = "Invalid credentials";
            $this->view->show("login.php", $data);
        }


    }

    /**
     * Serach User by ID and fill a form
     */

     private function doFindUser(){

        //Get parameters from form
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        

        if ($id){
            //serach by id
            $userfoundid = $this->model->searchIdU($id);
            if($userfoundid){

                $data['userObj'] = $userfoundid;
                $data['message'] = "User found";
                $this->view->show("form-user.php", $data);
            }else if(is_null($userfoundid)){

                $data['message'] = "User not found";
                $this->view->show("form-user.php", $data);
            }
        }else{
            $data['message'] = "Id not valid";
            $this->view->show("form-user.php", $data);
        }

     }

     /**
      * Add a User in the database if the id is not choosen.
      */
     private function doaddUser(){

        //Get parameters from form
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $username = htmlspecialchars(trim($_POST['user']));
        $password = htmlspecialchars(trim($_POST['pass']));
        $rol = htmlspecialchars(trim($_POST['rol']));
        $name = htmlspecialchars(trim($_POST['name']));
        $surname = htmlspecialchars(trim($_POST['surname']));

        $validdata = ($id !== false ) && ($username !== false) && ($password !== false) && ($rol !== false) && ($name !== false) && ($surname !== false);

        if ($validdata){
            //Array User
            $User = array();
            array_push($User, $id, $username, $password, $rol, $name, $surname);

            //Add the user
            $useradd = $this->model->addUserForm($id, $User);

            if ($useradd === true){
                $data['message'] = "User added";
                $this->view->show("form-user.php", $data);
            }else if ($useradd === false){
                $data['message'] = "User not added, id already in use";
                $this->view->show("form-user.php", $data);
            }else if(is_null($useradd)){
                $data['message'] = "User not created, check the file users.txt permission";
                $this->view->show("form-user.php", $data);
            }else if($useradd === 404){
                $data['message'] = "User not created, check the file users.txt permission";
                $this->view->show("form-user.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-user.php", $data);
        }
        

        

     } 

     /**
      * Delete a User in the database.
      */
      private function doDeleteUser(){

        //Get parameters from form
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $username = htmlspecialchars(trim($_POST['user']));
        $password = htmlspecialchars(trim($_POST['pass']));
        $rol = htmlspecialchars(trim($_POST['rol']));
        $name = htmlspecialchars(trim($_POST['name']));
        $surname = htmlspecialchars(trim($_POST['surname']));

        $validdata = ($id !== false ) && ($username !== false) && ($password !== false) && ($rol !== false) && ($name !== false) && ($surname !== false);


        if ($_SESSION['id']=== $id){
            $data['message'] = "Cannot delete the user logged";
            $this->view->show("form-user.php", $data);
        }else if ($validdata){
            //Array User
            $User = array();
            array_push($User, $id, $username, $password, $rol, $name, $surname);

            //Add the user
            $userdelete = $this->model->deleteUserForm($User);

            if ($userdelete === true){
                $data['message'] = "User deleted";
                $this->view->show("form-user.php", $data);
            }else if ($userdelete === false){
                $data['message'] = "User not deleted, id not found";
                $this->view->show("form-user.php", $data);
            }else if(is_null($userdelete)){
                $data['message'] = "User not deleted, check the file users.txt permission";
                $this->view->show("form-user.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-user.php", $data);
        }
        

     }  
    
     /**
      * Modify a User in the database.
      */
      private function doModifyUser(){

        //Get parameters from form
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $username = htmlspecialchars(trim($_POST['user']));
        $password = htmlspecialchars(trim($_POST['pass']));
        $rol = htmlspecialchars(trim($_POST['rol']));
        $name = htmlspecialchars(trim($_POST['name']));
        $surname = htmlspecialchars(trim($_POST['surname']));

        $validdata = ($id !== false ) && ($username !== false) && ($password !== false) && ($rol !== false) && ($name !== false) && ($surname !== false);

        if ($_SESSION['id'] === $id){
            $data['message'] = "Cannot modify the user logged";
            $this->view->show("form-user.php", $data);
        }else if ($validdata){
            //Array User
            $User = array();
            array_push($User, $id, $username, $password, $rol, $name, $surname);

            //Add the user
            $userdelete = $this->model->modifyUserForm($User);

            if ($userdelete === true){
                $data['message'] = "User modified";
                $this->view->show("form-user.php", $data);
            }else if ($userdelete === false){
                $data['message'] = "User not modified, id not found";
                $this->view->show("form-user.php", $data);
            }else if(is_null($userdelete)){
                $data['message'] = "User not modified, check the file users.txt permission";
                $this->view->show("form-user.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-user.php", $data);
        }
        

     }

     //PRODUCTS
     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      /**
     * Displays a list of all products in a table, public view
     */

    private function doListAllProducts() {
        $productList = $this->model->searchAllProducts();
        if (!is_null($productList)){
            $data['prodList'] = $productList;
            $this->view->show('list-products.php', $data);
        }else {
            $data['message'] = "Null data ";
            $this->view->show('list-products.php', $data);
        }
        
    }
    

    /**
     * Displays page with a product form, login view
     */


    private function doProductForm(){
        if (!isset($_SESSION['rol'])){
            $data['message'] = "You must be logged to see this page! ";
            $this->view->show('form-product.php', $data);
        }else{
            $this->view->show('form-product.php');
        }
        
    }

    /**
     * Serach Product by ID and fill a form
     */

    private function doFindProduct(){

        //Get parameters from form
        $idp = filter_input(INPUT_POST, 'idp', FILTER_VALIDATE_INT);
        

        if ($idp){
            $productfoundid = $this->model->searchIdP($idp);
            if($productfoundid){

                $data['productObj'] = $productfoundid;
                $data['message'] = "Product found";
                $this->view->show("form-product.php", $data);
            }else if(is_null($productfoundid)){

                $data['message'] = "Product not found";
                $this->view->show("form-product.php", $data);
            }
        }else{
            $data['message'] = "Id not valid";
            $this->view->show("form-product.php", $data);
        }

     }

     /**
     * Add a product to a list, login view all
     */
    private function doAddProduct(){
        //Get parameters from form
        $idp = filter_input(INPUT_POST, 'idp', FILTER_VALIDATE_INT);
        $description = htmlspecialchars(trim($_POST['description']));
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

        $validdata = ($idp !== false ) && ($description !== false) && ($price !== false) && ($stock !== false);

        if ($validdata){
            //Array User
            $Product = array();
            array_push($Product, $idp, $description, $price, $stock);

            //Add the user
            $productadd = $this->model->addProductForm($idp, $Product);

            if ($productadd === true){
                $data['message'] = "Product added";
                $this->view->show("form-product.php", $data);
            }else if ($productadd === false){
                $data['message'] = "Product not added, id already in use";
                $this->view->show("form-product.php", $data);
            }else if(is_null($productadd)){
                $data['message'] = "Product not created, check the file users.txt permission";
                $this->view->show("form-product.php", $data);
            }else if($productadd === 404){
                $data['message'] = "Product not created, check the file users.txt permission";
                $this->view->show("form-product.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-product.php", $data);
        }

    }


    /**
      * Delete a Product in the database.
      */
      private function doDeleteProduct(){

        //Get parameters from form
        $idp = filter_input(INPUT_POST, 'idp', FILTER_VALIDATE_INT);
        $description = htmlspecialchars(trim($_POST['description']));
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

        $validdata = ($idp !== false ) && ($description !== false) && ($price !== false) && ($stock !== false);

        if ($validdata){
            //Array User
            $Product = array();
            array_push($Product, $idp, $description, $price, $stock);

            //Add the user
            $productdelete = $this->model->deleteProductForm($Product);

            if ($productdelete === true){
                $data['message'] = "Product deleted";
                $this->view->show("form-product.php", $data);
            }else if ($productdelete === false){
                $data['messagUsere'] = "Product not deleted, id not found";
                $this->view->show("form-product.php", $data);
            }else if(is_null($productdelete)){
                $data['message'] = "Product not deleted, check the file users.txt permission";
                $this->view->show("form-product.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-product.php", $data);
        }
        

     }

    /**
      * Modify a Product in the database.
      */
      private function doModifyProduct(){

        //Get parameters from form
        $idp = filter_input(INPUT_POST, 'idp', FILTER_VALIDATE_INT);
        $description = htmlspecialchars(trim($_POST['description']));
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

        $validdata = ($idp !== false ) && ($description !== false) && ($price !== false) && ($stock !== false);

        if ($validdata){
            //Array Product
            $Product = array();
            array_push($Product, $idp, $description, $price, $stock);
            //Modify product
            $usermodify = $this->model->modifyProductForm($Product);

            if ($usermodify === true){
                $data['message'] = "Product modified";
                $this->view->show("form-product.php", $data);
            }else if ($usermodify === false){
                $data['message'] = "Product not modified, id not found";
                $this->view->show("form-product.php", $data);
            }else if(is_null($usermodify)){
                $data['message'] = "Product not modified, check the file users.txt permission";
                $this->view->show("form-product.php", $data);
            }
        }else{
            $data['message'] = "Invalid data";
            $this->view->show("form-product.php", $data);
        }
        

     } 
    
}
