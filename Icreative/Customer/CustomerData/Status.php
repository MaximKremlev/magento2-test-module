<?php

namespace Icreative\Customer\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\DataObject;

class Status extends DataObject implements SectionSourceInterface
{
    /**
     * @var SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * Constructor
     *
     * @param SessionFactory $customerSessionFactory
     * @param array $data
     */
    public function __construct(
        SessionFactory $customerSessionFactory,
        array $data = []
    ){
        parent::__construct($data);
        $this->customerSessionFactory = $customerSessionFactory;
    }

    /**
     * Get section data.
     *
     * @return array
     */
    public function getSectionData() {
        $status = $this->getStatus();

        return $status ? ['current' => __('Status') . ': ' . $status] : [];
    }

    /**
     * Get customer status.
     *
     * @return string
     */
    public function getStatus() {
        $customer = $this->customerSessionFactory->create();
        $status = $customer->getCustomer()->getCustomerStatus();

        return $status ? $status : false;
    }
}
