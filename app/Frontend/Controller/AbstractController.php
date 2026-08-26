<?php

namespace App\Frontend\Controller;

use App\Model\PageModel;
use App\Repository\PagesRepository;

abstract class AbstractController {

	public function __construct( protected PagesRepository $pagesRepository ) {
	}

	protected function render( string $view, array $pageData ): void {
		extract( $pageData );
		ob_start();
		require __DIR__ . '/../../../views/frontend/' . $view . '.php';
		$contents     = ob_get_clean();
		$allPagesData = $this->pagesRepository->fetch_nav();

		require __DIR__ . '/../../../views/frontend/layouts/main.view.php';
	}

	protected function error404() {
		http_response_code( 404 );
		$this->render( 'abstract/error.view', [] );
	}
}
