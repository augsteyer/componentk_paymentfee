<?php

class Componentk_PaymentFee_Model_Order_Creditmemo_Total_Fee extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract{

	public function collect( Mage_Sales_Model_Order_Creditmemo $creditmemo ) {
		$order         = $creditmemo->getOrder();
		$orderFeeTotal = $order->getFeeTotal();

		if ( $orderFeeTotal ) {
			$creditmemo->setGrandTotal( $creditmemo->getGrandTotal() + $orderFeeTotal );
			$creditmemo->setBaseGrandTotal( $creditmemo->getBaseGrandTotal() + $orderFeeTotal );
		}

		return $this;
	}
}