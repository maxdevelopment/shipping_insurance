<?php

class Itransition_ShippingInsurance_Model_Totals_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditMemo)
    {
        return Mage::helper('shipping_insurance/totals')->collect($creditMemo);
    }
}