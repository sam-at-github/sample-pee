<?php
use Pee\App;
chdir(dirname(__file__));
require_once '../vendor/autoload.php';
require_once '../errors.php';
$app = App::instance('../config.yml');
$pagesController = new PagesController($app);
$app->addRoute('GET /', [$pagesController, 'home']);
$app->addRoute('GET /@path', [$pagesController, 'home']);
$app->addRoute('GET /@@path', [$pagesController, 'home']);
$app->run();

class PagesController
{
  private $twig;

  public function __construct(\Pee\App $app) {
    $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem($app['TEMPLATES']));
  }

  public function beforeRoute(\Pee\App $app) {
  }

  public function afterRoute(\Pee\App $app, $result) {
  }

  public function onException(\Pee\App $app, \Exception $exception) {
    echo $this->twig->render("exception.html", ['exception' => $exception]);
  }

  public function home(\Pee\App $app, array $params) {
    echo $this->twig->render("home.html", ['path' => $params['path']] + $app->toArray());
  }
}
