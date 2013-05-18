<?php
/**
 * Created by JetBrains PhpStorm.
 * User: raphaelthiriet
 * Date: 17/04/13
 * Time: 18:34
 * To change this template use File | Settings | File Templates.
 */

namespace Raph\EbayparserBundle\Services;

use Raph\EbayparserBundle\Entity\Product;

class ProductService {
    public function __construct(\Buzz\Browser $gremo_buzz, \Monolog\Logger $logger){
        // Create the logger
        $this->logger = $logger;
    }

}