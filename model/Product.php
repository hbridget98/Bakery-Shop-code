<?php

/**
 * ADT for product.
 *
 * @author Andrea
 */


class Product {

    private int $id; //PK
    private ?string $description; 
    private ?float $price;
    private ?int $stock;

    public function __construct(int $id, string $description = null, float $price = null, int $stock = null) {
        $this->id = $id;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setPrice(string $price): void {
        $this->price = $price;
    }

    public function setStock(string $stock): void {
        $this->stock = $stock;
    }

    public function __toString(): string {
        $result = "Product{";
        $result .= sprintf("[id=%d]", $this->id);
        $result .= sprintf("[description=%s]", $this->description);
        $result .= sprintf("[price=%f]", $this->price);
        $result .= sprintf("[stock=%d]", $this->stock);
        $result .= "}";
        return $result;
    }
  
}