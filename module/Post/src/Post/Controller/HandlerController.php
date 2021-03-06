<?php

namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Soap\AutoDiscover;
use Zend\Soap\Server;
use Zend\Soap\Client;

require_once getcwd() . '/module/Post/src/Post/Service/ServiceAPI.php';
require_once getcwd() . '/module/Post/src/Post/Controller/PostController.php';


class HandlerController extends AbstractActionController
{

    public function init()
    {


    }

    public function indexAction()
    {


    }

    public function soapAction()
    {

        // initialize server and set URI

        // non-wsdl mode
        $server = new Server(null, array('uri' => 'http://guestbook-soap.local/handler/soap'));

        // wsdl mode
//        $server = new Server('http://guestbook-soap.local/handler/wsdl');


        // set SOAP service class
//        $server->setClass('Post\\Service\\ServiceAPI');
        // test here
//        $server->setClass('Post\\Controller\\PostController');
        $apiObject = $this->serviceLocator->get('Post\Controller\PostController');
        $server->setObject($apiObject);

        // handle request
        $server->handle();

        $result = $server->handle();
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
//        exit;

    }


    public function wsdlAction()
    {

        // set up WSDL auto-discovery
        $autoDiscover = new AutoDiscover();

        // set SOAP action URI
        $autoDiscover->setUri('http://guestbook-soap.local/handler/soap');  // which version?
//        $autoDiscover->setUri('http://guestbook-soap.local/handler/wsdl'); //

        // set service name:
        $autoDiscover->setServiceName('MyHandlerWsdlService');

        // attach SOAP service class
//        $autoDiscover->setClass('Post\Service\ServiceAPI');
        // test here
//        $autoDiscover->setClass('Post\\Service\\ServiceAPI');
        $apiObject = $this->serviceLocator->get('Post\Controller\PostController');
        $autoDiscover->setClass($apiObject);


        $autoDiscover->generate();

//        echo $autoDiscover->toXml();


        // handle request
        $autoDiscover->handle();

        exit;


    }

    public function clientAction()
    {

        $options = array(
            'location' => 'http://guestbook-soap.local/handler/soap',
            'uri'      => 'http://guestbook-soap.local/handler/soap',
        );

        $client = new Client(null, $options);

//        $client = new Client('http://guestbook-soap.local/handler/wsdl');

//        $result = $client->testFunction();
        // test here
        $result = $client->indexAction();

        echo '<pre>';
        var_dump($result);
        echo '</pre>';

        return $result;


    }

}