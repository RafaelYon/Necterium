<?php

namespace App\Http;

use App\Http\Request;
use App\Http\Response;
use App\Support\UrlHelper;

use App\Exceptions\NotFoundException;

class Router
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request; 
    }

    private function executeControllerAction(string $controllerAction)
    {
        $parts = explode('@', $controllerAction);

        $controller = 'App\\Http\\Controllers\\' . $parts[0];
        $action = $parts[1];

        $controller = new $controller();
        $this->response(
            $controller->dispatch($action, $this->request)
        );
    }

    private function response($response)
    {
        if (!($response instanceof Response))
        {
            $response = new Response($response); 
        }

        $response->setRequest($this->request);

        $response->response();
    }

    private function compareRouteAndRequest(string $route) : bool
    {
        $routeParts = UrlHelper::getParts($route);
        $requestParts = UrlHelper::getParts($this->request->getRequestUri(false));

        $requestLenght = count($requestParts);
        $routeLength = count($routeParts);

        if ($requestLenght != $routeLength)
            return false;

        for ($i = 0; $i < $routeLength; $i++)
        {
            // Verifica se é não é uma parte variavel
            if (strpos($routeParts[$i], '{') === false)
            {
                if ($routeParts[$i] !== $requestParts[$i])
                    return false;
            }
            else
            {
                // Verifica se bate com o padrão específicado
                $pattern = str_replace('{', '', $routeParts[$i]);
                $pattern = str_replace('}', '', $pattern);

                $pattern = '/' . $pattern . '/';

                if (!preg_match($pattern, $requestParts[$i]))
                {
                    $this->request->clearParameters();
                    
                    return false;
                }

                $this->request->addParameter($requestParts[$i]);
            }
        }

        return true;
    }

    private function checkRouteMatch(array $routes)
    {
        foreach ($routes as $route => $controllerAction)
        {
            if ($this->compareRouteAndRequest($route))
            {
                $this->executeControllerAction($controllerAction);
            }
        }

        throw new NotFoundException($this->request);
    }

    public function doAction()
    {        
        $this->checkRouteMatch(routes(
            $this->request->isApiRequest() ? 'api' : 'web',
            $this->request->getRequestMethod()
        ));
    }
}