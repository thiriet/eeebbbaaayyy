<?php
/**
 * Created by JetBrains PhpStorm.
 * User: raphaelthiriet
 * Date: 23/06/13
 * Time: 19:42
 * To change this template use File | Settings | File Templates.
 */

namespace Raph\EbayparserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EbayRequesterCommand extends ContainerAwareCommand{

    protected function configure()
    {
        $this
            ->setName('raph:ebay')
            ->setDescription('Request ebay for given argument')
            ->addArgument('country', InputArgument::REQUIRED, 'What country you want to request?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $country= $input->getArgument('country');
        $output->writeln('country to call: '.$country);
        $output->writeln('request ebay now...');
        $requester = $this->getContainer()->get('raph.ebayproductfetcher')->fetchProducts($country);

        $output->writeln('result: '.$requester);
    }
}