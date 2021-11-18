<?php

namespace App\Services\Exchange\Core;

/**
 * Class HandlerCollector
 * Handler collector.
 * @package App\Services\Exchange\Core
 */
class HandlerCollector
{
    /**
     * @var ITypeHandlerFactory[]
     */
    private $typeHandlerFactoryList = [];

    /**
     * Add type handler factory.
     * @param ITypeHandlerFactory $typeHandlerFactory
     */
    public function addTypeHandlerFactory(ITypeHandlerFactory $typeHandlerFactory)
    {
        $this->typeHandlerFactoryList[] = $typeHandlerFactory;
    }

    /**
     * Handle all the handlers from factories.
     */
    public function handle()
    {
        $sortedTypeHandlerList = $this->sortHandlerList();
        $this->handleHandlerList($sortedTypeHandlerList);
    }

    /**
     * Sort handlers list.
     * @return ITypeHandler[]
     */
    private function sortHandlerList()
    {
        $handlerContainerHeap = [];
        foreach ($this->typeHandlerFactoryList as $handleFactory) {
            foreach ($handleFactory->getTypeHandlerList() as $handlerContainer) {
                $handlerContainerHeap[] = array(
                    'handler' => $handlerContainer,
                    'type_priority' => (int)$handleFactory->getTypePriority(),
                    'priority' => (int)$handlerContainer->getPriority(),
                );
            }
        }

        usort(
            $handlerContainerHeap,
           static  function ($_1, $_2) {
               if ($_1['type_priority'] > $_2['type_priority']) {
                   return 1;
               }

               if ($_1['type_priority'] < $_2['type_priority']) {
                   return -1;
               }

               if ($_1['priority'] > $_2['priority']) {
                   return 1;
               }

               if ($_1['priority'] < $_2['priority']) {
                   return -1;
               }

               return 0;
           }
        );

        $typeHandlerList = array_map(
            static function ($e) {
                return $e['handler'];
            },
            $handlerContainerHeap
        );

        return $typeHandlerList;
    }

    /**
     * Handle all handlers in list.
     * @param ITypeHandler[] $typeHandlerList
     */
    private function handleHandlerList($typeHandlerList)
    {
        array_walk(
            $typeHandlerList,
            static function (ITypeHandler $typeHandler) {
                $typeHandler->handle();
            }
        );
    }
}
