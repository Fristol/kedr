<?php

namespace App\Controller;

use App\Domain\UserEvent\List\ListAction;
use App\Domain\UserEvent\List\ListRequest;
use App\Domain\UserEvent\Save\SaveAction;
use App\Domain\UserEvent\Save\SaveRequest;
use App\Infrastucture\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserEventController extends AbstractController
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
     * @Route("/user/event/{id}", name="user.event.save", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function saveAction($id, SaveRequest $request, SaveAction $action): JsonResponse
    {
        $request->setProperty("id",(int)$id);
        return $this->createAction($request, $action);
    }

    /**
     * @Route("/user/event/list", name="user.event.list", methods={"GET"})
     */
    public function listAction(ListRequest $request, ListAction $action): JsonResponse
    {
        try
        {
            $violationList=$this->validator->validate($request,null,$request->getDefinedPropertiesValidatingGroups());
            if ($violationList->count()>0)
            {
                return $this->badParamsResponse($this->translator->trans("badparams"),$violationList);
            }
            $result=\json_decode(\json_encode($action->execute($request)));
            return $this->successResponse($result);
        }
        catch(\Exception $exception)
        {
            return $this->errorResponse($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * @Route("/user/event", name="user.event.create", methods={"POST"}, requirements={"id"="\d+"})
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
}
