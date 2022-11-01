<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '5G');
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
require 'app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
//$state->setAreaCode('frontend');
//Initial
$resConn = $objectManager->create('\Magento\Framework\App\ResourceConnection');
$connection = $resConn->getConnection();

$filesystem = $objectManager->create('\Magento\Framework\Filesystem');


$parent_category_id = 2;
$catIds = [];
$cat = $objectManager->get(\Magento\Catalog\Model\CategoryRepository::class);
$categoryObj = $cat->get($parent_category_id);
echo '0-> '.$categoryObj->getName()."\n";
$subcategories = $categoryObj->getChildrenCategories();
foreach($subcategories as $subcategorie) {
    echo '1--> '.$subcategorie->getName()."\n";
    $catIds [] = $subcategorie->getId();

    if($subcategorie->hasChildren()) {
        $childCategoryObj1 = $cat->get($subcategorie->getId());
        $childSubcategories1 = $childCategoryObj1->getChildrenCategories();
        foreach($childSubcategories1 as $childSubcategorie1) {
            echo '2----> '.$childSubcategorie1->getName()."\n";
            $catIds [] = $childSubcategorie1->getId();

            if($childSubcategorie1->hasChildren()) {
                $childCategoryObj2 = $cat->get($childSubcategorie1->getId());
                $childSubcategories2 = $childCategoryObj2->getChildrenCategories();
                foreach($childSubcategories2 as $childSubcategorie2) {
                    echo '3------> '.$childSubcategorie2->getName()."\n";
                    $catIds [] = $childSubcategorie2->getId();

                    if($childSubcategorie2->hasChildren()) {
                        $childCategoryObj3 = $cat->get($childSubcategorie2->getId());
                        $childSubcategories3 = $childSubcategorie2->getChildrenCategories();
                        foreach($childSubcategories3 as $childSubcategorie3) {
                            echo '4--------> '.$childSubcategorie3->getName()."\n";
                            $catIds [] = $childSubcategorie3->getId();

                            if($childSubcategorie3->hasChildren()) {
                                $childCategoryObj4 = $cat->get($childSubcategorie3->getId());
                                $childSubcategories4 = $childSubcategorie3->getChildrenCategories();
                                foreach($childSubcategories4 as $childSubcategorie4) {
                                    echo '5----------> '.$childSubcategorie4->getName()."\n";
                                    $catIds [] = $childSubcategorie4->getId();
                                }
                            }

                        }
                    }

                }
            }

        }
    }
}
echo "\n" . 'Use CDP IDs below to run in phpMyAdmin!' . "\n\n";
print_r(implode(',', $catIds));
echo "\n";

//Select for review
//SELECT *  FROM `catalog_category_entity_varchar`
// WHERE `attribute_id` = 49 AND `value` = 'PAGE' and row_id in (661,880,6,...,2901)
// ORDER BY `catalog_category_entity_varchar`.`store_id` DESC

//Update
//UPDATE `catalog_category_entity_varchar` set `value` = 'PRODUCTS_AND_PAGE'
// WHERE `attribute_id` = 49 AND `value` = 'PAGE' and row_id in (661,880,6,...,2901) ;
