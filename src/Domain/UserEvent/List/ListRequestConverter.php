<?php

namespace App\Domain\UserEvent\List;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ListRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritdoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();

        $dto = new ListRequest();

        if ($request->query->has("id"))
        {
            $dto->setProperty("id", $request->query->get("id"));
        }
	    if ($request->query->has("ids"))
	    {
		    $dto->setProperty("ids", $request->query->get("ids"));
	    }
        if ($request->query->has("user_id"))
        {
            $dto->setProperty("userId", $request->query->get("user_id"));
        }

        $request->attributes->set($param, $dto);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === ListRequest::class;
    }
}