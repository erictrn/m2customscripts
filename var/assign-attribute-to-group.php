<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$attributeCodes = ['tn_variant_base', 'tn_variant_name'];
$ATTRIBUTE_GROUP = 'General';

use Magento\Framework\App\Bootstrap;

require 'app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get(Magento\Framework\App\State::class);
$state->setAreaCode('adminhtml');

/* Attribute assign logic */
$eavSetup = $objectManager->create(\Magento\Eav\Setup\EavSetup::class);
$config = $objectManager->get(\Magento\Catalog\Model\Config::class);
$attributeManagement = $objectManager->get(\Magento\Eav\Api\AttributeManagementInterface::class);

$entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
$attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);
foreach ($attributeSetIds as $attributeSetId) {
    if ($attributeSetId) {
        $group_id = $config->getAttributeGroupId($attributeSetId, $ATTRIBUTE_GROUP);
        $sort = 999;
        echo $group_id . "\n";
        foreach ($attributeCodes as $code) {

            $attributeManagement->assign(
                'catalog_product',
                $attributeSetId,
                $group_id,
                $code,
                $sort
            );

            $sort++;
        }

    }
}
