<?php


namespace App\Command;


use App\Document\Url;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Cert extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'cert:gather';

    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Gathers the SSL expiration data for URLs')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command goes out to each URL and grabs the SSL certificate' .
                ' expiration date and records it, along with the date/time it checked (to avoid' .
                ' hitting the site too often).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $returnValue = Command::SUCCESS;
        /** @var DocumentManager $dm */
        $repo = $this->container->get('doctrine')->getRepository(Url::class);

        try {
            $urls = $repo->findAll();

            /** @var Url $url */
            foreach ($urls as $url) {
                printf("%s\n", $url->getUrl());
            }

        } catch (\Exception $exception) {
            $returnValue = Command::FAILURE;
        }


        return $returnValue;
    }
}