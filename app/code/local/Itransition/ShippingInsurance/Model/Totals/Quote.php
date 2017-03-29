<?php

class Itransition_ShippingInsurance_Model_Totals_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shipping_insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $enabled = Mage::getStoreConfig(
            'shipping_insurance/settings/module_enabled'
        );

        if ($enabled) {
            $items = $this->_getAddressItems($address);
            if (!count($items)) {
                return $this;
            }

            $insuranceValue = $this->calculateInsuranceValue($address);
            $this->setInsuranceValue($address, $insuranceValue);
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $label = Mage::getStoreConfig(
            'shipping_insurance/settings/shipping_insurance_label'
        );

        if ($address->getInsuranceShippingMethod()) {
            $amt = $address->getShippingInsurance();
            $address->addTotal([
                    'code' => $this->getCode(),
                    'title' => Mage::helper('shipping_insurance')->__($label),
                    'value' => $amt
                ]
            );
        }
        return $this;
    }

    /**
     * @param \Mage_Sales_Model_Quote_Address $address
     * @return float|int
     */
    protected function calculateInsuranceValue(Mage_Sales_Model_Quote_Address $address)
    {
        $type = Mage::getStoreConfig(
            'shipping_insurance/settings/shipping_insurance_type'
        );
        $value = Mage::getStoreConfig(
            'shipping_insurance/settings/shipping_insurance_value'
        );
        $subTotal = floatval($address->getSubtotal());
        $countedValue = 0;

        if ($type == 1) {
            $countedValue = round($value, 4, PHP_ROUND_HALF_UP);
        } elseif ($type == 0) {
            $countedValue = round($subTotal * ($value / 100), 4, PHP_ROUND_HALF_UP);
        }

        return $countedValue;
    }

    /**
     * @param \Mage_Sales_Model_Quote_Address $address
     * @param $insuranceValue
     */
    protected function setInsuranceValue(Mage_Sales_Model_Quote_Address $address, $insuranceValue)
    {
        $quote = $address->getQuote();
        $quote->setShippingInsurance($insuranceValue);
        $address->setShippingInsurance($insuranceValue);

        if ($address->getInsuranceShippingMethod()) {
            $address->setGrandTotal(
                $address->getGrandTotal() + $address->getShippingInsurance()
            );
            $address->setBaseGrandTotal(
                $address->getBaseGrandTotal() + $address->getShippingInsurance()
            );
        }
    }
}