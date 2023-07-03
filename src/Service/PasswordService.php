<?php
namespace App\Service;


class PasswordService
{
	/**
	 * @param string $password
	 *
	 * @return string
	 */
	public function calculateHash(string $password): string
	{
		return \hash("sha256",$password,false);
	}
}