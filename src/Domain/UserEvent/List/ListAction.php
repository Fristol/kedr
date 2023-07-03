<?php

namespace App\Domain\UserEvent\List;

use App\Entity\User\UserEvent;
use App\Repository\UserEventRepository;
use Doctrine\ORM\EntityManagerInterface;

class ListAction
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    public function execute(ListRequest $request)
    {
        /** @var UserEventRepository $repository */
        $repository=$this->entityManager->getRepository(UserEvent::class);

        $params=[];

        if ($request->isDefined("id")){
            $params["id"]=(int)$request->id;
        }
	    
        if ($request->isDefined("ids")){
		    $params["ids"]=(array)$request->ids;
	    }
	    
        if ($request->isDefined("userId")){
            $params["userId"]=(int)$request->userId;
        }

        $entities = $repository->search($params);

        return [
            "items"=>$entities??[],
        ];
    }
}
