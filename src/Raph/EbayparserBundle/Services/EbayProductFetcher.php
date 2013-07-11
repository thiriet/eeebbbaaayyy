<?php
/**
 * Created by JetBrains PhpStorm.
 * User: raphaelthiriet
 * Date: 23/06/13
 * Time: 20:02
 * To change this template use File | Settings | File Templates.
 */

namespace Raph\EbayparserBundle\Services;

use Raph\EbayparserBundle\Entity\Product;
use Raph\EbayparserBundle\Services\EbayRequest;
use Doctrine\ORM\EntityManager;


class EbayProductFetcher {

    protected $ebayRequest;

    public function __construct(EntityManager $entityManager, EbayRequest $ebayRequest){
        $this->em = $entityManager;
        $this->ebayRequest=$ebayRequest;
    }

    public function fetchProducts($country)
    {
        //init counters
        $i = $j = $k = $l = 0;
        $countryCall = $country;

        $keywords = $this->em->getRepository('RaphEbayparserBundle:Keyword')->findByActive(1);

        foreach ($keywords as $keyword) {
            //Call Ebay API
            $ebayResponse = $this->ebayRequest->requestEbay(
                'findItemsByKeywords',
                $keyword->getKeyword(),
                $countryCall
            );
            if ($ebayResponse->ack == "Success") {
                foreach ($ebayResponse->searchResult->item as $item) {
                    //$logger->info('objetID: ' . (int)$item->itemId);
                    if (!$this->em->getRepository('RaphEbayparserBundle:Product')->findByebayID((int)$item->itemId)) {
                        $product = new Product();
                        $product->setname((string)$item->title);
                        $product->setDescription((string)$item->viewItemURL);
                        $product->setPrice((float)$item->sellingStatus->currentPrice);
                        $product->setPublicationDate(new \DateTime($item->listingInfo->startTime));
                        $product->setEndDate(new \DateTime($item->listingInfo->endTime));
                        $product->setEbayID((string)$item->itemId);
                        $product->setProductCountry((string)$item->country);
                        $product->setSellPrice((float)0);
                        $product->setSellingState((bool)$item->sellingStatus->sellingState);
                        $product->setBidAmount((int)$item->sellingStatus->bidCount);
                        $product->setCurrency($item->sellingStatus->currentPrice['currencyId']);
                        $product->setKeyword($keyword);
                        $i++;
                        $this->em->persist($product);
                    } else {
                        //$logger->info('objet ' . $item->itemID . ' already in DB');
                        // check si la date de fin est dépassée ou a changée
                        // Si la date de fin a changée, on update EndDate
                        if (new \DateTime($item->listingInfo->endTime) != $this->em->getRepository(
                                'RaphEbayparserBundle:Product'
                            )->findOneByEbayID((int)$item->itemId)->getEndDate()
                        ) {
                            //$logger->info('mise à jour de la date de fin d enchère');
                            $this->em->getRepository('RaphEbayparserBundle:Product')->findOneByEbayID(
                                (int)$item->itemId
                            )->setEndDate(new \DateTime($item->listingInfo->endTime));
                        }
                        // Si vente est finie (vendu), on update son statut par update du SellPrice et on $k++
                        if ($item->sellingStatus->timeLeft == 'PT0S' && $item->sellingStatus->bidCount > 0) {
                            //$logger->info('update du statut -- finie et vendue');
                            $this->em->getRepository('RaphEbayparserBundle:Product')->findOneByEbayID(
                                (int)$item->itemId
                            )->setSellPrice($item->sellingStatus->currentPrice);
                            $k++;
                        } // Si vente est finie (non vendu), on update son statut par update du SellPrice a -1 et on $l++
                        elseif ($item->sellingStatus->timeLeft == 'PT0S' && $item->sellingStatus->bidCount == 0) {
                            //$logger->info('update du statut -- finie non vendue');
                            $this->em->getRepository('RaphEbayparserBundle:Product')->findOneByEbayID(
                                (int)$item->itemId
                            )->setSellPrice("-1");
                            $l++;
                        } // Si vente est non finie, on update le Price
                        elseif ($this->em->getRepository('RaphEbayparserBundle:Product')->findOneByEbayID(
                                (int)$item->itemId
                            )->getPrice() < $item->sellingStatus->currentPrice
                        ) {
                            $this->em->getRepository('RaphEbayparserBundle:Product')->findOneByEbayID(
                                (int)$item->itemId
                            )->setPrice($item->sellingStatus->currentPrice);
                        } else //$logger->info('nothing to do here');
                        //TODO better usage of var j
                        $j++;
                    }
                }
                $this->em->flush();


            }
        }

        return "$i items added and $j items updated including $k sold and $l auction finished with no selling";
    }
}