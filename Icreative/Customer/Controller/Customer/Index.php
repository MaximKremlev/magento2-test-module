<?php

namespace Icreative\Customer\Controller\Customer;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
    /**
     * Show form.
     */
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
