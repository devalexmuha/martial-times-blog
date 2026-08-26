<?php
namespace App\Support;

use App\Repository\PagesRepository;
use Pagerfanta\Adapter\AdapterInterface;

class PagesAdapter implements AdapterInterface
{
	public function __construct(private PagesRepository $pagesRepository) {}

	public function getNbResults(): int
	{
		return $this->pagesRepository->count_all();
	}

	public function getSlice(int $offset, int $length): iterable
	{
		return $this->pagesRepository->fetch_slice($offset, $length);
	}
}