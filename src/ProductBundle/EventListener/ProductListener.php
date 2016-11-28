<?php

namespace ProductBundle\EventListener;

use Elastica\Bulk;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use PhpOption\None;
use ProductBundle\Entity\Product;


class ProductListener implements EventSubscriberInterface
{

    /**
     * On post serialize handler
     *
     * @param ObjectEvent $event
     */
    public function onPostSerialize(ObjectEvent $event)
    {
        $groups = $event->getContext()->attributes->get('groups');
        if ($groups instanceof None || !in_array('workshop1', $groups->get())) {
            return;
        }

        /** @var Bulk $document */
        $document = $event->getVisitor();
        /** @var Product $product */
        $product = $event->getObject();

        $document->addData('count_categories', count($product->getProductCategories()));
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'  => 'serializer.post_serialize',
                'class'  => 'ProductBundle\Entity\Product',
                'method' => 'onPostSerialize'
            ]
        ];
    }
}