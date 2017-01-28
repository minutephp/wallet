<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 4:30 AM
 */
namespace Minute\Event {

    class ProcessorConfigEvent extends Event {
        const PROCESSOR_GET_FIELDS = 'processor.get.fields';
        /**
         * @var string
         */
        private $processor;
        /**
         * @var array
         */
        private $fields;

        /**
         * ProcessorConfigEvent constructor.
         *
         * @param string $processor
         * @param array $fields
         */
        public function __construct(string $processor, array $fields = []) {
            $this->processor = $processor;
            $this->fields = $fields;
        }

        /**
         * @return array
         */
        public function getFields(): array {
            return $this->fields ?? [];
        }

        /**
         * @param array $fields
         *
         * @return ProcessorConfigEvent
         */
        public function setFields(array $fields): ProcessorConfigEvent {
            $this->fields = $fields;

            return $this;
        }

        /**
         * @return string
         */
        public function getProcessor(): string {
            return $this->processor;
        }

        /**
         * @param string $processor
         *
         * @return ProcessorConfigEvent
         */
        public function setProcessor(string $processor): ProcessorConfigEvent {
            $this->processor = $processor;

            return $this;
        }

    }
}