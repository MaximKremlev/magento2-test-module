<?php

namespace Icreative\Customer\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Data\Form\FormKey\Validator;

class Save extends Action
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param CustomerFactory $customerFactory
     * @param SessionFactory $customerSessionFactory
     * @param Validator $formKeyValidator
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepositoryInterface,
        CustomerFactory $customerFactory,
        SessionFactory $customerSessionFactory,
        Validator $formKeyValidator
    ) {
        parent::__construct($context);
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->customerFactory = $customerFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * Save data
     */
    public function execute()
    {
        $postData = (array) $this->getRequest()->getPost();

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/customer/account');


        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage('Form key is invalid.');

            return $resultRedirect;
        }

        if (!empty($postData)) {
            if (empty($postData['status']) || trim($postData['status']) === '') {
                $this->messageManager->addErrorMessage('Enter the Status and try again.');
            } else {
                $status = $postData['status'];
                $customer = $this->customerSessionFactory->create();
                $customerData = $customer->getCustomer();

                if ($customerData->getId() && $status) {
                    $customerData->setCustomerStatus($status);
                    $customerData->save();

                    $this->messageManager->addSuccessMessage('Status has been successfully updated.');
                } else {
                    $this->messageManager->addErrorMessage('Something went wrong.');
                }
            }
        }

        return $resultRedirect;
    }
}
