<?php

namespace App\Infrastucture\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SAC;
use App\Infrastucture\Response\ErrorResponse;
use App\Infrastucture\Response\BadParamsResponse;
use App\Infrastucture\Response\SuccessResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AbstractController extends SAC
{
	/**
	 * @param string $text
	 * @param int    $code
	 * @param null|mixed   $details
	 * @param int    $httpCode
	 *
	 * @return ErrorResponse
	 */
	protected function errorResponse(string $text, int $code=0, $details=null, int $httpCode=500): ErrorResponse
	{
		return new ErrorResponse($text,$code,$details,$httpCode);
	}
	
	/**
	 * @param string                           $text
	 * @param ConstraintViolationListInterface $violations
	 * @param int                              $code
	 *
	 * @return BadParamsResponse
	 */
	protected function badParamsResponse(string $text, ConstraintViolationListInterface $violations, int $code=0): BadParamsResponse
	{
		return new BadParamsResponse($text,$violations,$code);
	}
	
	/**
	 * @param mixed|null $data
	 *
	 * @return SuccessResponse
	 */
	protected function successResponse($data=null): SuccessResponse
	{
		return new SuccessResponse($data);
	}
}
