<?php

namespace App\Domain\UserEvent\List;

use App\Infrastucture\Validation\ValidationRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ListRequest extends ValidationRequest
{
    /**
     * @var int|null
     * @Assert\Positive(groups={"id"})
     */
    public $id;
	
	/**
	 * @var array|null
	 * @Assert\Type(type="array",groups={"ids"})
	 */
	public $ids;

    /**
     * @var int|null
     * @Assert\Positive(groups={"userId"})
     */
    public $userId;
}