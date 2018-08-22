<?php
namespace Ergosense;

use DI\ContainerBuilder;
use OAF\Middleware\AuthMiddleware;
use OAF\Middleware\CorsMiddleware;
use Symfony\Component\Console\Application;

class App extends \OAF\App
{
  protected function extendContainer(ContainerBuilder $builder)
  {
    $builder->addDefinitions(__DIR__ . '/../config/services.php');
    $builder->addDefinitions(__DIR__ . '/../config/vars_development.php');

    return $builder;
  }

  private function publicRoutes()
  {
    return $this->group('', function () {
      $this->post('/v1/login', \Ergosense\Action\Login::class);
    });
  }

  private function protectedRoutes()
  {
    return $this->group('', function () {
      $this->get('/v1/me', \Ergosense\Action\Me::class);
      $this->get('/v1/company/{id}', \Ergosense\Action\Company\Get::class);
    });
  }

  protected function registerRoutes()
  {
    // Public routes
    $this->publicRoutes();

    // Authenticated routes
    $this->protectedRoutes()->add(AuthMiddleware::class);

    // Add application-wide middleware
    $this->add(CorsMiddleware::class);
  }

  protected function registerCommands(Application $app)
  {
    // TODO make better
    $migrationPath = $this->getContainer()->get('settings.migrations');
    $pdo = $this->getContainer()->get(\PDO::class);

    $app->add(new \Ergosense\Command\UpCommand($migrationPath, $pdo));
    $app->add(new \Ergosense\Command\CreateCommand($migrationPath));

    return parent::registerCommands($app);
  }
}