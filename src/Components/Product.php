<?php

namespace PickPointSdk\Components;

class Product
{
    private $productCode;

    private $goodsCode;

    private $name;

    private $price;

    private $quantity;

    private $vat;

    private $description;


    /**
     * @return mixed
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param mixed $productCode
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @return mixed
     */
    public function getGoodsCode()
    {
        return $this->goodsCode;
    }

    /**
     * @param mixed $goodsCode
     */
    public function setGoodsCode($goodsCode)
    {
        $this->goodsCode = $goodsCode;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getProductArray()
    {
        return [
            'ProductCode' => $this->getProductCode() ?? '',
            'GoodsCode' => $this->getGoodsCode() ?? '',
            'Name' => $this->getName() ?? '',
            'Price' => $this->getPrice() ?? '',
            'Quantity' => $this->getQuantity() ?? '',
            'Vat' => $this->getVat() ?? '0',
            'Description' => $this->getDescription() ?? ''
        ];
    }
}