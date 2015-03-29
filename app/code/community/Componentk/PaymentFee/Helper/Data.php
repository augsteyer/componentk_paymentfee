<?php
class Componentk_PaymentFee_Helper_Data extends Mage_Core_Helper_Abstract
{
	const SURCHARGE_METHODS = 'surcharger/general/allowed_methods';
	const ENABLED           = 'surcharger/general/enabled';
	protected $methods;
	protected $enabled;

	/**
	 * Module enabled option in config
	 * @param $store_id
	 * @return bool
	 */
	public function isActive($store_id = null){
		if($this->enabled) return $this->enabled;
		return $this->enabled = mage::getStoreConfigFlag(self::ENABLED, $store_id);
	}

	/**
	 * Pulls all methods unserialized
	 * @param null $store_id
	 * @return mixed
	 */
	public function getPaymentMethods($store_id = null){
		if ($this->methods) return $this->methods;
		return $this->methods = unserialize(mage::getStoreConfig(self::SURCHARGE_METHODS, $store_id));
	}

	/**
	 * @param $code - payment code, e.g. authorizenet
	 * @param null $store_id
	 * @return Varien_Object
	 */
	public function getSurchargeByCode( $code, $store_id = null ) {
		$helper = new Varien_Object();
		$matchedKey = array();
		$config = $this->getPaymentMethods($store_id);
		foreach($config['method'] as $key => $option){
			if($option === $code){
               $matchedKey = $key;
				break;
			}
		}
		/**
		 * Set correct price
		 */
		if(!empty($matchedKey)){
			return $helper
				->setPrice($config['price'][$matchedKey])
				->setType($config['type'][$matchedKey]);
		}else{
			return $helper->setPrice(0);
		}
	}
}
	 