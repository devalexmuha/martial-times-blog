<?php
declare( strict_types=1 );

namespace App\Admin\Controller;

use App\Repository\PagesRepository;
use App\Service\AuthService;
use App\Support\AdminPagesAdapter;
use App\Support\PagesAdapter;
use JetBrains\PhpStorm\NoReturn;
use Pagerfanta\Pagerfanta;


class AdminPagesController extends AbstractAdminPagesController {
	function __construct(
		protected PagesRepository $pagesRepository,
	) {
		parent::__construct( $pagesRepository );
	}

	protected function is_owner(int $id): bool {
		$pageData = $this->pagesRepository->fetch_data_by_id( $id );
		return $_SESSION['user_type'] === 'super_admin' || $pageData !== null && $pageData->author === $_SESSION['user_email'];
	}

	public function render_page(): void {
		if ( AuthService::is_super_admin() ) {
			$adapter    = new PagesAdapter( $this->pagesRepository );
		} else {
			$adapter    = new AdminPagesAdapter( $this->pagesRepository );
		}
		$pagerfanta = new Pagerfanta( $adapter );

		$pagerfanta->setMaxPerPage(8);
		$pagerfanta->setCurrentPage(max(1, min((int) ($_GET['paginate'] ?? 1), $pagerfanta->getNbPages())));

		$this->render( "pages/page.view", [
			'pager'    => $pagerfanta,
			'pageData' => $pagerfanta->getCurrentPageResults()
		] );
	}

	public function add(): void {
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( ! empty( $_POST['name'] ) ) {
				$name           = (string) $_POST['name'];
				$slug           = ! empty( seoSlug( $_POST['slug'] ) ) ? seoSlug( $_POST['slug'] ) : seoSlug( $name );
				$text           = ( (string) $_POST['text'] ) ?? null;
				$date_published = format_date( $_POST['date_published'] ) ?? date( 'Y-m-d H:i:s' );
				$date_updated   = format_date( $_POST['date_published'] ) ?? date( 'Y-m-d H:i:s' );
				$author         = (string) ( $_SESSION['user_email'] ?? 'default@default' );
				$image_url      = (string) image_upload( $_FILES );
				$this->pagesRepository->add( $name, $slug, $text, $date_published, $date_updated, $author, $image_url );
				header( 'Location: index.php?route=admin/pages' );
			}
		}
		$this->render( "pages/add.view", [] );
	}

	#[NoReturn]
	public function delete( int $id ): void {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty( $id ) || !$this->is_owner($id) ) {
			header( 'Location: index.php?route=admin/pages' );
			exit();
		}

		$this->pagesRepository->delete( $id );
		header( 'Location: index.php?route=admin/pages' );
		exit();
	}

	public function edit( int $id ): void {
		if ( empty( $id ) || !$this->is_owner($id) ) {
			$this->error404();
		}

		$pageData = $this->pagesRepository->fetch_data_by_id( $id );

		if ( empty( $pageData ) ) {
			$this->error404();
		}

		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( ! empty( $_POST['name'] ) ) {
				$name           = (string) $_POST['name'];
				$slug           = ! empty( seoSlug( $_POST['slug'] ) ) ? seoSlug( $_POST['slug'] ) : seoSlug( $name );
				$text           = ( (string) $_POST['text'] ) ?? null;
				$date_published = format_date( $_POST['date_published'] ) ?? date( 'Y-m-d H:i:s' );
				$date_updated   = date( 'Y-m-d H:i:s' );
				$author         = (string) ( $_SESSION['user_email'] ?? 'default@default' );
				$image_url      = image_upload( $_FILES ) ?? $pageData->image_url;
				$this->pagesRepository->edit( $id, $name, $slug, $text, $date_published, $date_updated, $author,
					$image_url );
				header( 'Location: index.php?route=admin/pages' );
				exit();
			}
		}

		$this->render( "pages/edit.view", [
			'pageData' => $pageData,
		] );
	}
}