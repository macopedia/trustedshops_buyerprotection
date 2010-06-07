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
 * @category  Symmetrics
 * @package   Symmetrics_Buyerprotect
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Torsten Walluhn <tw@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * Default helper class
 * 
 * @category  Symmetrics
 * @package   Symmetrics_Buyerprotect
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Torsten Walluhn <tw@symmetrics.de>
 * @author    Ngoc Anh Doan <nd@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_Buyerprotect_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    
    /**
     * get all buyerprotection Products in cart
     *
     * @return array
     */
    public function getTsProductsInCart()
    {
        $tsProductIds = array();
        
        /* @var $cart Mage_Checkout_Model_Cart */
        $cart = Mage::getSingleton('checkout/cart')
            ->setStore(Mage::app()->getStore());

        /* @var $cartItems Mage_Sales_Model_Mysql4_Quote_Item_Collection */
        $cartItems = $cart->getItems();
        /* @var $tsIdsSelect Varien_Db_Select */
        $tsIdsSelect = clone $cartItems->getSelect();
        
        $tsIdsSelect->where('product_type = ?', Symmetrics_Buyerprotect_Model_Type_Buyerprotect::TYPE_BUYERPROTECT);
//        $tsIdsSelect->columns('main_table.' . $cartItems->getResource()->getIdFieldName());

        $items = $cartItems->getConnection()->fetchCol($tsIdsSelect);

        if ($items) {
            foreach ($items as $item) {
                $tsProductIds[$item] = $cartItems->getItemById($item)->getProductId();
            }
        }

        return $tsProductIds;
    }
}
