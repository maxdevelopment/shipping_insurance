<?php

/**
 * Class Itransition_ShippingInsurance_Exception
 *
 * just for test Magento exceptions
 */

class Itransition_ShippingInsurance_Exception extends Mage_Core_Exception
{
    public function __construct($message)
    {
        throw new Exception($message);
    }
}
