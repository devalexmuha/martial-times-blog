<?php
namespace App\Support;

use App\Repository\PagesRepository;
use Pagerfanta\Adapter\AdapterInterface;

class AdminPagesAdapter implements AdapterInterface
{
	public function __construct(private PagesRepository $pagesRepository) {}

	public function getNbResults(): int
	{
		return $this->pagesRepository->count_all_by_user($_SESSION['user_email']);
	}

	public function getSlice(int $offset, int $length): iterable
	{
		return $this->pagesRepository->fetch_slice_by_user($offset, $length, $_SESSION['user_email']);
	}
}