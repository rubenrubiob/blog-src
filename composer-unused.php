<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Webmozart\Glob\Glob;

return static function (Configuration $config): Configuration {
    return $config
        ->setAdditionalFilesFor('rubenrubiob/blog-src', [
            __FILE__,
            ...Glob::glob(__DIR__ . '/var/cache/dev/Container*/*.php'),
            ...Glob::glob(__DIR__ . '/config/**/*.php'),
            ...Glob::glob(__DIR__ . '/bin/*.php'),
            ...Glob::glob(__DIR__ . '/public/*.php'),
        ])
        ->addNamedFilter(NamedFilter::fromString('ext-ctype'))
        ->addNamedFilter(NamedFilter::fromString('ext-iconv'))
        ->addNamedFilter(NamedFilter::fromString('thecodingmachine/phpstan-safe-rule'))
        ->addNamedFilter(NamedFilter::fromString('symfony/flex'))
        ->addNamedFilter(NamedFilter::fromString('symfony/runtime'))
        ;
};
