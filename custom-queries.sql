#Query all configurable products (Magento EE version)
SELECT DISTINCT e.entity_id, e.sku, v_name.value AS product_name, v_mfr.value AS mfr_number, e.type_id AS product_type
FROM catalog_product_entity AS e
-- Join to get product name
INNER JOIN catalog_product_entity_varchar AS v_name
    ON e.row_id = v_name.row_id
    AND v_name.attribute_id = 71 -- product name attribute id
-- Join to get manufacturer number
LEFT JOIN catalog_product_entity_varchar AS v_mfr
    ON e.row_id = v_mfr.row_id
    AND v_mfr.attribute_id = 193 -- manufacturer attribute id
-- Join to filter visible products
INNER JOIN catalog_product_entity_int AS vis
    ON e.row_id = vis.row_id
    AND vis.attribute_id =102 -- visibility attribute id
    AND vis.value IN (4) -- Visible in catalog, search, or both
-- Join to filter enabled products
INNER JOIN catalog_product_entity_int AS stat
    ON e.row_id = stat.row_id
    AND stat.attribute_id = 96  -- status attribute id
    AND stat.value = 1 -- Enabled status
WHERE e.type_id = 'configurable';
