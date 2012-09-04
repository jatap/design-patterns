<?php

namespace Common\Pattern\Behavioral\Observer
{
    abstract class AbstractObserver
    {
        private $_data;

        function __construct()
        {
            $this->_data = 'Default data without external input';
        }

        public function getData()
        {
            return $this->_data;
        }

        public function setData($data)
        {
            $this->_data = $data;
        }

        abstract function update(AbstractSubject $subject);
    }

    abstract class AbstractSubject
    {
        abstract function attach(AbstractObserver $observer);
        abstract function detach(AbstractObserver $observer);
        abstract function notify();
    }

    class PatternObserverOne extends AbstractObserver
    {
        public function update(AbstractSubject $subject)
        {
            $this->setData('One: ' . $subject->getData());
        }
    }

    class PatternObserverTwo extends AbstractObserver
    {
        public function update(AbstractSubject $subject)
        {
            $this->setData('Two: ' . $subject->getData());
        }
    }

    class PatternSubject extends AbstractSubject
    {
        private $_data = null;
        private $_observers = array();

        public function attach(AbstractObserver $observer)
        {
            array_push($this->_observers, $observer);
        }

        public function detach(AbstractObserver $observer)
        {
            $key = array_search($observer, $this->_observers);
            unset($this->_observers[$key]);
        }

        public function notify()
        {
            foreach ($this->_observers as $observer) {
                $observer->update($this);
            }
        }

        public function updateData($data)
        {
            $this->_data = $data;
            $this->notify();
        }

        public function getData()
        {
            return $this->_data;
        }

    }

    class Client
    {
        public function run()
        {
            $subject            = new PatternSubject();
            $observerOne        = new PatternObserverOne();
            $observerTwo        = new PatternObserverTwo();

            $subject->attach($observerOne);
            $subject->attach($observerTwo);

            $subject->updateData('Data Set First');
            $subject->updateData('Data Set After');

            $subject->detach($observerOne);

            $subject->updateData('Data Set Last');
            $subjectData[]      = $subject->getData();
            $observerOneData[]  = $observerOne->getData();
            $observerTwoData[]  = $observerTwo->getData();

            return json_encode(
                array($subjectData, $observerOneData, $observerTwoData)
            );
        }
    }
}