<?php
declare(strict_types=1);

namespace Vineeth\services;

use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Domain\AbstractRoute;
use Teacher\GivenCode\Domain\RouteCollection;
use Teacher\GivenCode\Domain\WebpageRoute;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\ValidationException;

class InternalRouter implements IService {
    
    private string $uriBaseDirectory;
    private RouteCollection $routes;
    
    /**
     * @throws ValidationException
     */
    public function __construct(string $uri_base_directory = "") {
        $this->uriBaseDirectory = $uri_base_directory;
        $this->routes = new RouteCollection();
        $this->routes->addRoute(new WebpageRoute("/index.php", "Vineeth/index.php"));
        $this->routes->addRoute(new WebpageRoute("/", "Vineeth/index.php"));
    }
    
    public function route() : void {
        $path = REQUEST_PATH;
        $route = $this->routes->match($path);
        
        if (is_null($route)) {
            // route not found
            throw new RequestException("Route [$path] not found.", 404);
        }
        
        $route->route();
        
    }
    
    /**
     * @throws ValidationException
     */
    public function addRoute(AbstractRoute $route) : void {
        $this->routes->addRoute($route);
    }
}