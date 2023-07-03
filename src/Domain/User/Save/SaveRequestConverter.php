<?php

namespace App\Domain\User\Save;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveRequestConverter implements ParamConverterInterface
{
	/**
	 * @inheritdoc
	 */
	public function apply(Request $request, ParamConverter $configuration)
	{
		$param = $configuration->getName();

		$dto = new SaveRequest;
		if ($request->request->has("user"))
		{
			$user=\json_decode($request->request->get("user"),true);
			if (is_array($user))
			{
				if (array_key_exists("login", $user))
				{
					$dto->setProperty("login", $user["login"]);
				}
				if (array_key_exists("password", $user))
				{
					$dto->setProperty("password", $user["password"]);
				}
			}
		}

		$request->attributes->set($param, $dto);
		
		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function supports(ParamConverter $configuration): bool
	{
		return $configuration->getClass() === SaveRequest::class;
	}
}
