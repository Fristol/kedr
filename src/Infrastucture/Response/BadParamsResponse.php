<?php

namespace App\Infrastucture\Response;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadParamsResponse extends ErrorResponse
{
	/**
	 * BadParamsResponse constructor.
	 *
	 * @param string                           $text
	 * @param ConstraintViolationListInterface $violations
	 * @param int                              $code
	 */
	public function __construct(string $text,ConstraintViolationListInterface $violations, int $code=0)
	{
		$formattedViolations=[];
		for ($i=0;$i<$violations->count();$i++)
		{
			$v=$violations->get($i);
			$formattedViolations[]=[
				"param"=>$v->getPropertyPath(),
				"message"=>$v->getMessage()
			];
		}
		parent::__construct($text,$code,["violations"=>$formattedViolations],static::HTTP_BAD_REQUEST);
	}
}
