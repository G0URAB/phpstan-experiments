<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../index.php';

final class NoMagicLiteralAllowedRuleTest extends TestCase {

    public function test_something(): void
    {
        self::assertEquals(1,1);
    }
}



