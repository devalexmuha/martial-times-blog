<?php

namespace App\Admin\Controller;

use App\Repository\UsersRepository;
use App\Service\AuthService;

class AdminRegisterController extends AbstractAdminPagesController {
	public function __construct(
		public UsersRepository $usersRepository,
		public AuthService $authService,
	) {
	}

	public function user_register(): void {
		if (!$this->authService->is_super_admin()) {
			$this->error404();
			exit;
		}

		$error = false;
		$email = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email      = trim((string) ($_POST['user-email'] ?? ''));
			$pass       = (string) ($_POST['user-pass'] ?? '');
			$verifyPass = (string) ($_POST['verify_pass'] ?? '');

			$isValid = $email !== ''
			           && $pass !== ''
			           && $verifyPass !== ''
			           && $pass === $verifyPass;

			if ($isValid) {
				$hash = $this->authService->hash_pass($pass);
				$this->usersRepository->create_user($email, $hash);
				header('Location: index.php?route=admin/pages');
				exit;
			}

			$error = true;
		}

		$this->render('register.view', [
			'error' => $error,
			'email' => $email,
		]);
	}
}