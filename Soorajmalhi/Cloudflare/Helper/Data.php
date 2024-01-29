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
 * Cloudflare helper
 */
class Soorajmalhi_Cloudflare_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    protected $_url = 'https://api.cloudflare.com/client/v4/';

    /**
     * send request
     * @param $method
     * @param $url
     * @param $data
     * @return mixed
     */
    public function sendRequest($method, $url, $data = null)
    {   
        $request = new \GuzzleHttp\Message\Request($method, $url,
            [
                'X-Auth-Key' => Mage::helper('core')->decrypt(Mage::getStoreConfig('cloudflare/accountinfo/globalkey')),
                'X-Auth-Email' => Mage::getStoreConfig('cloudflare/accountinfo/email'),
                'Content-Type' => 'application/json'
            ]
        ); 

        if($data !== null) {
            $jsonData = json_encode([ 'files' => $data ]);
            $jsonStream = GuzzleHttp\Stream\Stream::factory($jsonData);
            $request->setBody($jsonStream);
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->send($request, ['timeout' => '5.0']);
        return $response;

    }

    /**
     * Purge Individual Files
     * @param $files
     * @return mixed
     */
    public function purgeFiles($files)
    {
        $zoneId = $this->getZoneId();
        $url = $this->_url . 'zones/' . $zoneId . '/purge_cache';
        $client = $this->sendRequest('DELETE', $url, $files);
        $result = json_decode($client->getBody()->getContents());
        return $result;
        
    }

    /**
     * Get Identifier
     * @return mixed
     */
    public function getZoneId()
    {
        $url = $this->_url . 'zones';
        $response = $this->sendRequest('GET', $url);
        $result = json_decode($response->getBody()->getContents());
        return $result->result[0]->id;
    }
}