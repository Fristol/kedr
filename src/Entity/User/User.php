<?php

namespace App\Entity\User;

use App\Infrastucture\Entity\AbstractLoggableEntity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uidx__user__login", columns={"login"})
 *      }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends AbstractLoggableEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint", options={"unsigned":true, "comment":"Уникальный идентификатор"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(
     *     name="login",
     *     type="string",
     *     length=64,
     *     nullable=false,
     *     options={"comment":"Логин пользователя"}
     *     )
     */
    private string $login;

    /**
     * @ORM\Column(
     *     name="password",
     *     type="string",
     *     length=64,
     *     nullable=false,
     *     options={"comment":"Пароль пользователя"}
     *     )
     */
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "login"=>$this->login,
            "password"=>$this->password,
        ];
    }
}
