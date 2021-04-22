<?php

namespace Icreative\Customer\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;

class Form extends Template
{
    /**
     * @var SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * Constructor
     *
     * @param Context $context
     * @param SessionFactory $customerSessionFactory
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Context $context,
        SessionFactory $customerSessionFactory,
        FormKey $formKey,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->customerSessionFactory = $customerSessionFactory;
        $this->formKey = $formKey;
    }

    /**
     * Get action url for form.
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('status/customer/save', ['_secure' => true]);
    }

    /**
     * Get current customer status.
     *
     * @return string
     */
    public function getCurrentStatus()
    {
        $customer = $this->customerSessionFactory->create();
        $status = $customer->getCustomer()->getCustomerStatus();

        return $status ? $status : '';
    }

    /**
     * Get form key.
     *
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
