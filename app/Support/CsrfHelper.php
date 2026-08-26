<?php

namespace App\Support;

use App\Service\AuthService;

class CsrfHelper {

  function __construct(
    private AuthService $authService,
  ){}

  private function ensure_session() {
    if (session_id() === '') {
        session_start();
    }
  }

  public function gen_csrf_token(): string{
    $this->ensure_session();
    if(empty($_SESSION['csrf_token'])){
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }

  public function validate_csrf(): void {
    $this->gen_csrf_token();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(!empty($_POST['csrf_token']) 
        && !empty($_SESSION['csrf_token'])
        && $_POST['csrf_token'] === $_SESSION['csrf_token']){
          return;
      } else {
        $this->authService->end_session();
        header('Location: index.php?route=admin/log-out');
        exit;
      }
    }
  }
}