<?php
/**
 * Soorajmalhi Purge Cloudflare Cache Extension
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Soorajmalhi
 * @package    Soorajmalhi_Cloudflare
 * @copyright  Copyright (c) 2023 SoorajMalhi
 * @author     Sooraj Malhi <soorajmalhi@gmail.com
 */

/**
 * Add Cloudflare flush button in admin
 */
class Soorajmalhi_Cloudflare_Block_Adminhtml_Cache extends Mage_Adminhtml_Block_Cache
{
    /**
     * Class constructor
     */
    public function __construct()
    {	
        parent::__construct();
        $message = Mage::helper('core')->__('Cache storage may contain additional data. Are you sure that you want flush it?');

        $this->_addButton('flush_cloudflare_css', array(
            'label'     => Mage::helper('core')->__('Flush CloudFlare CSS'),
            'onclick'   => 'confirmSetLocation(\''.$message.'\', \'' . $this->getFlushCloudflareCssUrl() .'\')',
            'class'     => 'delete',
        ));

        $this->_addButton('flush_cloudflare_js', array(
            'label'     => Mage::helper('core')->__('Flush CloudFlare JS'),
            'onclick'   => 'confirmSetLocation(\''.$message.'\', \'' . $this->getFlushCloudflareJsUrl() .'\')',
            'class'     => 'delete',
        ));
    }

    /**
     * Get url for clean Cloudflare CSS cache storage
     * @return string
     */
    public function getFlushCloudflareCssUrl()
    {
        return Mage::getBaseUrl().'cloudflare/adminhtml_cloudflare/deletecss';
    }

    /**
     * Get url for clean Cloudflare JS cache storage
     * @return string
     */
    public function getFlushCloudflareJsUrl()
    {
        return Mage::getBaseUrl().'cloudflare/adminhtml_cloudflare/deletejs';
    }
}
