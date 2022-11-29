<?php

namespace Dell\Laptop\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\MultiSelect;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class CustomContent extends AbstractModifier
{
    private $locator;


    private $cacheManager;

    public function __construct(


        LocatorInterface $locator
    ) {

        $this->locator = $locator;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_content' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Admin Name'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_title' => $this->getCustomTitle(),

                    ],
                ],
            ]
        );

    }

    public function getCustomTitle(\Magento\Framework\Event\Observer $observer)
    {
            return [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Admin Name'),
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'dataScope' => 'admin_name',
                            'dataType' => Text::NAME,
                            'sortOrder' => 10,
                        ],
                    ],
                ],
            ];



    }




    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $productId = (int) $product->getId();


        $data = array_replace_recursive(
            $data, [
                $productId => [
                    'product' => [
                        'custom_title' => $product->getCustomTitle(),


                    ],
                ],
            ]);
        return $data;
    }
}
