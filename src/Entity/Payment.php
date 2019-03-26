<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Payum\Core\Model\Payment as BasePayment;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment extends BasePayment
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $readableStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentGateway;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReadableStatus(): ?string
    {
        return $this->readableStatus;
    }

    public function setReadableStatus(?string $readableStatus): self
    {
        $this->readableStatus = $readableStatus;

        return $this;
    }

    public function getPaymentGateway(): ?string
    {
        return $this->paymentGateway;
    }

    public function setPaymentGateway(?string $paymentGateway): self
    {
        $this->paymentGateway = $paymentGateway;

        return $this;
    }
}
