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
      new JMS\SerializerBundle\JMSSerializerBundle(),
      
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
      new Sonata\ClassificationBundle\SonataClassificationBundle(),
      new Sonata\PageBundle\SonataPageBundle(),
      new Sonata\CacheBundle\SonataCacheBundle(),
      new Sonata\SeoBundle\SonataSeoBundle(),
      new Sonata\NotificationBundle\SonataNotificationBundle(),
      new Sonata\NewsBundle\SonataNewsBundle(),
      new Sonata\FormatterBundle\SonataFormatterBundle(),
      // CKEditor by SonataFormatterBundle
      new Sonata\MarkItUpBundle\SonataMarkItUpBundle(),
      new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
      new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
      //
      new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
      new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
      new Application\Sonata\NewsBundle\ApplicationSonataNewsBundle(),
      new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(),
      new Application\Sonata\PageBundle\ApplicationSonataPageBundle(),
      new Application\Sonata\NotificationBundle\ApplicationSonataNotificationBundle(),
      new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
      new Lunetics\LocaleBundle\LuneticsLocaleBundle(),
      new Parsley\ServerBundle\ParsleyServerBundle(),
      new Yorku\JuturnaBundle\YorkuJuturnaBundle(),
      new Map2u\CoreBundle\Map2uCoreBundle(),
      new Map2u\WebBundle\Map2uWebBundle(),
      new Map2u\LeafletBundle\Map2uLeafletBundle(),
      new EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle(),
      new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
      
       new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
       new Ibrows\Bundle\NewsletterBundle\IbrowsNewsletterBundle(),  
      new Ibrows\Map2uBundle\IbrowsMap2uBundle(),
      new Wowo\NewsletterBundle\WowoNewsletterBundle(),
      new Wowo\QueueBundle\WowoQueueBundle(),

      
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
