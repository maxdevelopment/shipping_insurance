<?php
class Itransition_ShippingInsurance_Block_Totals_SalesOrder extends Mage_Sales_Block_Order_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        return Mage::helper('shipping_insurance')
            ->setOrderAdditionalTotal($this->getOrder(), $this);
    }
}
