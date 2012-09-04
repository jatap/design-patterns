<?php

namespace Common\Pattern\Creational\Factory
{
    interface FactoryInterface
    {
    }

    class Factory
    {
        private $_data;

        function __construct($type)
        {
            switch ($type) {
                case 'html':
                default:
                    $this->_data = new FactoryHtml();
                    break;

                case 'json':
                    $this->_data = new FactoryJson();
                    break;
            }
        }

        public function getData()
        {
            return $this->_data;
        }
    }

    class FactoryHtml implements FactoryInterface
    {
    }

    class FactoryJson implements FactoryInterface
    {
    }

    class Client
    {
        public function run()
        {
            $html   = new Factory('html');
            $json   = new Factory('json');

            return ($html->getData() instanceof FactoryHtml)
                && ($json->getData() instanceof FactoryJson)
                && ($html->getData() instanceof FactoryInterface)
                && ($json->getData() instanceof FactoryInterface);
        }
    }
}