<?php

namespace App\Domain\UserEvent\Save;

use Symfony\Component\Validator\Constraints as Assert;
use App\Infrastucture\Validation\ValidationRequest;

class SaveRequest extends ValidationRequest
{
    /**
	 * @Assert\Positive(groups={"id"})
	 */
    public $id;

    /**
     * @var int
     * @Assert\Positive(groups={"userId", "create"})
     * @Assert\NotNull(groups={"userId", "create"})
     */
    public $userId;

    /**
     * @Assert\NotBlank(groups={"title","create"})
     */
    public $title;

    /**
     * @var \DateTime
     * @Assert\NotNull(groups={"dateTime", "create"})
     */
    public $dateTime;
}
