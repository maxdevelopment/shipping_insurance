<?php

class Itransition_ShippingInsurance_Model_Totals_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        return Mage::helper('shipping_insurance/totals')->collect($invoice);
    }
}