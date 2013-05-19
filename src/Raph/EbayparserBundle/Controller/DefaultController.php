<?php

namespace Raph\EbayparserBundle\Controller;

use Raph\EbayparserBundle\Entity\Keyword;
use Raph\EbayparserBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\MonologBundle;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/ebay/")
     * @Template()
     */
    public function index2Action()
    {
        // add dynamic keywords handling
        $logger = $this->get('logger');
        //init counters
        $i=$j=$k=$l=0;
        //Call Ebay API
        $keys = 'dearmond gold tone';

        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository('RaphEbayparserBundle:Keyword');

        //TODO retrieve keyword object from category
        $keyword = $repository->find(7);

        $repository = $em->getRepository('RaphEbayparserBundle:Product');

        $ebayResponse = $this->get('raph.ebayrequest')->requestEbay('findItemsByKeywords',$keys, 'US');
        if ($ebayResponse->ack == "Success") {
            foreach ($ebayResponse->searchResult->item as $item){
                $logger->info('objetID: '.(int) $item->itemId);
                if(!$repository->findByebayID((int) $item->itemId)){
                    $product = new Product();
                    $product->setname((string) $item->title);
                    $product->setDescription((string) $item->viewItemURL);
                    $product->setPrice((float) $item->sellingStatus->currentPrice);
                    $product->setPublicationDate(new \DateTime($item->listingInfo->startTime));
                    $product->setEndDate(new \DateTime($item->listingInfo->endTime));
                    $product->setEbayID((string) $item->itemId);
                    $product->setProductCountry((string) $item->country);
                    $product->setSellPrice((float) 0);
                    $product->setSellingState((bool) $item->sellingStatus->sellingState);
                    $product->setBidAmount((int) $item->sellingStatus->bidCount);
                    $product->setCurrency($item->sellingStatus->currentPrice['currencyId']);
                    //TODO set Keywords based on the request
                    $product->setKeyword($keyword);
                    $i++;
                    $em->persist($product);
                }
                else {
                    $logger->info('objet '.$item->itemID.' already in DB');
                    $existingProduct = $repository->findOneByEbayID((int) $item->itemId);
                    // check si la date de fin est dépassée ou a changée
                    // Si la date de fin a changée, on update EndDate
                    if(new \DateTime($item->listingInfo->endTime) != $existingProduct->getEndDate()){
                        $logger->info('mise à jour de la date de fin d enchère');
                        $existingProduct->setEndDate(new \DateTime($item->listingInfo->endTime));
                    }
                    // Si vente est finie (vendu), on update son statut par update du SellPrice et on $k++
                    if($item->sellingStatus->timeLeft == 'PT0S' && $item->sellingStatus->bidCount > 0){
                        $logger->info('update du statut -- finie et vendue');
                        $existingProduct->setSellPrice($item->sellingStatus->currentPrice);
                        $k++;
                    }
                    // Si vente est finie (non vendu), on update son statut par update du SellPrice a -1 et on $l++
                    elseif($item->sellingStatus->timeLeft == 'PT0S' && $item->sellingStatus->bidCount == 0){
                        $logger->info('update du statut -- finie non vendue');
                        $existingProduct->setSellPrice("-1");
                        $l++;
                    }
                    // Si vente est non finie, on update le Price
                    elseif ($existingProduct->getPrice() < $item->sellingStatus->currentPrice) $existingProduct->setPrice($item->sellingStatus->currentPrice);
                    else $logger->info('nothing to do here');
                    $j++;
                }
            }
            $em->flush();


        }
        return array('status' => "$i items added and $j items updated including $k sold and $l auction finished with no selling" );
    }
}
