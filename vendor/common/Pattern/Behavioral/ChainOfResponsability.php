<?php

namespace Common\Pattern\Behavioral\ChainOfResponsability
{
    abstract class AbstractBookTopic
    {
        abstract function getTopic();
        abstract function getTitle();
        abstract function setTitle($title_in);
    }

    class BookTopic extends AbstractBookTopic
    {
        private $_topic;
        private $_title;

        public function __construct($topic)
        {
            $this->_topic = $topic;
            $this->_title = NULL;
        }

        public function getTopic()
        {
            return $this->_topic;
        }

        //this is the end of the chain - returns title or says there is none
        public function getTitle()
        {
            if (NULL != $this->_title) {
                return $this->_title;
            } else {
                return 'there is no title avaialble';
            }
        }

        public function setTitle($title)
        {
            $this->_title = $title;
        }
    }

    class BookSubTopic extends AbstractBookTopic
    {
        private $_topic;
        private $_parentTopic;
        private $_title;

        public function __construct($topic, BookTopic $parentTopic)
        {
            $this->_topic = $topic;
            $this->_parentTopic = $parentTopic;
            $this->_title = NULL;
        }

        public function getTopic()
        {
            return $this->_topic;
        }

        public function getParentTopic()
        {
            return $this->_parentTopic;
        }

        public function getTitle()
        {
            if (NULL != $this->_title) {
                return $this->_title;
            } else {
                return $this->_parentTopic->getTitle();
            }
        }

        public function setTitle($title_in)
        {
            $this->_title = $title_in;
        }
    }

    class BookSubSubTopic extends AbstractBookTopic
    {
        private $_topic;
        private $_parentTopic;
        private $_title;

        public function __construct($topic, BookSubTopic $parentTopic)
        {
            $this->_topic = $topic;
            $this->_parentTopic = $parentTopic;
            $this->_title = NULL;
        }

        public function getTopic()
        {
            return $this->_topic;
        }

        public function getParentTopic()
        {
            return $this->_parentTopic;
        }

        public function getTitle()
        {
            if (NULL != $this->_title) {
                return $this->_title;
            } else {
                return $this->_parentTopic->getTitle();
            }
        }

        public function setTitle($title)
        {
            $this->_title = $title;
        }
    }

    class Client
    {
        public function run()
        {

            $bookTopic = new BookTopic("PHP 5");
            $bookTopicData01 = $bookTopic->getTopic();
            $bookTitleData01 = $bookTopic->getTitle();

            $bookTopic->setTitle("PHP 5 Recipes by Babin, Good, Kroman, and Stephens");
            $bookTopicData02 = $bookTopic->getTopic();
            $bookTitleData02 = $bookTopic->getTitle();

            $bookSubTopic = new BookSubTopic("PHP 5 Patterns", $bookTopic);
            $bookTopicData03 = $bookSubTopic->getTopic();
            $bookTitleData03 = $bookSubTopic->getTitle();

            $bookSubTopic->setTitle("PHP 5 Objects Patterns and Practice by Zandstra");
            $bookTopicData04 = $bookSubTopic->getTopic();
            $bookTitleData04 = $bookSubTopic->getTitle();

            $bookSubSubTopic = new BookSubSubTopic("PHP 5 Patterns for Cats",
                    $bookSubTopic);
            $bookTopicData05 = $bookSubSubTopic->getTopic();
            $bookTitleData05 = $bookSubSubTopic->getTitle();

            $bookSubTopic->setTitle(NULL);
            $bookTopicData06 = $bookSubSubTopic->getTopic();
            $bookTitleData06 = $bookSubSubTopic->getTitle();

            return json_encode(
                array(
                    $bookTopicData01,
                    $bookTopicData02,
                    $bookTopicData03,
                    $bookTopicData04,
                    $bookTopicData05,
                    $bookTopicData06,
                    $bookTitleData01,
                    $bookTitleData02,
                    $bookTitleData03,
                    $bookTitleData04,
                    $bookTitleData05,
                    $bookTitleData06
                )
            );
        }
    }
}