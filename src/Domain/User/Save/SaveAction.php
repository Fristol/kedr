<?php

namespace App\Domain\User\Save;

use App\Entity\User\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Service\PasswordService;
use Symfony\Contracts\Translation\TranslatorInterface;

class SaveAction
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	
	/**
	 * @var PasswordService
	 */
	private $passwordService;
	
	/**
	 * @var TranslatorInterface
	 */
	private $translator;
	
	public function __construct(
		EntityManagerInterface $entityManager,
		PasswordService $passwordService,
		TranslatorInterface $translator
	) {
		$this->entityManager=$entityManager;
		$this->passwordService=$passwordService;
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
		/** @var UserRepository $repository */
		$repository=$this->entityManager->getRepository(User::class);
		if (is_null($request->id))
		{
			$entity=$repository->create();
		}
		else
		{
			$entity=$repository->findOneById($request->id);
			if (is_null($entity)) throw new \Exception($this->translator->trans("user.notfound.byid", ['id' => $request->id]));
		}
		if ($request->isDefined("login"))
		{
			$entity->setLogin($request->login);
		}
		if ($request->isDefined("password"))
		{
			$entity->setPassword($this->passwordService->calculateHash($request->password));
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
