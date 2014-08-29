<?php
/**
 * Cecropia Advanced Online Customers Extension
 *
 * NOTICE OF LICENSE
 *
 *
 * @version     0.1.0
 * @category    Cecropia
 * @package     Cecropia_AdvancedOC
 * @copyright   Copyright (c) 2013
 * @license
 */

/**
 * Automatic Blocking IP Rule Model
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

class Cecropia_AdvancedOC_Model_Rule extends Mage_Core_Model_Abstract
{
    public function validate()
    {
        $helper     = Mage::helper('cecropia_advancedoc');
        $whiteList  = $helper->getWhiteList();
        $currentIp  = Mage::helper('core/http')->getRemoteAddr();

        if (in_array($currentIp, $whiteList)) {
            return true;
        }
        $onlineVisitor      = Mage::getModel('log/visitor_online');

        //Check the number of simultaneous connections
        $maxConnections     = $helper->getMaxSimultConn();
        $nbrOfConnections   = $onlineVisitor->prepare()
                                ->getCollection()
                                ->addFieldToFilter('remote_addr', array('eq', (string)ip2long($currentIp)))
                                ->count();

        if ($nbrOfConnections >= $maxConnections) {
            return $helper->__(
                'IP "%s" automatically blocked : %s simultaneous connection(s)',
                $currentIp,
                $nbrOfConnections
            );
        }

        //Check the number of connection over the last 24 hours
        $maxConnecPerDay    = $helper->getMaxPerDay();
        $nbrOfLastDayCon    = $this->prepare($onlineVisitor)->getCollection()
                                    ->addFieldToFilter('remote_addr', array('eq', (string)ip2long($currentIp)))
                                    ->count();

        if ($nbrOfLastDayCon >= $maxConnecPerDay) {
            return $helper->__(
                'IP "%s" automatically blocked : %s connection(s) in an interval of 24h',
                $currentIp,
                $nbrOfConnections
            );
        }

        return true;
    }

    /**
     * Prepare online visitors for collection
     *
     * @param Mage_Log_Model_Visitor_Online $object
     * @throws Exception
     * @return Mage_Log_Model_Resource_Visitor_Online
     */
    public function prepare(Mage_Log_Model_Visitor_Online $object)
    {
        $readAdapter = $object->getResource()->getReadConnection();

        try{
            $visitors = array();
            $lastUrls = array();

            // retrieve online visitors general data
            $lastDate = Mage::getModel('core/date')->gmtTimestamp() - 24 * 60 * 60;

            $select = $readAdapter->select()
                ->from(
                    $this->getTable('log/visitor'),
                    array('visitor_id', 'first_visit_at', 'last_visit_at', 'last_url_id'))
                ->where('last_visit_at >= ?', $readAdapter->formatDate($lastDate));

            $query = $readAdapter->query($select);
            while ($row = $query->fetch()) {
                $visitors[$row['visitor_id']] = $row;
                $lastUrls[$row['last_url_id']] = $row['visitor_id'];
                $visitors[$row['visitor_id']]['visitor_type'] = Mage_Log_Model_Visitor::VISITOR_TYPE_VISITOR;
                $visitors[$row['visitor_id']]['customer_id']  = null;
            }

            if (!$visitors) {
                return $object;
            }

            // retrieve visitor remote addr
            $select = $readAdapter->select()
                ->from(
                    $this->getTable('log/visitor_info'),
                    array('visitor_id', 'remote_addr'))
                ->where('visitor_id IN(?)', array_keys($visitors));

            $query = $readAdapter->query($select);
            while ($row = $query->fetch()) {
                $visitors[$row['visitor_id']]['remote_addr'] = $row['remote_addr'];
            }

            // retrieve visitor last URLs
            $select = $readAdapter->select()
                ->from(
                    $this->getTable('log/url_info_table'),
                    array('url_id', 'url'))
                ->where('url_id IN(?)', array_keys($lastUrls));

            $query = $readAdapter->query($select);
            while ($row = $query->fetch()) {
                $visitorId = $lastUrls[$row['url_id']];
                $visitors[$visitorId]['last_url'] = $row['url'];
            }

            // retrieve customers
            $select = $readAdapter->select()
                ->from(
                    $this->getTable('log/customer'),
                    array('visitor_id', 'customer_id'))
                ->where('visitor_id IN(?)', array_keys($visitors));

            $query = $readAdapter->query($select);
            while ($row = $query->fetch()) {
                $visitors[$row['visitor_id']]['visitor_type'] = Mage_Log_Model_Visitor::VISITOR_TYPE_CUSTOMER;
                $visitors[$row['visitor_id']]['customer_id']  = $row['customer_id'];
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $object;
    }
}