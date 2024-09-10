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

        ob_start(NULL, 1<<20);
        $soap->handle();
        $soapXml = ob_get_contents();
        ob_end_clean();

        $soapXml = str_replace(['SOAP-ENV', 'ns1'], ['soapenv', 'soap'], $soapXml);
        $soapXml = str_replace(['xsi:type="xsd:int"', 'xsi:type="xsd:string"', 'xsi:type="soap:Response"', 'xsi:nil="true"', ' >'], ['', '', '', '', '>'], $soapXml);
        $soapXml = str_replace(
            ['<ErrorCode />', '<ErrorMessage />', '<NumRadicado />', '<CodGuia />'],
            ['<ErrorCode></ErrorCode>', '<ErrorMessage></ErrorMessage>', '<NumRadicado></NumRadicado>', '<CodGuia></CodGuia>'],
            $soapXml
        );
        $soapXml = str_replace('<soapenv:Body>', '<soapenv:Header/><soapenv:Body>', $soapXml);
        $soapXml = str_replace(
            'xmlns:soap="http://nginx/wscolpensionesQA/ServiceColpensiones?wsdl="',
            'xmlns:soap="http://soap.canal.ws/"',
            $soapXml
        );
        $soapXml = str_replace(
            'xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"',
            '',
            $soapXml
        );

        header('Content-Length: '.strlen($soapXml));

        $response->setContent($soapXml);

        return $response;
    }

    private function authenticate($user, $password): bool
    {
        return ($user === $this->app_user && $password === $this->app_password);
    }
}