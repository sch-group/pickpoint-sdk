<?php

namespace PickPointSdk\Components;

class Product
{
    /**
     * @var string
     */
    private $productCode;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $goodsCode;

    /**
     * @var float
     */
    private $vat;

    /**
     * @var string
     */
    private $description;

    /**
     * Product constructor.
     * @param string $productCode
     * @param string $name
     * @param int $quantity
     * @param float $price
     * @param string $goodsCode
     * @param float $vat
     * @param string $description
     */
    public function __construct(string $productCode, string $name, int $quantity, float $price, string $goodsCode = '', float $vat = 0, string $description = '')
    {
        $this->productCode = $productCode;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->goodsCode = $goodsCode;
        $this->vat = $vat;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getGoodsCode(): string
    {
        return $this->goodsCode ?? '';
    }

    /**
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat ?? 0;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? 0;
    }

    public function toArray()
    {
        return [
            'ProductCode' => $this->getProductCode(),
            'GoodsCode' => $this->getGoodsCode(),
            'Name' => $this->getName(),
            'Price' => $this->getPrice(),
            'Quantity' => $this->getQuantity(),
            'Vat' => $this->getVat(),
            'Description' => $this->getDescription()
        ];
    }
}