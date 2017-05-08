<?php
/**
 * Copyright WideFocus. All rights reserved.
 * http://www.widefocus.net
 */

namespace WideFocus\Magento\ZendHydratorAdapter;

use Magento\Framework\EntityManager\HydratorInterface;
use Zend\Stdlib\Hydrator\HydratorInterface as ZendHydratorInterface;

class ZendHydratorAdapter implements HydratorInterface
{
    /**
     * @var ZendHydratorInterface
     */
    private $zendHydrator;

    /**
     * Constructor.
     *
     * @param ZendHydratorInterface $zendHydrator
     */
    public function __construct(ZendHydratorInterface $zendHydrator)
    {
        $this->zendHydrator = $zendHydrator;
    }

    /**
     * Extract data from object
     *
     * @param object $entity
     *
     * @return array
     */
    public function extract($entity): array
    {
        return $this->zendHydrator->extract($entity);
    }

    /**
     * Populate entity with data
     *
     * @param object $entity
     * @param array  $data
     *
     * @return object
     */
    public function hydrate($entity, array $data)
    {
        return $this->zendHydrator->hydrate($data, $entity);
    }
}
