<?php

namespace App\Domain\UserEvent\Save;

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
		if ($request->request->has("user_event"))
		{
			$userEvent=\json_decode($request->request->get("user_event"),true);
			if (is_array($userEvent))
			{
                if (array_key_exists("title", $userEvent))
                {
                    $dto->setProperty("title", $userEvent["title"]);
                }
				if (array_key_exists("user_id", $userEvent))
				{
					$dto->setProperty("userId", $userEvent["user_id"]);
				}
				if (array_key_exists("date_time", $userEvent))
				{
                    $dateTime=$userEvent["date_time"]?\DateTime::createFromFormat("Y-m-d H:i:s", $userEvent["date_time"]):$userEvent["date_time"];
                    $dto->setProperty("dateTime", $dateTime?$dateTime:$userEvent["date_time"]);
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
