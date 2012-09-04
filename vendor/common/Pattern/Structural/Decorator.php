<?php

namespace Common\Pattern\Structural\Decorator
{
    class Window
    {
        private $_name;
        private $_size;

        public function __construct($name, $size)
        {
            $this->_name    = $name;
            $this->_size    = $size;
        }

        public function getName()
        {
            return $this->_name;
        }

        public function getSize()
        {
            return $this->_size;
        }

    }

    class Decorator
    {
        protected $_window;
        protected $_size;

        public function __construct(Window $window)
        {
            $this->_window  = $window;
            $this->_size    = $window->getSize();
        }

        public function reset()
        {
            $this->_size = $this->_window->getSize();
        }

        public function getSize()
        {
            return $this->_size;
        }

    }

    class DecoratorMoreSize extends Decorator
    {
        private $_decorator;

        public function __construct(Decorator $decorator) {
            $this->_decorator = $decorator;
        }

        public function add()
        {
            $this->_decorator->_size++;
            return $this;
        }
    }

    class DecoratorLessSize extends Decorator
    {
        private $_decorator;

        public function __construct(Decorator $decorator) {
            $this->_decorator = $decorator;
        }

        public function supr()
        {
            $this->_decorator->_size--;
            return $this;
        }
    }

    class Client
    {
        public function run()
        {
            $window             = new Window('First window', 640);
            $decorator          = new Decorator($window);
            $decoratorMoreSize  = new DecoratorMoreSize($decorator);
            $decoratorLessSize  = new DecoratorLessSize($decorator);

            $size               = $window->getSize();

            $moreSize           = $decoratorMoreSize->add()
                                                    ->add()
                                                    ->add();
            $testSize1          = $decorator->getSize();

            $lessSize           = $decoratorLessSize->supr();
            $testSize2          = $decorator->getSize();

            return \Zend\Json\Encoder::encode(
                array($size, $testSize1, $testSize2)
            );
        }
    }
}