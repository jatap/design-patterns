<?php

namespace Common\Pattern\Structural\Proxy
{
    class BigLoadProxy
    {
        /**
         * @var BigLoad
         */
        private $_proxy;

        private function __load()
        {
            if (null === $this->_proxy) {
                $this->_proxy = new BigLoad();
            }
            return $this->_proxy;
        }

        public function __call($method, $arguments)
        {
            $this->__load();
            return call_user_func_array(
                array($this->_proxy, $method), $arguments
            );
        }

        public function __get($name)
        {
            $this->__load();
            return $this->_proxy->$name;
        }

        public function __set($name, $value)
        {
            $this->__load();
            $this->_proxy->$name = $value;
        }

    }

    class BigLoad
    {
        private $_data = array(
            'Header 1' => 'Sample data 1',
            'Header 2' => 'Sample data 2',
            'Header 3' => 'Sample data 3',
            'Header 4' => 'Sample data 4',
            'Header 5' => 'Sample data 5',
            'Header 6' => 'Sample data 6',
            'Header 7' => 'Sample data 7',
            'Header 8' => 'Sample data 8',
            'Header 9' => 'Sample data 9'
        );

        public function getData()
        {
            return implode(',', $this->_data);
        }
    }

    class Client
    {

        public function run()
        {
            $proxy = new BigLoadProxy();
            $data = $proxy->getData();
            return $data;
        }

    }
}