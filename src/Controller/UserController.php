<?php

namespace App\Controller;

use App\Domain\User\Remove\RemoveAction;
use App\Domain\User\Save\SaveAction;
use App\Domain\User\Save\SaveRequest;
use App\Infrastucture\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        ValidatorInterface $validator,
        TranslatorInterface $translator,
    )
    {
        $this->validator=$validator;
        $this->translator = $translator;
    }

    /**
     * @Route("/user/{id}", name="user.save", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function saveAction($id, SaveRequest $request, SaveAction $action): JsonResponse
    {
        $request->setProperty("id",(int)$id);
        return $this->createAction($request, $action);
    }

    /**
     * @Route("/user", name="user.create", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function createAction(SaveRequest $request, SaveAction $action): JsonResponse
    {
        try
        {
            if (is_null($request->id)) $request->addValidatingGroup("create");
            $violationList=$this->validator->validate($request,null,$request->getDefinedPropertiesValidatingGroups());
            if ($violationList->count()>0)
            {
                return $this->badParamsResponse($this->translator->trans("badparams"),$violationList);
            }
            return $this->successResponse($action->execute($request));
        }
        catch(\Exception $exception)
        {
            return $this->errorResponse($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * @Route("/user/{id}", name="user.remove", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function removeAction(int $id, RemoveAction $action): JsonResponse
    {
        try
        {
            $action->execute($id);
        }
        catch(\Exception $exception)
        {
            return $this->errorResponse($exception->getMessage(),$exception->getCode());
        }
        return $this->successResponse();
    }
}
