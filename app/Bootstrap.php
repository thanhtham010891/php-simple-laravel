<?php

namespace App;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Console\Application;
use Illuminate\Database\Capsule\Manager;
use App\Exceptions\AppException;
use Throwable;

class Bootstrap
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Dispatcher
     */
    private $events;

    /**
     * @var AppException
     */
    private $exceptions;

    /**
     * @var self
     */
    private static $instance;

    /**
     * Bootstrap constructor.
     *
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/') . '/';
        $this->container = new Container();
        $this->events = new Dispatcher($this->container);
        $this->exceptions = new AppException();
    }

    /**
     * @return bool
     */
    public function boot()
    {
        $this->setAsGlobal();
        $this->container->singleton('config', function () {
            return new Repository([
                'database' => require_once self::path('config/database.php')
            ]);
        });
        $this->container->bind(Request::class, function () {
            return Request::capture();
        });
        $this->bootModel();

        return true;
    }

    /**
     * Http run
     */
    public function http()
    {
        try {
            $router = new Router($this->events, $this->container);
            require_once 'routes/http.php';
            $router->dispatch($this->container->get(Request::class))->send();
        } catch (Exception $e) {
            $this->exceptions->report($e);
        } catch (Throwable $e) {
            $this->exceptions->report($e);
        }
    }

    /**
     * Console run
     *
     * @throws Exception
     */
    public function console()
    {
        try {
            $console = new Application($this->container, $this->events, '0.0.1');
            $console->setName('Simple console');
            $console->resolveCommands(require_once 'routes/console.php');
            $console->run();
        } catch (Exception $e) {
            $this->exceptions->report($e);
        } catch (Throwable $e) {
            $this->exceptions->report($e);
        }
    }

    /**
     * Make Bootstrap as Global
     */
    public function setAsGlobal()
    {
        static::$instance = $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function service(string $name)
    {
        return static::$instance->container->get($name);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function path(string $path)
    {
        return static::$instance->basePath . trim($path, '/');
    }

    /**
     * @return Manager
     */
    private function bootModel()
    {
        $db = new Manager($this->container);
        $db->addConnection($this->container['config']['database.connections.mysql']);
        $db->setAsGlobal();
        $db->bootEloquent();
        return $db;
    }
}
