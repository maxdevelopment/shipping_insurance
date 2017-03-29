<?php

class Itransition_ShippingInsurance_Helper_Totals extends Mage_Core_Helper_Abstract
{
    public function collect($instance)
    {
        if ($instance instanceof Mage_Sales_Model_Order_Invoice ||
            $instance instanceof Mage_Sales_Model_Order_Creditmemo
        ) {


            $order = $instance->getOrder();
            $amount = $order->getShippingInsurance();
            $enabled = Mage::getStoreConfig(
                'shipping_insurance/settings/module_enabled'
            );

            if ($enabled && $order->getInsuranceShippingMethod()) {
                $instance->setGrandTotal($instance->getGrandTotal() + $amount);
                $instance->setBaseGrandTotal($instance->getBaseGrandTotal() + $amount
                );
            }

            return $instance;
        }

        return Mage::exception('Itransition_ShippingInsurance', 'Wrong helper instance of class');
    }
}