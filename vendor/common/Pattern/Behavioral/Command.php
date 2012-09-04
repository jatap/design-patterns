<?php

namespace Common\Pattern\Behavioral\Command
{
    class WebServer
    {
        private $_api;
        private $_url;

        public function __construct($api, $url)
        {
            $this->setApi($api);
            $this->setUrl($url);
        }

        public function getApi()
        {
            return $this->_api;
        }

        public function setApi($author)
        {
            $this->_api = $author;
        }

        public function getUrl()
        {
            return $this->_url;
        }

        public function setUrl($title)
        {
            $this->_url = $title;
        }

        public function setWsdl()
        {
            $this->setApi('api.wsdl');
            $this->setUrl('?WSDL');
        }

        public function setRest()
        {
            $this->setApi('api.rest');
            $this->setUrl('?rest.php');
        }

        public function getApiAndUrl()
        {
            return $this->getApi() . ' :: ' . $this->getUrl();
        }

    }

    abstract class WebService
    {
        protected $_webServer;

        public function __construct($webService)
        {
            $this->_webServer = $webService;
        }

        abstract public function execute();
    }

    class WsdlCommand extends WebService
    {
        public function execute()
        {
            $this->_webServer->setWsdl();
        }

    }

    class RestCommand extends WebService
    {
        public function execute()
        {
            $this->_webServer->setRest();
        }

    }

    class Client
    {
        public function run()
        {
            $webServer = new WebServer('api.test', '?test.php');
            $webServerIniData = $webServer->getApiAndUrl();

            $wsdl = new WsdlCommand($webServer);
            $wsdl->execute();
            $wsdlData = $webServer->getApiAndUrl();

            $rest = new RestCommand($webServer);
            $rest->execute();
            $restData = $webServer->getApiAndUrl();

            return json_encode(
                array(
                    $webServerIniData,
                    $wsdlData,
                    $restData
                )
            );
        }
    }
}