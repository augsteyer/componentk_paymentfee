<?php
class Componentk_PaymentFee_Model_Newordertotalobserver
{
	 public function saveFeeTotal(Varien_Event_Observer $observer)
    {
         $order = $observer->getEvent()->getOrder();
         $quote = $observer->getEvent()->getQuote();
         $shippingAddress = $quote->getShippingAddress();
         if($shippingAddress && $shippingAddress->getData('fee_total')){
             $order->setData('fee_total', $shippingAddress->getData('fee_total'));
             }
        else{
             $billingAddress = $quote->getBillingAddress();
             $order->setData('fee_total', $billingAddress->getData('fee_total'));
             }
         $order->save();
     }
    
     public function saveFeeTotalForMultishipping(Varien_Event_Observer $observer)
    {
         $order = $observer->getEvent()->getOrder();
         $address = $observer->getEvent()->getAddress();
         $order->setData('fee_total', $address->getData('fee_total'));
		 $order->save();
     }
}