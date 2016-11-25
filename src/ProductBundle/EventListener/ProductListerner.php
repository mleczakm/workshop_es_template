<?php

namespace ProductBundle\EventListener;

use Elastica\Bulk;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use PhpOption\None;
use ProductBundle\Entity\Product;


class ProductListerner implements EventSubscriberInterface
{

    /**
     * On post serialize handler
     *
     * @param ObjectEvent $event
     */
    public function onPostSerialize(ObjectEvent $event)
    {

    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
//        return [
//            [
//                'event'  => 'serializer.post_serialize',
//                'class'  => 'ProductBundle\Entity\Product',
//                'method' => 'onPostSerialize'
//            ]
//        ];
    }
}