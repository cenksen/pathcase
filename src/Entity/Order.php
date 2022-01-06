<?php

declare(strict_types=1);

namespace App\Entity;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_order")
 * @ORM\Entity()
 */
class Order
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="shipping_date", type="datetime")
     */
    public $shippingDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_code", type="string", length=100)
     */
    public $orderCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=10000)
     */
    public $address;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    public $quantity;

    /**
     * @var int|null
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    public $productId;

    /**
     * @var Collection|User[]
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getShippingDate(): ?\DateTime
    {
        return Carbon::make($this->shippingDate);
    }

    /**
     * @param \DateTime|null $shippingDate
     */
    public function setShippingDate(?\DateTime $shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }

    /**
     * @return string|null
     */
    public function getOrderCode(): ?string
    {
        return $this->orderCode;
    }

    /**
     * @param string|null $orderCode
     */
    public function setOrderCode(?string $orderCode): void
    {
        $this->orderCode = $orderCode;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @param int|null $productId
     */
    public function setProductId(?int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->user;
    }

    /**
     * @param User[]|Collection $user
     */
    public function setUsers($user): void
    {
        $this->user = $user;
    }
}