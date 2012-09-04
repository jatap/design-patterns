<?php

namespace Common\Pattern\Behavioral\Strategy
{
    class Context
    {
        private $_strategy;

        function __construct($strategy)
        {
            switch ($strategy) {
                case 'html':
                default:
                    $this->_strategy = new HTMLStrategy();
                    break;

                case 'json':
                    $this->_strategy = new JsonStrategy();
                    break;
            }
        }

        public function getStrategy()
        {
            return $this->_strategy;
        }

        public function getData()
        {
            return $this->getStrategy()->getData();
        }
    }

    class HTMLStrategy
    {
        public function getData()
        {
            return "Sample HTML data";
        }
    }

    class JsonStrategy
    {
        public function getData()
        {
            return json_encode(array('Sample Json data'));
        }
    }

    class Response
    {
        private $_data;

        function __construct($data)
        {
            $this->_data = new Context($data);
        }

        public function get()
        {
            return $this->_data->getData();
        }
    }

    class Client
    {
        public function run()
        {
            $strategyHtml       = new Response('html');
            $strategyJson       = new Response('json');
            $strategyHtmlData   = $strategyHtml->get();
            $strategyJsonData   = $strategyJson->get();

            return json_encode(
                array(
                    $strategyHtmlData,
                    $strategyJsonData
                )
            );
        }
    }
}