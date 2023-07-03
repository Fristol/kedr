<?php

namespace App\Infrastucture\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractLoggableEntity implements \JsonSerializable
{
	/**
	 * @var int|null
	 * @ORM\Column(type="bigint", nullable=true, options={"unsigned":true, "comment":"Идентификатор пользователя создавшего(изменившего) запись"})
	 */
	private $editUserId;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", options={"comment":"Дата и время создания(изменения) записи"})
	 */
	private $editDateTime;
	
	/**
	 * @var int
	 * @ORM\Column(type="integer", options={"unsigned":true, "comment":"Версия записи"})
	 */
	private $version;
	
	/**
	 * @return int|null
	 */
	public function getEditUserId() : ?int
	{
		return $this->editUserId;
	}
	
	/**
	 * @param int|null $editUserId
	 *
	 * @return AbstractLoggableEntity
	 */
	public function setEditUserId(?int $editUserId) : AbstractLoggableEntity
	{
		$this->editUserId=$editUserId;
		return $this;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getEditDateTime() : ?\DateTime
	{
		return $this->editDateTime;
	}
	
	/**
	 * @param \DateTime $editDateTime
	 *
	 * @return AbstractLoggableEntity
	 */
	public function setEditDateTime(\DateTime $editDateTime) : AbstractLoggableEntity
	{
		$this->editDateTime=$editDateTime;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getVersion() : ?int
	{
		return $this->version;
	}
	
	/**
	 * @param int $version
	 *
	 * @return AbstractLoggableEntity
	 */
	public function setVersion(int $version) : AbstractLoggableEntity
	{
		$this->version=$version;
		return $this;
	}
	
	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return [
			"edit_user_id"=>$this->getEditUserId(),
			"version"=>$this->version,
			"edit_date_time"=>$this->editDateTime?$this->editDateTime->format("Y-m-d H:i:s"):null
		];
	}
	
}
