<?php

namespace App\Service;

use App\Repository\UsersRepository;

class AuthService {
	public function __construct(
		public UsersRepository $usersRepository,
	) {
	}

	private function ensure_session() {
		if ( session_id() === '' ) {
			session_start();
		}
	}

	public function verify_pass( string $email, string $pass ): bool {
		$hash = $this->usersRepository->fetch_pass( $email );
		if ( ! $hash ) {
			return false;
		}

		return password_verify( $pass, $hash );
	}

	public function start_session( string $email ): void {
		$this->ensure_session();
		session_regenerate_id( true );
		$user                       = $this->usersRepository->fetch_user( $email );
		$_SESSION['user_id']        = $user->id;
		$_SESSION['user_type']      = $user->userType;
		$_SESSION['user_email']      = $user->email;
		$_SESSION['user_logged_in'] = true;
	}

	public function end_session(): void {
		$this->ensure_session();

		$_SESSION = [];
		if ( ini_get( "session.use_cookies" ) ) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}
		session_destroy();
	}

	public function is_logged_in(): bool {
		$this->ensure_session();

		return ! empty( $_SESSION['user_logged_in'] );
	}

	static function is_super_admin(): bool {
		if ( session_id() === '' ) {
			session_start();
		}
		return ! empty( $_SESSION['user_logged_in'] ) && $_SESSION['user_type'] === 'super_admin';
	}

	public function log_in_checker(): void {
		$this->ensure_session();
		if ( empty( $_SESSION['user_logged_in'] ) ) {
			header( 'Location: index.php?route=admin/log-in' );
		}
	}

	public function hash_pass( string $pass ): string {
		return password_hash( $pass, PASSWORD_DEFAULT );
	}
}