<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $ecsConfig->skip([
        __DIR__ . '/config/app.php',
    ]);

    $ecsConfig->rule(NoUnusedImportsFixer::class);

    $ecsConfig->sets([
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ]);
};
