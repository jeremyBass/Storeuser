<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml store content block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Wsu_Storepartitions_Block_Adminhtml_System_Store_Store extends Mage_Adminhtml_Block_System_Store_Store
{
    public function __construct()
    {
        $this->_controller  = 'system_store';
        $this->_headerText  = Mage::helper('adminhtml')->__('Manage Stores');
        $this->setTemplate('system/store/container.phtml');
        parent::__construct();
    }

    protected function _prepareLayout() {
        /* Add website button */
        $this->_addButton('quickadd', array(
            'label'     => Mage::helper('storepartitions')->__('Quick Add'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/quickAdd') .'\')',
            'class'     => 'quickadd',
        ));

        return parent::_prepareLayout();
    }

    /**
     * Retrieve grid
     *
     * @return string
     */
    public function getGridHtml()
    {

		return $this->getLayout()->createBlock('adminhtml/system_store_tree')->toHtml();
    }

    /**
     * Retrieve buttons
     *
     * @return string
     */
    public function getAddNewButtonHtml()
    {
        return join(' ', array(
            $this->getChildHtml('add_new_website'),
            $this->getChildHtml('add_new_group'),
            $this->getChildHtml('add_new_store')
        ));
    }
}
