<?php

/**
 * Order Comment Rest Resource
 * 
 * @package Elidrissidev_RestExtended
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_RestExtended_Model_Sales_Order_Comment_Rest extends Mage_Sales_Model_Api2_Order_Comment_Rest
{
    /**
     * Add comment to order
     * 
     * @param array $data
     */
    protected function _create(array $data)
    {
        $orderId = $this->getRequest()->getParam(self::PARAM_ORDER_ID);
        $order   = $this->_loadOrderById($orderId);

        $status         = $data['status'] ?? false;
        $comment        = $data['comment'] ?? '';
        $visibleOnFront = $data['is_visible_on_front'] ?? 0;
        $notifyCustomer = array_key_exists('is_customer_notified', $data) ? $data['is_customer_notified'] : false;

        $historyItem = $order->addStatusHistoryComment($comment, $status);
        $historyItem->setIsCustomerNotified($notifyCustomer)
            ->setIsVisibleOnFront((int) $visibleOnFront)
            ->save();

        try {
            if ($notifyCustomer && $comment) {
                $oldStore = Mage::getDesign()->getStore();
                $oldArea = Mage::getDesign()->getArea();
                Mage::getDesign()->setStore($order->getStoreId());
                Mage::getDesign()->setArea('frontend');
            }

            $order->save();
            $order->sendOrderUpdateEmail((bool) $notifyCustomer, $comment);
            if ($notifyCustomer && $comment) {
                Mage::getDesign()->setStore($oldStore);
                Mage::getDesign()->setArea($oldArea);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), self::RESOURCE_INTERNAL_ERROR);
        } catch (Throwable $t) {
            Mage::logException($t);
            $this->_critical($t->getMessage(), self::RESOURCE_UNKNOWN_ERROR);
        }
    }
}
