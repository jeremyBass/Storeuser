<?php
class Wsu_Storeuser_Model_Rewrite_CatalogModelResourceEavMysql4CategoryTree extends Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Tree {
    protected function _updateAnchorProductCount(&$data) {
        foreach ($data as $key => $row) {
            if (isset($row['is_anchor']) && 0 === (int) $row['is_anchor']) {
                $data[$key]['product_count'] = $row['self_product_count'];
            }
        }
    }
}