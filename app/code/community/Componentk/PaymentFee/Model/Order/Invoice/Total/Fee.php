<?php

class Componentk_PaymentFee_Model_Order_Invoice_Total_Fee extends Mage_Sales_Model_Order_Invoice_Total_Abstract{

	public function collect( Mage_Sales_Model_Order_Invoice $invoice ) {
		$order         = $invoice->getOrder();
		$orderFeeTotal = $order->getFeeTotal();
		if ( $orderFeeTotal && count( $order->getInvoiceCollection() ) == 0 ) {
			$invoice->setGrandTotal( $invoice->getGrandTotal() + $orderFeeTotal );
			$invoice->setBaseGrandTotal( $invoice->getBaseGrandTotal() + $orderFeeTotal );
		}

		return $this;
	}
}