<?php

namespace App\Domain\User\Remove;

use App\Entity\User\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RemoveAction
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
	{
		$this->entityManager=$entityManager;
        $this->translator = $translator;
	}
	
	/**
	 * @param int $id
	 *
	 * @throws \Exception
	 */
	public function execute(int $id)
    {
    	/** @var UserRepository $repository */
	    $repository=$this->entityManager->getRepository(User::class);
	    $entity=$repository->findOneById($id);
	    if (is_null($entity)) throw new \Exception($this->translator->trans("user.notfound.byid", ['id' => $id]));
        $repository->remove($entity);
	    $this->entityManager->flush();
    }
}
