<?php

namespace App\Domain\User\Save;

use Symfony\Component\Validator\Constraints as Assert;
use App\Infrastucture\Validation\ValidationRequest;

class SaveRequest extends ValidationRequest
{
    /**
	 * @Assert\Positive(groups={"id"})
	 */
    public $id;

    /**
     * @Assert\NotBlank(groups={"login","create"})
     */
    public $login;

    /**
     * @Assert\NotBlank(groups={"password","create"})
     */
    public $password;
}
