<?php

namespace App\Infrastucture\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
	/**
	 * ErrorResponse constructor.
	 *
	 * @param string $text
	 * @param int    $code
	 * @param null|mixed   $details
	 * @param int    $httpCode
	 */
	public function __construct(string $text, int $code=0, $details=null, int $httpCode=500)
	{
		
		parent::__construct([
			"status"=>"error",
			"error"=>array_merge([
				"code"=>$code,
				"text"=>$text
				],is_null($details)?[]:["details"=>$details])
			],$httpCode);
	}
}
