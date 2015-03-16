<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\ComposerNotifyEndpoint\Model;

class DownloadDay extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;
    
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Framework\Model\Resource\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Framework\Model\Resource\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\Db $resourceCollection = null,
        array $data = []
    ) {
        $this->timezone = $timezone;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Cotya\ComposerNotifyEndpoint\Model\Resource\DownloadDay');
    }
    
    public function loadByUniqueValues($packagename, $version, $date)
    {
        $this->_getResource()->loadByUniqueValues($this, $packagename, $version, $date);
    }
    
    public function incrementCounter()
    {
        $this->setCounter($this->getCounter()+1);
    }
}
