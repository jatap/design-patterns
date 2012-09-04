<?php

namespace Common\Pattern\Creational\Prototype
{
    class WebService
    {
        private $_user;
        private $_password;
        private $_name;

        function __construct($user, $password, $name)
        {
            $this->_user        = $user;
            $this->_password    = $password;
            $this->_name        = $name;
        }

        public function getName()
        {
            return $this->_name;
        }
    }

    class WebServiceApiPrototype
    {
        public function duplicate()
        {
            return new WebService('dev', 'dev', 'api');
        }
    }

    class WebServiceTicketsPrototype
    {
        public function duplicate()
        {
            return new WebService('prod', 'prod', 'tickets');
        }
    }

    class Client
    {
        public function run()
        {
            $webService = new WebService('test', 'test', 'promo');
            $api        = new WebServiceApiPrototype();
            $tickets    = new WebServiceTicketsPrototype();

            return json_encode(
                array(
                    $webService->getName(),
                    $api->duplicate()->getName(),
                    $tickets->duplicate()->getName()
                )
            );
        }
    }
}