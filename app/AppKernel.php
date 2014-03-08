<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

  public function registerBundles() {
    $bundles = array(
      new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
      new Symfony\Bundle\SecurityBundle\SecurityBundle(),
      new Symfony\Bundle\TwigBundle\TwigBundle(),
      new Symfony\Bundle\MonologBundle\MonologBundle(),
      new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
      new Symfony\Bundle\AsseticBundle\AsseticBundle(),
      new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
      new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
      new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
      new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
      new Sonata\jQueryBundle\SonatajQueryBundle(),
      new FOS\UserBundle\FOSUserBundle(),
      new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
      new Sonata\BlockBundle\SonataBlockBundle(),
      new Knp\Bundle\MenuBundle\KnpMenuBundle(),
      new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
      // Then add SonataAdminBundle
      new Sonata\CoreBundle\SonataCoreBundle(),
      new Sonata\AdminBundle\SonataAdminBundle(),
      new Sonata\MediaBundle\SonataMediaBundle(),
      // CKEditor by SonataFormatterBundle
      new Sonata\MarkItUpBundle\SonataMarkItUpBundle(),
      new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
      new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
      new Sonata\FormatterBundle\SonataFormatterBundle(),
      //
      new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
      new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
      new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
      new Lunetics\LocaleBundle\LuneticsLocaleBundle(),
      new Parsley\ServerBundle\ParsleyServerBundle(),
      new Yorku\JuturnaBundle\YorkuJuturnaBundle(),
      new Map2u\CoreBundle\Map2uCoreBundle(),
      new Map2u\WebBundle\Map2uWebBundle(),
    );

    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
      $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
      $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
      $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
      $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
    }

    return $bundles;
  }

  public function registerContainerConfiguration(LoaderInterface $loader) {
    $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
  }

}
