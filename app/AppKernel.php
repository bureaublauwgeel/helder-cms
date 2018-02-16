<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel
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
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new FOS\HttpCacheBundle\FOSHttpCacheBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            # Kunstmaan Bundles
            new Kunstmaan\UtilitiesBundle\KunstmaanUtilitiesBundle(),
            new Kunstmaan\NodeBundle\KunstmaanNodeBundle(),
            new Kunstmaan\SeoBundle\KunstmaanSeoBundle(),
            new Kunstmaan\MediaBundle\KunstmaanMediaBundle(),
            new Kunstmaan\AdminBundle\KunstmaanAdminBundle(),
            new Kunstmaan\PagePartBundle\KunstmaanPagePartBundle(),
            new Kunstmaan\MediaPagePartBundle\KunstmaanMediaPagePartBundle(),
            new Kunstmaan\AdminListBundle\KunstmaanAdminListBundle(),
            new Kunstmaan\SitemapBundle\KunstmaanSitemapBundle(),
            new Kunstmaan\ArticleBundle\KunstmaanArticleBundle(),
            new Kunstmaan\TranslatorBundle\KunstmaanTranslatorBundle(),
            new Kunstmaan\RedirectBundle\KunstmaanRedirectBundle(),
            new Kunstmaan\UserManagementBundle\KunstmaanUserManagementBundle(),
            new Kunstmaan\DashboardBundle\KunstmaanDashboardBundle(),
            new Kunstmaan\MenuBundle\KunstmaanMenuBundle(),
            # BBG Bundles
            new Bbg\BaseBundle\BbgBaseBundle(),
            new Bbg\KunstmaanAdminBundle\BbgKunstmaanAdminBundle(),
            new Bbg\PagePartBundle\BbgPagePartBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev'], true)) {
            $bundles[] = new Kunstmaan\LiveReloadBundle\KunstmaanLiveReloadBundle();
        }

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Kunstmaan\BehatBundle\KunstmaanBehatBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Kunstmaan\GeneratorBundle\KunstmaanGeneratorBundle();
            $bundles[] = new Bbg\GeneratorBundle\BbgGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
