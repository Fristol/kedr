<?php

namespace App\Domain\UserEvent\Save;

use App\Entity\User\User;
use App\Entity\User\UserEvent;
use App\Repository\UserEventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Contracts\Translation\TranslatorInterface;

class SaveAction
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	
	/**
	 * @var TranslatorInterface
	 */
	private $translator;
	
	public function __construct(
		EntityManagerInterface $entityManager,
		TranslatorInterface $translator
	) {
		$this->entityManager=$entityManager;
		$this->translator = $translator;
	}
	
	/**
	 * @param SaveRequest $request
	 *
	 * @return array|null
	 * @throws \Exception
	 */
	public function execute(SaveRequest $request)
	{
		/** @var UserEventRepository $repository */
		$repository=$this->entityManager->getRepository(UserEvent::class);

        /** @var UserRepository $userRepository */
        $userRepository=$this->entityManager->getRepository(User::class);

		if (is_null($request->id))
		{
			$entity=$repository->create();
		}
		else
		{
			$entity=$repository->findOneById($request->id);
			if (is_null($entity)) throw new \Exception($this->translator->trans("userevent.notfound.byid", ['id' => $request->id]));
		}
		if ($request->isDefined("userId"))
		{
            $user = $userRepository->findOneById($request->userId);
            if (is_null($user)) throw new \Exception($this->translator->trans("user.notfound.byid", ['id' => $request->userId]));
            $entity->setUser($user);
		}
        if ($request->isDefined("title"))
        {
            $entity->setTitle($request->title);
        }
        if ($request->isDefined("dateTime"))
        {
            $entity->setDateTime($request->dateTime);
        }
		
		try
		{
			$this->entityManager->flush();
		}
		catch(\Exception $exception)
		{
			if ($exception instanceof UniqueConstraintViolationException)
			{
				throw new \Exception($this->translator->trans("unique_constraint_exception"), $exception->getCode());
			}
			throw $exception;
		}
		
		return $request->id?null:["id" => $entity->getId()];
	}
}
