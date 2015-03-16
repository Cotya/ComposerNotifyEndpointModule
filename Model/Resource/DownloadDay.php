<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\ComposerNotifyEndpoint\Model\Resource;


class DownloadDay extends \Magento\Framework\Model\Resource\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        //$this->_mainTable = 'cotya_composer_downloads';
        //$this->_init('cron_schedule', 'schedule_id'); we dont have an id
        $this->_init('cotya_composer_downloads', 'entity_id');
    }
    
    public function loadByUniqueValues(
        \Cotya\ComposerNotifyEndpoint\Model\DownloadDay $downloadDay,
        $packagename,
        $version,
        $date
    ) {
        $adapter = $this->_getReadAdapter();
        $bind = [
            'packagename'   => $packagename,
            'version'       => $version,
            'date'          => $date,
        ];
        $select = $adapter->select()->from(
            $this->getMainTable(),
            [$this->getIdFieldName()]
        )->where(
            'packagename = :packagename
            and version = :version
            and date = :date'
        );

        //var_dump((string)$select,$bind);
        $downloadDayId = $adapter->fetchOne($select, $bind);
        //var_dump($downloadDayId);
        if ($downloadDayId) {
            $this->load($downloadDay, $downloadDayId);
        } else {
            $downloadDay->setData([]);
        }

        return $this;
    }
}
