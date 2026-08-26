<?php

namespace App\Admin\Controller;

use App\Repository\PagesRepository;

abstract class AbstractAdminPagesController {

	public function __construct(
		protected PagesRepository $pagesRepository,
	) {
	}

	protected function render( string $view, array $pageData = [] ): void {
		extract( $pageData );
		ob_start();
		require __DIR__ . '/../../../views/admin/' . $view . '.php';

		$contents = ob_get_clean();

		require __DIR__ . '/../../../views/admin/layouts/main.view.php';
	}

	protected function error404() {
		http_response_code( 404 );
		$this->render( 'abstract/error.view', [] );
		exit();
	}
}
