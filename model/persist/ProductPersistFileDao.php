<?php
require_once "model/Product.php";
/**
 *  DAO for product persistence in file.
 *
 * @author Andrea
 */
class ProductPersistFileDao {

     /**
     * the path to file.
     */
    private string $filename;
    /**
     * the delimiter used to split fields.
     */
    private string $delimiter;

    public function __construct(string $filename, string $delimiter) {
        $this->filename = $filename;
        $this->delimiter = $delimiter;       
    }
    
    /**
     * selects all objects.
     * @return array with all fields.
     */
    public function selectAll(): array {
        $objList = array();  //array to return.
        $handle = fopen($this->filename, "rb");  //open file to read.
        if ($handle !== false) { //if open.
            while (($fields = fgetcsv($handle, 0,  $this->delimiter)) !== false) { //read a csv line into array of fields.
                //instanciate an object with given data.
                $obj = $this->fromFieldsToObj($fields);
                //add object to array.
                array_push($objList, $obj);
            }
            fclose($handle);
        }
        return $objList;
    }


    /**
     * Given an id return a product object if found or null
     * @param int id of product
     * @return object Product if found or null if not
     */
    public function ProductById( int $id): ?Product{
        $resultObj = null;
        //get all data.
        $objList = $this->selectAll();
        for ($index = 0; $index < count($objList); $index++) {
            $elem = $objList[$index];
            if ($elem->getId()=== $id) {
                $resultObj = $elem;  
                break;
            }
        }
        return $resultObj;
    }

       

    /**
     * saves array with all data in file.
     * @param $data the array to save to file.
     * @return number of elements written.
     */
    public function saveAll($data): int {
        $handle = fopen($this->filename, "wb");  //open file to read.
        $count = 0;
        foreach ($data as $obj) {
            //convert object to csv.
            $success = fputcsv($handle, (array) $obj, $this->delimiter);
            $count += ($success) ? 1 : 0;
        }
        fclose($handle);
        return $count;
    }

    /**
     * inserts a new object in file.
     * @param $obj the object to insert.
     * @return number of objects written.
     */
    public function insert(Product $obj): int {
        $handle = @fopen($this->filename, "ab");  //open file to read.
        //convert object to csv.
        if ($handle === false){
            $success = 404;
        }else{
            $success = @fputcsv($handle, (array) $obj, $this->delimiter);
            if ($success === false){
                $success = 0;
            }else {
                $success = 1;
            }
            fclose($handle);
        }
        
        return $success;
    }

    /**
     * deletes object from file.
     * @param $obj the object to delete.
     * @return number of objects deleted.
     */
    public function delete(Product $obj): int {
        $result = 0;
        //get all data.
        $objList = $this->selectAll();
        //get object position.
        $index = $this->arraySearchIndex($objList, $obj);
        if ($index >= 0) {  //if found.
            array_splice($objList, $index, 1);  //remove object.
            $result = 1;
            $this->saveAll($objList);  //save list to file.
        }
        return $result;
    }

    /**
     * updates object in file.
     * @param $obj the object to update.
     * @return number of objects updated.
     */
    public function update(Product $obj): int {
        $result = 0;
        //get all data.
        $objList = $this->selectAll();
        //get object position.
        $index = $this->arraySearchIndex($objList, $obj);
        if ($index >= 0) {  //if found.
            $objList[$index] = $obj;  //replace object.
            $result = 1;
            $this->saveAll($objList);  //save list to file.
        }
        return $result;
    }

    /**
     * searches object in array.
     * @param $list the array to search in.
     * @param $obj the object to search.
     * @return int object position or -1 if not found.
     */
    public function arraySearchIndex(array $list, Product $obj): int {
        $index = -1;
        for ($i=0; $i<count($list); $i++) {
            if ($list[$i]->getId() == $obj->getId()) {
                $index = $i;
            }
        }
        return $index;
    }

    /**
     * converts array to object
     * @param $fields the fields to convert to object.
     * @return object or null in case of error.
     */
    public function fromFieldsToObj(array $fields): ?Product {
        $id =  intval($fields[0]);
        $description = $fields[1];
        $price = floatval($fields[2]);
        $stock = intval($fields[3]);
        $obj = new Product($id, $description, $price, $stock);
        return $obj;
    }
}