<?php

namespace App\Admin\Controller;

use App\Repository\UsersRepository;
use App\Service\AuthService;

class AdminLogInController extends AbstractAdminPagesController {
	public function __construct(
		public UsersRepository $usersRepository,
		public AuthService $authService,
	) {
	}

	public function log_in(): void {
		if ( $this->authService->is_logged_in() ) {
			header( 'Location: index.php?route=admin/pages' );
			exit;
		}
		$error = false;
		$email = '';
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			$email      = trim( (string) ( $_POST['user-email'] ?? '' ) );
			$pass       = (string) ( $_POST['user-pass'] ?? '' );
			$isLoggedIn = $this->authService->verify_pass( $email, $pass );
			if ( $isLoggedIn ) {
				$this->authService->start_session( $email );
				header( 'Location: index.php?route=admin/pages' );
				exit;
			} else {
				$error = true;
				http_response_code( 403 );
			}
		}
		$this->render( 'log-in.view', [
			'error' => $error,
			'email' => $email,
		] );
		$error = false;
	}

	public function log_out(): void {
		$this->authService->end_session();
		header( 'Location: index.php?route=admin/log-in' );
	}
}