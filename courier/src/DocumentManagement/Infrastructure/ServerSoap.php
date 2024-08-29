<?php

namespace App\DocumentManagement\Infrastructure;

use App\DocumentManagement\Domain\Server;
use DOMDocument;
use DOMXPath;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence;
use SimpleXMLElement;
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
        $wsdl = ob_get_clean();

        $dom = new \DOMDocument();
        $dom->loadXML($wsdl);

        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('wsdl', 'http://schemas.xmlsoap.org/wsdl/');

        $parts = $xpath->query('//wsdl:message[@name="RadicarTramiteOut"]/wsdl:part');

        foreach ($parts as $part) {
            if ($part->getAttribute('name') === 'return') {
                $part->setAttribute('name', 'RadicarTramiteResult'); // Cambia 'customReturn' al nombre que desees
            }
        }

        $response->setContent($dom->saveXML());
        return $response;
    }

    public function handleSOAP($uri, $class, $user, $password): Response
    {
        /*Se comenta por si en algun momento se desea volver a activar dicha funcionalidad
         * if (!$this->authenticate($user, $password)) {
            return new Response("Access Denied", Response::HTTP_UNAUTHORIZED, ['WWW-Authenticate' => 'Basic realm="SoapServiceCourier"']);
        }*/

        $soap = new SoapServer('http://nginx/wscolpensionesQA/ServiceColpensiones?wsdl');
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