<?php

namespace App\DocumentManagement\Infrastructure;

use App\DocumentManagement\Domain\Server;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence;
use SoapServer;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;

class ServerSoap implements Server
{
    public function __construct(private readonly string $app_user, private readonly string $app_password)
    {}

    public function render(array $data): Response
    {
        if ($data['wsdl'])
            return $this->handleWSDL($data['uri'], $data['handler']);

        return $this->handleSOAP($data['uri'], $data['handler'], $data['user'], $data['password']);
    }

    public function handleWSDL($uri, $class): Response
    {
        $autoDiscover = new AutoDiscover(new ArrayOfTypeSequence());
        $autoDiscover->setClass($class);
        $autoDiscover->setUri($uri);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');

        ob_start();

        $autoDiscover->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    public function handleSOAP($uri, $class, $user, $password): Response
    {
        if (!$this->authenticate($user, $password)) {
            return new Response("Access Denied", 403);
        }

        $soap = new SoapServer(null, ['location' => $uri, 'uri' => $uri]);
        $soap->setObject($class);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    private function authenticate($user, $password): bool
    {
        return ($user === $this->app_user && $password === $this->app_password);
    }
}