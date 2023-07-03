<?php

namespace App\Entity\User;

use App\Infrastucture\Entity\AbstractLoggableEntity;
use App\Repository\UserEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserEventRepository::class)
 */
class UserEvent extends AbstractLoggableEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint", options={"unsigned":true, "comment":"Уникальный идентификатор"})
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", cascade={"persist"})
     * @ORM\JoinColumn(
     *     name="user_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE",
     *      nullable=false
     *     )
     */
    private User $user;

    /**
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     length=256,
     *     nullable=false,
     *     options={"comment":"Текст"}
     *     )
     */
    private string $title;

    /**
     * @ORM\Column(
     *     name="date_time",
     *     type="datetime",
     *     nullable=false,
     *     options={"comment":"Дата"}
     *     )
     */
    private \DateTime $dateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime(\DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "user_id"=>$this->user->getId(),
            "datetime" => $this->dateTime->format("Y-m-d H:i:s"),
        ];
    }
}
