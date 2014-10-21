<?php
/**
 * This file is part of Mbiz_RobotsTxt for Magento.
 *
 * @license All rights reserved.
 * @author Léo Peltier <l.peltier@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_RobotsTxt
 * @copyright Copyright (c) 2013 Monsieur Biz (http://monsieurbiz.com/)
 */
class Mbiz_RobotsTxt_Model_RobotsTxt extends Mage_Core_Model_Config_Data
{

    /**
     * @return string robots.txt file path.
     */
    protected function getRobotsTxtPath()
    {
        return Mage::getBaseDir('base') . '/robots.txt';
    }

    /**
     * Rewrite robots.txt when the configuration is saved.
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        $contents = $this->getValue();
        $ret = file_put_contents($this->getRobotsTxtPath(), $contents);

        if ($ret === false) {
            throw new Exception('Failed to write robots.txt.');
        }

        return $this;
    }

    /**
     * Load the value directly from the robots.txt file.
     *
     * If the file does not exist, discard what is in the magento config and
     * load an empty string.
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        $path = $this->getRobotsTxtPath();

        if(file_exists($path)) {
            $this->setValue(file_get_contents($path));
        } else {
            $this->setValue('');
        }
    }

}
