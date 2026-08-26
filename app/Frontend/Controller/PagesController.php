<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;
use App\Support\PagesAdapter;
use Pagerfanta\Pagerfanta;

class PagesController extends AbstractController {
	function __construct( protected PagesRepository $pagesRepository ) {
		parent::__construct( $pagesRepository );
	}

	public function render_single( string $pageKey ): void {
		$pageData = $this->pagesRepository->fetch_data_by_slug( $pageKey );

		if ( $pageData === false ) {
			$this->error404();
		} else {
			$this->render( "pages/page.view", [
				'pageData' => $pageData
			] );
		}
	}

	public function render_home(): void {
		$adapter    = new PagesAdapter( $this->pagesRepository );
		$pagerfanta = new Pagerfanta( $adapter );

		$pagerfanta->setMaxPerPage(5);
		$pagerfanta->setCurrentPage(max(1, min((int) ($_GET['paginate'] ?? 1), $pagerfanta->getNbPages())));

		$this->render( "pages/home.view", [
			'pager'    => $pagerfanta,
			'pageData' => $pagerfanta->getCurrentPageResults()
		] );
	}
}