<?php

require_once 'model/Model.php';
require_once 'model/persist/ProductPersistFileDao.php';

$model = new Model();


$allProducts = $model->searchAllProducts();

$product = new ProductPersistFileDao('files/products.txt', ';');

$productone = $product->ProductById(2);


echo "<pre>";
print_r($productone);
echo "</pre>";