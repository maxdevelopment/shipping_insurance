<?php

class Itransition_ShippingInsurance_Model_Totals_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shipping_insurance';
    protected $enabled;
    
    public function __construct()
    {
        $this->enabled = Mage::getStoreConfig(
            'shipping_insurance/settings/module_enabled'
        );
    }
    
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        
        if ($this->enabled) {
            $items = $this->_getAddressItems($address);
            if (!count($items)) {
                return $this;
            }
            
            $insuranceValue = $this->calculateInsuranceValue($address);
            Mage::getSingleton('customer/session')->addData(['insurance_value' => $insuranceValue]);
            
            if (Mage::getSingleton('customer/session')->getData('insurance')) {
                
                $quote = $address->getQuote();
                $quote->setShippingInsurance($insuranceValue);
                $address->setShippingInsurance($insuranceValue);
                
                
                $address->setGrandTotal(
                    $address->getGrandTotal() + $insuranceValue
                );
                $address->setBaseGrandTotal(
                    $address->getBaseGrandTotal() + $insuranceValue
                );
            }
        }
    }
    
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (Mage::getSingleton('customer/session')->getData('insurance')) {
            $label = Mage::getStoreConfig(
                'shipping_insurance/settings/shipping_insurance_label'
            );
            $amount = $address->getShippingInsurance();
            $address->addTotal([
                    'code' => $this->getCode(),
                    'title' => Mage::helper('shipping_insurance')->__($label),
                    'value' => $amount
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
        
        $subTotal = 0;
        $countedValue = 0;
        
        array_map(function ($item) use (&$subTotal) {
            $subTotal += $item->getQty() * $item->getPrice();
        }, $this->_getAddressItems($address));
        
        if ($type == Itransition_ShippingInsurance_Model_Adminhtml_Type::ABSOLUTE_VALUE) {
            $countedValue = round($value, 4, PHP_ROUND_HALF_UP);
        } elseif ($type == Itransition_ShippingInsurance_Model_Adminhtml_Type::PERCENT_FROM_ORDER) {
            $countedValue = round($subTotal * ($value / 100), 4, PHP_ROUND_HALF_UP);
        }
        
        return $countedValue;
    }
}