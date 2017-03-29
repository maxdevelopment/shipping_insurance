<?php
class Itransition_ShippingInsurance_Block_Checkout_Onepage_Insurance extends Mage_Checkout_Block_Onepage_Abstract
{
    public function getInsuranceValue()
    {
        return Mage::helper('core')
            ->currency(Mage::getSingleton('customer/session')->getData('insurance_value'), true, false);
    }

    public function isEnabled() {
        return Mage::getStoreConfig(
            'shipping_insurance/settings/module_enabled'
        );
    }
}
