<?php
class Itransition_ShippingInsurance_Model_Observer
{
    public function setInsurance(Varien_Event_Observer $observer)
    {
        $enabled = Mage::getStoreConfig(
            'shipping_insurance/settings/module_enabled'
        );

        if ($enabled) {
            $accepted = Mage::app()->getRequest()->getParam('insurance_enabled', false);
    
            if ($accepted) {
                Mage::getSingleton('customer/session')->addData(['insurance' => true]);
            } else {
                Mage::getSingleton('customer/session')->addData(['insurance' => false]);
            }
        }
    }
    
    public function flushInsurance(Varien_Event_Observer $observer)
    {
        Mage::getSingleton('customer/session')->addData(['insurance' => false]);
    }
}
