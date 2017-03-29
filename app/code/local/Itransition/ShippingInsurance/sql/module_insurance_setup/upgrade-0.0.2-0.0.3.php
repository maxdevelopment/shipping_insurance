<?php

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->removeAttribute('order', 'insurance_shipping_method');
$installer->endSetup();
