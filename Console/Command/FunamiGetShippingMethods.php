<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Funami\EmotionShippingMethods\Console\Command;

use Elasticsearch\Endpoints\Get;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Funami\EmotionShippingMethods\Helper\GetShippingMethods;

class FunamiGetShippingMethods extends Command
{

    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";
    private $getShippingMethods;
    /**
     * {@inheritdoc}
     */
    public function __construct(GetShippingMethods $_getShippingMethods)
    {
        $this->getShippingMethods = $_getShippingMethods;
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $name = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);
        $shippingMethods = $this->getShippingMethods->execute();
//        $output->writeln($shippingMethods);
        var_dump($shippingMethods[0]->title);
        $output->writeln('Was here');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("fu:shippingmethods:get");
        $this->setDescription("Get shipping methods from API");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }
}
