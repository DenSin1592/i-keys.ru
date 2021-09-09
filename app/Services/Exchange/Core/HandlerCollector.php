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
                    'type_priority' => intval($handleFactory->getTypePriority()),
                    'priority' => intval($handlerContainer->getPriority()),
                );
            }
        }

        usort(
            $handlerContainerHeap,
            function ($_1, $_2) {
                if ($_1['type_priority'] > $_2['type_priority']) {
                    return 1;
                } elseif ($_1['type_priority'] < $_2['type_priority']) {
                    return -1;
                } else {
                    if ($_1['priority'] > $_2['priority']) {
                        return 1;
                    } elseif ($_1['priority'] < $_2['priority']) {
                        return -1;
                    } else {
                        return 0;
                    }
                }
            }
        );

        $typeHandlerList = array_map(
            function ($e) {
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
            function (ITypeHandler $typeHandler) {
                $typeHandler->handle();
            }
        );
    }
}
