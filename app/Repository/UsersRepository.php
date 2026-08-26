<?php

namespace App\Repository;

use PDO;
use App\Model\UserModel;

class UsersRepository {
	function __construct( private PDO $pdo ) {
	}

	private function constructModel( array $entry ): UserModel {
		return new UserModel(
			(int) $entry['id'],
			(string) $entry['email'],
			(string) $entry['hash'],
			(string) $entry['user-type'],
		);
	}

	public function fetch_user( string $email ): ?UserModel {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `users` WHERE `email` = :email' );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->execute();
		$entry = $stmt->fetch();
		if ( $entry === false ) {
			return null;
		}

		return $this->constructModel( $entry );
	}

	public function fetch_pass( string $email ): ?string {
		$stmt = $this->pdo->prepare( 'SELECT `hash` FROM `users` WHERE `email` = :email' );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->execute();
		$entry = $stmt->fetch();
		if ( $entry === false ) {
			return null;
		}

		return $entry['hash'];
	}

	public function create_user( string $email, string $hash ): void {
		$stmt = $this->pdo->prepare( 'INSERT INTO `users` (`email`, `hash`) VALUES (:email, :hash)' );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->bindValue( ':hash', $hash, PDO::PARAM_STR );
		$stmt->execute();
	}

}