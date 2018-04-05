<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel
 *
 * phpcs:ignoreFile
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            # Kunstmaan bundles
            new Kunstmaan\UtilitiesBundle\KunstmaanUtilitiesBundle(),
            new Kunstmaan\NodeBundle\KunstmaanNodeBundle(),
            new Kunstmaan\SeoBundle\KunstmaanSeoBundle(),
            new Kunstmaan\MediaBundle\KunstmaanMediaBundle(),
            new Kunstmaan\AdminBundle\KunstmaanAdminBundle(),
            new Kunstmaan\PagePartBundle\KunstmaanPagePartBundle(),
            new Kunstmaan\MediaPagePartBundle\KunstmaanMediaPagePartBundle(),
            new Kunstmaan\AdminListBundle\KunstmaanAdminListBundle(),
            // new Kunstmaan\SearchBundle\KunstmaanSearchBundle(),
            // new Kunstmaan\NodeSearchBundle\KunstmaanNodeSearchBundle(),
            new Kunstmaan\TranslatorBundle\KunstmaanTranslatorBundle(),
            new Kunstmaan\RedirectBundle\KunstmaanRedirectBundle(),
            new Kunstmaan\UserManagementBundle\KunstmaanUserManagementBundle(),
            new Kunstmaan\DashboardBundle\KunstmaanDashboardBundle(),
            new Kunstmaan\MenuBundle\KunstmaanMenuBundle(),
            # Application bundles
            new WebsiteBundle\WebsiteBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Kunstmaan\GeneratorBundle\KunstmaanGeneratorBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $loader->load(
            function (ContainerBuilder $container) {
                $container->setParameter('container.autowiring.strict_mode', true);
                $container->setParameter('container.dumper.inline_class_loader', true);

                $container->addObjectResource($this);
            }
        );
        /** @noinspection PhpUnhandledExceptionInspection */
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
