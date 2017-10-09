<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use App\Crypto\SubstitutionCipherCracker;
use App\Tokenizer\CharacterTokenizer;
use App\Tokenizer\NgramTokenizer;
use App\Controller\CryptoController;
use App\Factory\FrequencyDistributionFactory;
use App\Factory\SubstitutionCipherFactory;
use App\Analysis\LanguageModel;
use App\Smoother\NGramSmoother;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new ValidatorServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    return $twig;
});

$app['language.model'] = function () use ($app) {
    return new LanguageModel(
        $app['crypto.source_path']
    );
};

$app['smoother.ngram'] = function () use ($app) {
    return new NGramSmoother(
        $app['language.model']->getQuadgramDistribution(),
        new FrequencyDistributionFactory(),
        new NgramTokenizer(4)
    );
};

$app['crypto.cipher_cracker'] = function () use ($app) {
    return new SubstitutionCipherCracker(
        new CharacterTokenizer(),
        new FrequencyDistributionFactory(),
        new SubstitutionCipherFactory(),
        $app['language.model']->getUnigramDistribution(),
        $app['smoother.ngram']
    );
};

$app['crypto.controller'] = function () use ($app) {
    return new CryptoController(
        $app['crypto.cipher_cracker'],
        $app['form.factory'],
        $app['twig']
    );
};

return $app;
