<?php
declare(strict_types=1);

date_default_timezone_set('Europe/Kyiv');

require_once __DIR__ . '/../inc/all.inc.php';

$container = new App\Support\Container();
$container->bind('pdo', function(){
  return require_once __DIR__ . '/../inc/db-connect.inc.php';
});
$container->bind('pagesRepository', function($container){
  return new App\Repository\PagesRepository($container->get('pdo'));
});
$container->bind('usersRepository', function($container){
  return new App\Repository\UsersRepository($container->get('pdo'));
});
$container->bind('authService', function($container){
  return new App\Service\AuthService($container->get('usersRepository'));
});
$container->bind('pagesController', function($container){
  return new App\Frontend\Controller\PagesController($container->get('pagesRepository'));
});
$container->bind('notFoundController', function($container){
  return new App\Frontend\Controller\NotFoundController($container->get('pagesRepository'));
});
$container->bind('adminPagesController', function($container){
  return new App\Admin\Controller\AdminPagesController(
    $container->get('pagesRepository'),
    );
});
$container->bind('adminLogInController', function($container){
  return new App\Admin\Controller\AdminLogInController(
    $container->get('usersRepository'),
    $container->get('authService'),
    );
});
$container->bind('adminRegisterController', function($container){
	return new App\Admin\Controller\AdminRegisterController(
		$container->get('usersRepository'),
		$container->get('authService'),
	);
});
$container->bind('csrfHelper', function($container){
  return new App\Support\CsrfHelper($container->get('authService'));
});

function getCsrfToken(): string{
  global $container;
  $csrfHelper = $container->get('csrfHelper');
  return $csrfHelper->gen_csrf_token();
}

$csrfHelper = $container->get('csrfHelper');
$csrfHelper->validate_csrf();

$route = (string) ($_GET['route'] ?? 'pages');

if($route === 'pages'){
  $pagesController = $container->get('pagesController');
	if(empty($_GET['page'])){
		$pagesController->render_home();
	} else {
		$pageKey = (string) $_GET['page'];
		$pagesController->render_single( $pageKey );
	}
} else if ($route === 'admin/pages') {
  $authService = $container->get('authService');
  $authService->log_in_checker();
  $adminPagesController = $container->get('adminPagesController');
  $adminPagesController->render_page();
} else if ($route === 'admin/pages/add'){
  $authService = $container->get('authService');
  $authService->log_in_checker();
  $adminPagesController = $container->get('adminPagesController');
  $adminPagesController->add();
} else if ($route === 'admin/pages/delete'){
  $authService = $container->get('authService');
  $authService->log_in_checker();
  $id = (int) ($_GET['id'] ?? null);
  $adminPagesController = $container->get('adminPagesController');
  $adminPagesController->delete($id);
} else if ($route === 'admin/pages/edit'){
  $authService = $container->get('authService');
  $authService->log_in_checker();
  $id = (int) ($_GET['id'] ?? null);
  $adminPagesController = $container->get('adminPagesController');
  $adminPagesController->edit($id);
} else if ($route === 'admin/log-in') {
  $adminLogInController = $container->get('adminLogInController');
  $adminLogInController->log_in();
} else if ($route === 'admin/register') {
	$adminRegisterController = $container->get('adminRegisterController');
	$adminRegisterController->user_register();
}
  else if ($route === 'admin/log-out') {
  $adminLogInController = $container->get('adminLogInController');
  $adminLogInController->log_out();
}

else{
    $notFoundController = $container->get('notFoundController');
    $notFoundController->error404();
}