<?php

class Itransition_ShippingInsurance_Model_Adminhtml_Type
{
    const PERCENT_FROM_ORDER = 1;
    const ABSOLUTE_VALUE = 2;

    public function toOptionArray()
    {
        return [
            ['value' => self::PERCENT_FROM_ORDER, 'label' => 'Percent from order'],
            ['value' => self::ABSOLUTE_VALUE, 'label' => 'Absolute value']
        ];
    }
}