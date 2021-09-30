<?php

declare(strict_types=1);

namespace CustomLink\Status\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\Action;


class Update extends Action
{
    protected $customer;
    protected $customerRepository;
    private $redirectFactory;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customer,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->customer = $customer;
        $this->customerRepository = $customerRepository;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();
        $customerId = $this->customer->getId();

        $customer = $this->customerRepository->getById($customerId);
        $customer->setCustomAttribute("customer_status",$post["status"]);
        $this->customerRepository->save($customer);
        $this->messageManager->addSuccess( __('Update Successfully !') );
        $redirect = $this->redirectFactory->create();
        $redirect->setPath('status/customer/index/');
        return $redirect;   
    }

}
