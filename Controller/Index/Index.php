<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\ComposerNotifyEndpoint\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    
    protected $downloadDayFactory;

    public function __construct(
        Context $context,
        \Cotya\ComposerNotifyEndpoint\Model\DownloadDayFactory $downloadDayFactory
    ) {
        $this->downloadDayFactory = $downloadDayFactory;
        parent::__construct($context);
    }
    
    
    public function execute()
    {
        $postInput = json_decode(file_get_contents('php://input'), true);
        if (empty($postInput)) {
            goto fail;
        }
        
        $downloads = $postInput["downloads"];

        foreach ($downloads as $download) {
            $downloadDay = $this->downloadDayFactory->create();
            $downloadDay
                ->setPackagename($download['name'])
                ->setVersion($download['version'])
                ->setDate(strftime('%Y-%m-%d', time()))
                ->setCounter(1);
            //var_dump($downloadDay->debug());
            try {
                $downloadDay->save();
            } catch (\Zend_Db_Statement_Exception $e) {
                if ($e->getCode()===23000) {
                    $downloadDay->loadByUniqueValues(
                        $download['name'],
                        $download['version'],
                        strftime('%Y-%m-%d', time())
                    );
                    $downloadDay->incrementCounter();
                    $downloadDay->save();
                } else {
                    throw $e;
                }
            }
            //var_dump($downloadDay->debug());
        }
        
        echo "success";
        
        return;
        
        fail:
        echo "fail";
    }
}
