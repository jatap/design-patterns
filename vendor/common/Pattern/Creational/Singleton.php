<?php

namespace Common\Pattern\Creational\Singleton
{
    class BigLoad
    {
        protected static $_instance;

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

        /**
         * @return  BigLoad
         */
        public static function getInstance()
        {
            if (null === self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        private function __constructor()
        {
        }

        public function getData()
        {
            return implode(',', $this->_data);
        }
    }

    class Client
    {
        public function run()
        {
            $bigLoad        = BigLoad::getInstance();
            $secondBigLoad  = BigLoad::getInstance();

            return $secondBigLoad->getData();
        }
    }
}