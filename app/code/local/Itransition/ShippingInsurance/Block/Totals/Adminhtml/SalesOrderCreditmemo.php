<?php

class Itransition_ShippingInsurance_Block_Totals_Adminhtml_SalesOrderCreditmemo extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        return Mage::helper('shipping_insurance')
            ->setOrderAdditionalTotal($this->getOrder(), $this);
    }
}