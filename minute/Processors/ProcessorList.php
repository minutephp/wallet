<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/16/2016
 * Time: 4:39 AM
 */
namespace Minute\Processors {

    use Minute\Event\Dispatcher;
    use Minute\Event\ImportEvent;
    use Minute\Event\ProcessorConfigEvent;
    use Minute\Interfaces\PaymentProcessor;
    use Minute\Resolver\Resolver;
    use Minute\Utils\PathUtils;
    use ReflectionClass;
    use Symfony\Component\Finder\Finder;

    class ProcessorList {
        /**
         * @var Resolver
         */
        private $resolver;
        /**
         * @var PathUtils
         */
        private $utils;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * ProcessorList constructor.
         *
         * @param Resolver $resolver
         * @param Dispatcher $dispatcher
         * @param PathUtils $utils
         */
        public function __construct(Resolver $resolver, Dispatcher $dispatcher, PathUtils $utils) {
            $this->resolver   = $resolver;
            $this->dispatcher = $dispatcher;
            $this->utils      = $utils;
        }

        public function getProcessors(ImportEvent $event) {
            if ($dirs = $this->resolver->find("Minute\\Processor")) {
                $finder = new Finder();
                $files  = $finder->depth('< 1')->files()->in($dirs)->name('*.php')->contains('PaymentProcessor');

                foreach ($files as $file) {
                    $classPath = preg_replace('/\.php$/', '', preg_replace('/.*\\\\minute\\\\/', 'Minute\\', $this->utils->dosPath((string) $file)));

                    if ($reflector = new ReflectionClass($classPath)) {
                        if ($reflector->implementsInterface(PaymentProcessor::class)) {
                            $name = strtolower($this->utils->basename($reflector->getName()));;
                            $processors[$name] = ['name' => $reflector->getConstant('NAME') ?: $name];

                            $processorEvent = new ProcessorConfigEvent($name);
                            $this->dispatcher->fire(ProcessorConfigEvent::PROCESSOR_GET_FIELDS, $processorEvent);
                            $processors[$name]['fields'] = $processorEvent->getFields();
                        }
                    }
                }
            }

            $event->setContent($processors ?? []);
        }
    }
}