<?php

class Componentk_PaymentFee_Model_Quote_Address_Total_Fee extends Mage_Sales_Model_Quote_Address_Total_Abstract{

	public function __construct() {
		$this->setCode('fee_total');
	}

	/**
	 * Collect totals information about fee
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return Mage_Sales_Model_Quote_Address_Total_Shipping
	 */
	public function collect( Mage_Sales_Model_Quote_Address $address ) {
		parent:: collect( $address );
		$items = $this->_getAddressItems( $address );
		if ( ! count( $items ) ) {
			return $this;
		}

		if(!$this->_getHelper()->isActive()){ return $this; } //exit

		$quote = $address->getQuote();

		if($quote->getPayment()->getMethod()){
			$paymentMethod = $quote->getPayment()->getMethodInstance()->getCode();

			//if we are on checkout and payment method is selected
			if($paymentMethod){
				$feeAmount = $this->_getHelper()->getSurchargeByCode($paymentMethod);

				//percentage calculation vs flat
				if($feeAmount->getType() === 'percent'){
					$fee = $this->_getAddress()->getSubtotal() * $feeAmount->getPrice() / 100;
				}else{
					$fee = $feeAmount->getPrice();
				}

				$fee = $quote->getStore()->roundPrice($fee);
				$this->_setAmount($fee)->_setBaseAmount($fee);
				$address->setData('fee_total', $fee );
			}
		}

		return $this;
	}

	/**
	 * Add fee totals information to address object
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return Mage_Sales_Model_Quote_Address_Total_Shipping
	 */
	public function fetch( Mage_Sales_Model_Quote_Address $address ) {
		parent:: fetch( $address );
		$amount = $address->getTotalAmount( $this->getCode() );
		if ( $amount != 0 ) {
			$address->addTotal( array(
				'code'  => $this->getCode(),
				'title' => $this->getLabel(),
				'value' => $amount
			) );
		}

		return $this;
	}

	/**
	 * Get label of fee
	 * @return string
	 */
	public function getLabel() {
		return $this->_getHelper()->__( 'Fee' );
	}

	/**
	 * @return \Componentk_PaymentFee_Helper_Data
	 */
	protected function _getHelper(){
		return Mage::helper('paymentfee');
	}
}