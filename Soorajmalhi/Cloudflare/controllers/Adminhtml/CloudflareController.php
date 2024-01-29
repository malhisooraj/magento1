<?php
/**
 * SoorajMalhi Purge Cloudflare Cache Extension
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
 * Cloudflare controller actions
 */
class Soorajmalhi_Cloudflare_Adminhtml_CloudflareController extends Mage_Adminhtml_Controller_action
{
    /**
     * @var string
     */
    protected $_url = 'https://api.cloudflare.com/client/v4/';

    /**
     * Flush cloudflare css cache
     * @return void
     */
    public function deleteCssAction()
    {   
        $redirectUrl = Mage::getBaseUrl().'admin/cache';
        $files = explode(',', Mage::getStoreConfig('cloudflare/cachefiles/css_files'));
        $result = Mage::helper('cloudflare')->purgeFiles($files);

        if($result->success) {
            Mage::getSingleton('adminhtml/session')->addSuccess("CloudFlare CSS Cache Storage Flush Successfully");
        } else {
            Mage::getSingleton('adminhtml/session')->addError("Unable to Flush CloudFlare CSS Cache");
        }
        
        $this->_redirectUrl($redirectUrl);
    }

    /**
     * Flush cloudflare js cache
     * @return void
     */
    public function deleteJsAction()
    {
        $redirectUrl = Mage::getBaseUrl().'admin/cache';
        $files = explode(',', Mage::getStoreConfig('cloudflare/cachefiles/js_files'));
        $result = Mage::helper('cloudflare')->purgeFiles($files);

        if($result->success) {
            Mage::getSingleton('adminhtml/session')->addSuccess("CloudFlare JS Cache Storage Flush Successfully");
        } else {
            Mage::getSingleton('adminhtml/session')->addError("Unable to Flush CloudFlare JS Cache");
        }
        
        $this->_redirectUrl($redirectUrl);
    }
}
