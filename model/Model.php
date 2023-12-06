<?php

require_once 'persist/UserPersistFileDao.php';
require_once 'persist/ProductPersistFileDao.php';

class Model {

    private string $userFile;
    private string $userFileDelimeter;

    private UserPersistFileDao $userDao;
    private ProductPersistFileDao $productDao;

    public function __construct(){
        $this->userFile = 'files/users.txt';
        $this->productFile = 'files/products.txt';
        $this->userFileDelimeter = ';';
        $this->productFileDelimeter = ';';
        $this->userDao = new UserPersistFileDao($this->userFile, $this->userFileDelimeter);
        $this->productDao = new ProductPersistFileDao($this->productFile, $this->productFileDelimeter);
    }


    //PRODUCTS
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Searches all products from data source or an empty array if not found or in case of error
     */

    public function searchAllProducts(): ?array {
        
        $data = null;

        $data = $this->productDao->selectAll();

        return $data;
    }

    /**
     * Searches product given a int
     * @param int id
     * @return null if not found product, object Product if found
     */

     public function searchIdP(int $id): ?Product {

        $data = $this->productDao->ProductById($id);
        
        if (!is_null($data)){
            $data = $data;
        }else{
            $data = null;
        }

        return $data;

    }

    /**
     * Add a product if the id is not foundent in the database
     */

     public function addProductForm (int $id, array $product): mixed {

        $idexist = $this->searchIdP($id);

        if (is_null($idexist)){
            $Product = $this->productDao->fromFieldsToObj($product);
            if (!is_null($Product)){
                $addProduct = $this->productDao->insert($Product);
                if ($addProduct === 1){
                    $result = true;
                }else if ($addProduct === 0){
                    $result = false;
                }else if ($addProduct === 404){
                    $result = 404;
                }
                
            }else{
                $result = null;
            }
            
        }else{
            $result = false;
        }

        return $result;
    }

    /**
     * Delete a product 
     */

     public function deleteProductForm (array $product): mixed {

        
        $Product = $this->productDao->fromFieldsToObj($product);

        if (!is_null($Product)){
                $deleteProduct = $this->productDao->delete($Product);
                if ($deleteProduct === 1){
                    $result = true;
                }else if ($deleteProduct === 0){
                    $result = false;
                }
                
            }else{
                $result = null;
            }
            
        

        return $result;
    }

    /**
     * Modify a product 
     */

     public function modifyProductForm (array $product): mixed {

        
        $Product = $this->productDao->fromFieldsToObj($product);

        if (!is_null($Product)){
                $modifyProduct = $this->productDao->update($Product);
                if ($modifyProduct === 1){
                    $result = true;
                }else if ($modifyProduct === 0){
                    $result = false;
                }
                
            }else{
                $result = null;
            }
            
        

        return $result;
    }



    //USERS
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Searches all users from data source or an empty array if not found or in case of error
     */

    public function searchAllUsers(): ?array{
        
        $data = null;

        $data = $this->userDao->selectAll();
        
        return $data;
    }

    /**
     * Searches user given a string 
     * @param string username
     * @param string password
     * @return null if not found user, object User if found, false if password don't match
     */

     public function searchUser(string $user, string $pass): mixed {

        $data = $this->userDao->searchWhereUser($user);
        
        if (!is_null($data)){
            if ($pass !== $data->getPassword()){
                $data = false;
            }
        }else{
            $data = null;
        }

        return $data;

    }

    /**
     * Searches user given a int
     * @param int id
     * @return null if not found user, object User if found
     */

     public function searchIdU(int $id): ?User {

        $data = $this->userDao->UserById($id);
        
        if (!is_null($data)){
            $data = $this->userDao->UserById($id);
        }else{
            $data = null;
        }

        return $data;

    }

    /**
     * Add an user if the id is not foundent in the database
     */

    public function addUserForm (int $id, array $user): mixed {

        $idexist = $this->searchIdU($id);

        if (is_null($idexist)){
            $User = $this->userDao->fromFieldsToObj($user);
            if (!is_null($User)){
                $addUser = $this->userDao->insert($User);
                if ($addUser === 1){
                    $result = true;
                }else if ($addUser === 0){
                    $result = false;
                }else if ($addUser === 404){
                    $result = 404;
                }
                
            }else{
                $result = null;
            }
            
        }else{
            $result = false;
        }

        return $result;
    }

    /**
     * Delete an user 
     */

     public function deleteUserForm (array $user): mixed {

        
        $User = $this->userDao->fromFieldsToObj($user);

        if (!is_null($User)){
                $deleteUser = $this->userDao->delete($User);
                if ($deleteUser === 1){
                    $result = true;
                }else if ($deleteUser === 0){
                    $result = false;
                }
                
            }else{
                $result = null;
            }
            
        

        return $result;
    }

    /**
     * Modify an user 
     */

     public function modifyUserForm (array $user): mixed {

        
        $User = $this->userDao->fromFieldsToObj($user);

        if (!is_null($User)){
                $deleteUser = $this->userDao->update($User);
                if ($deleteUser === 1){
                    $result = true;
                }else if ($deleteUser === 0){
                    $result = false;
                }
                
            }else{
                $result = null;
            }
            
        

        return $result;
    }
}