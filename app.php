<?php

use Chizu\Context;
use Chizu\Controllers\RootController;
use Exedra\Application;
use Exedra\Routeller\RoutellerRootProvider;
use Exedra\Routing\Group;
use Exedra\Support\Wireman\Wireman;
use Exedra\Support\Wireman\WiremanProvider;
use Twig\Environment;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Application(__DIR__);

$app->provider->add(new RoutellerRootProvider(RootController::class));
$app->provider->add(new WiremanProvider());

$app->factory('runtime.context', Context::class);

$app->factory->intercept('runtime.context', function(Context $context) {
    $context->instance(Context::class, $context);

    return $context;
});

$app->map->middleware(function(Context $context) {
    $loader = new \Twig\Loader\FilesystemLoader($context->app->getRootDir(). '/views');
    $twig = new \Twig\Environment($loader, [
//        'cache' => __DIR__ . '/views/cache',
    ]);

    $context->instance(Environment::class, $twig);

    return $context->next($context);
});


return $app;