<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Funami\EmotionShippingMethods\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
use Funami\EmotionShippingMethods\Helper\GetShippingMethods;
use Magento\Customer\Model\Session;

class Dummy100 extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{

    protected $_code = 'dummy100';

    protected $_isFixed = true;

    protected $_rateResultFactory;

    protected $_rateMethodFactory;
    protected $_getShippingMethods;
    protected $_session;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        Session $session,
        GetShippingMethods $getShippingMethods,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_session = $session;
        $this->_getShippingMethods = $getShippingMethods;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        if(!$this->_session->isLoggedIn()) {
            $shippingMethods = $this->_getShippingMethods->execute();
            $shippingTitleAPI = $shippingMethods[0]->title;
            $shippingPriceAPI = $shippingMethods[0]->price;;
            $shippingPriceConfig = $this->getConfigData('price');
            $shippingPrice = $shippingPriceAPI ? $shippingPriceAPI : $shippingPriceConfig;
            $result = $this->_rateResultFactory->create();

            if ($shippingPrice !== false) {
                $method = $this->_rateMethodFactory->create();

                $method->setCarrier($this->_code);
                $method->setCarrierTitle($shippingTitleAPI);

                $method->setMethod($this->_code);
                $method->setMethodTitle($shippingTitleAPI);

                if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                    $shippingPrice = '0.00';
                }

                $method->setPrice($shippingPrice);
                $method->setCost($shippingPrice);

                $result->append($method);
            }

            return $result;
        }
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
