<?php

namespace App\Infrastucture\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class SuccessResponse extends JsonResponse
{
	/**
	 * SuccessResponse constructor.
	 *
	 * @param null|mixed $data
	 */
	public function __construct($data=null)
	{
		parent::__construct(array_merge([
			"status"=>"success"
		],is_null($data)?[]:["result"=>$data]));
	}
}
