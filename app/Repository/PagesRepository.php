<?php

namespace App\Repository;

use PDO;
use App\Model\PageModel;

class PagesRepository {
	function __construct( private PDO $pdo ) {
	}

	private function constructModel( array $entry ): PageModel {
		return new PageModel(
			(int) $entry['id'],
			(string) $entry['name'],
			(string) $entry['slug'],
			(string) $entry['text'],
			(string) $entry['date_published'],
			(string) $entry['date_updated'],
			(string) $entry['author'],
			(string) $entry['image_url'],
		);
	}

	public function fetch_data_by_slug( string $slug ): PageModel|false {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `pages` WHERE `slug` = :slug' );
		$stmt->bindValue( ':slug', $slug, PDO::PARAM_STR );
		$stmt->execute();
		$entry = $stmt->fetch();
		if ( $entry === false ) {
			return false;
		}

		return $this->constructModel( $entry );
	}

	public function fetch_data_by_user( string $email ): array|false {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `pages` WHERE `author` = :email ORDER BY `date_updated` DESC' );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->execute();
		$entries = $stmt->fetchAll();
		$models = [];
		if ( empty($entries) ) {
			return false;
		}
		foreach ( $entries as $entry ) {
			$models[] = $this->constructModel( $entry );
		}

		return $models;
	}

	public function fetch_data_by_id( int $id ): ?PageModel {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `pages` WHERE `id` = :id' );
		$stmt->bindValue( ':id', $id, PDO::PARAM_STR );
		$stmt->execute();
		$entry = $stmt->fetch();
		if ( $entry === false ) {
			return null;
		}

		return $this->constructModel( $entry );
	}


	public function fetch_nav(): array {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `pages` ORDER BY `id` ASC' );
		$stmt->execute();
		$entries = $stmt->fetchAll( PDO::FETCH_ASSOC );
		$models  = [];
		foreach ( $entries as $entry ) {
			$models[] = $this->constructModel( $entry );
		}

		return $models;
	}

	public function fetch_all(): array {
		$stmt = $this->pdo->prepare( 'SELECT * FROM `pages` ORDER BY `date_updated` DESC' );
		$stmt->execute();
		$entries = $stmt->fetchAll( PDO::FETCH_ASSOC ); // what $entries holds
		$models  = [];
		foreach ( $entries as $entry ) {
			$models[] = $this->constructModel( $entry );
		}

		return $models;
	}

	public function add(
		string $name,
		string $slug,
		?string $text,
		string $date_published,
		string $date_updated,
		string $author,
		?string $image_url
	): void {
		$stmt = $this->pdo->prepare(
			'INSERT INTO `pages`
            (`name`, `slug`, `text`, `date_published`, `date_updated`, `author`, `image_url`)
         VALUES
            (:name, :slug, :text, :date_published, :date_updated, :author, :image_url)'
		);
		$stmt->bindValue( ':name', $name, PDO::PARAM_STR );
		$stmt->bindValue( ':slug', $slug, PDO::PARAM_STR );
		$stmt->bindValue( ':text', $text, PDO::PARAM_STR );
		$stmt->bindValue( ':date_published', $date_published, PDO::PARAM_STR );
		$stmt->bindValue( ':date_updated', $date_updated, PDO::PARAM_STR );
		$stmt->bindValue( ':author', $author, PDO::PARAM_STR );
		$stmt->bindValue( ':image_url', $image_url, PDO::PARAM_STR );
		$stmt->execute();
	}

	public function edit(
		int $id,
		string $name,
		string $slug,
		?string $text,
		string $date_published,
		string $date_updated,
		string $author,
		?string $image_url
	): void {
		$stmt = $this->pdo->prepare(
			'UPDATE `pages` SET `name` = :name, `slug` = :slug, `text` = :text, `date_published` = :date_published, `date_updated` = :date_updated, `author` = :author, `image_url` = :image_url 
               WHERE `id` = :id' );
		$stmt->bindValue( ':name', $name, PDO::PARAM_STR );
		$stmt->bindValue( ':slug', $slug, PDO::PARAM_STR );
		$stmt->bindValue( ':text', $text, PDO::PARAM_STR );
		$stmt->bindValue( ':date_published', $date_published, PDO::PARAM_STR );
		$stmt->bindValue( ':date_updated', $date_updated, PDO::PARAM_STR );
		$stmt->bindValue( ':author', $author, PDO::PARAM_STR );
		$stmt->bindValue( ':image_url', $image_url, PDO::PARAM_STR );
		$stmt->bindValue( ':id', $id, PDO::PARAM_INT );
		$stmt->execute();
	}

	public function delete( int $id ): void {
		$stmt = $this->pdo->prepare(
			'DELETE FROM pages WHERE `id` = :id'
		);
		$stmt->bindValue( ':id', $id, PDO::PARAM_STR );
		$stmt->execute();
	}

	public function count_all(): int {
		$stmt = $this->pdo->prepare( 'SELECT COUNT(*) FROM `pages`' );
		$stmt->execute();
		return (int) $stmt->fetchColumn();
	}

	public function fetch_slice( int $offset, int $length ): array {
		$stmt = $this->pdo->prepare(
			'SELECT * FROM `pages` ORDER BY `date_updated` DESC LIMIT :length OFFSET :offset'
		);
		$stmt->bindValue( ':length', $length, PDO::PARAM_INT );
		$stmt->bindValue( ':offset', $offset, PDO::PARAM_INT );
		$stmt->execute();

		$models = [];
		foreach ( $stmt->fetchAll() as $entry ) {
			$models[] = $this->constructModel( $entry );
		}

		return $models;
	}

	public function count_all_by_user(string $email): int {
		$stmt = $this->pdo->prepare( 'SELECT COUNT(*) FROM `pages` WHERE `author` = :email' );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->execute();
		return (int) $stmt->fetchColumn();
	}

	public function fetch_slice_by_user( int $offset, int $length, string $email ): array {
		$stmt = $this->pdo->prepare(
			'SELECT * FROM `pages` WHERE `author` = :email ORDER BY `date_published` DESC LIMIT :length OFFSET :offset'
		);
		$stmt->bindValue( ':length', $length, PDO::PARAM_INT );
		$stmt->bindValue( ':offset', $offset, PDO::PARAM_INT );
		$stmt->bindValue( ':email', $email, PDO::PARAM_STR );
		$stmt->execute();

		$models = [];
		foreach ( $stmt->fetchAll() as $entry ) {
			$models[] = $this->constructModel( $entry );
		}

		return $models;
	}
}