<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Payum\Core\Model\Token;

/**
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Repository\PaymentTokenRepository")
 */
class PaymentToken extends Token
{
    use TimestampableEntity;
}
