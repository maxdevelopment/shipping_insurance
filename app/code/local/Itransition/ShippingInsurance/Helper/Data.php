<?php

class Itransition_ShippingInsurance_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param Mage_Sales_Model_Order $order
     * @param $instance
     * @return mixed
     */
    public function setOrderAdditionalTotal(Mage_Sales_Model_Order $order, $instance)
    {
        $label = Mage::getStoreConfig(
            'customconfig_options/section_one/shipping_insurance_label'
        );

        if ($order->getInsuranceShippingMethod()) {
            $amount = $order->getShippingInsurance();
            $instance->addTotalBefore(
                new Varien_Object(
                    [
                        'code' => 'shipping_insurance',
                        'value' => $amount,
                        'base_value' => $amount,
                        'label' => $instance->helper('shipping_insurance')->__($label)
                    ],
                    'grand_total'
                )
            );
        }

        return $instance;
    }
}