<?php
// /src/Raph/EbayparserBundle/Services/EbayRequest.php

namespace Raph\EbayparserBundle\Services;

class EbayRequest{

    private $ebayUrl = 'http://svcs.ebay.com/services/search/FindingService/v1?';
    private $header = array('X-EBAY-SOA-SECURITY-APPNAME' => 'RaphaelT-f2c4-4f7a-ad31-0e9c76942793','X-EBAY-SOA-SERVICE-VERSION' => '1.0.0', 'X-EBAY-API-REQUEST-DATA-FORMAT'=>'XML', 'X-EBAY-SOA-SERVICE-NAME'=>'FindingService');
    public  $operation;
    public  $keywords;
    public  $country;
    protected $gremo_buzz, $logger;

    public function __construct(\Buzz\Browser $gremo_buzz, \Monolog\Logger $logger){
        $this->browser = $gremo_buzz;
        // Create the logger

        $this->logger = $logger;
        }
    public function requestEbay($operation, $keywords, $country){
        $this->header['X-EBAY-SOA-OPERATION-NAME']=$operation;
        $this->header['OPERATION-NAME']=$operation;
        $this->header['X-EBAY-SOA-GLOBAL-ID']='EBAY-'.$country;
        $content ='<?xml version="1.0" encoding="utf-8"?>
        <'.$operation.'Request xmlns="http://www.ebay.com/marketplace/search/v1/services"><keywords>'.$keywords.'</keywords></'.$operation.'Request>';
        $response = $this->browser->post($this->ebayUrl, $this->header, $content);
        //$this->logger->error($response->getContent());
        return simplexml_load_string($response->getContent());
        }
}


http://svcs.ebay.com/services/search/FindingService/v1?SECURITY-APPNAME=RaphaelT-f667-493d-9a4f-2ceb0624de0e&SERVICE-VERSION=1.12.0&RESPONSE-DATA-FORMAT=XML&OPERATION-NAME=findItemsByKeywords&keywords=guitare&