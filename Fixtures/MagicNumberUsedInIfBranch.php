<?php

declare(strict_types=1);

namespace Fixtures;

use RuntimeException;

final class MagicNumberUsedInIfBranch
{

    private const NUMBER_OF_PLANETS_IN_SOLAR_SYSTEM = 8;
    public string $description = "In this class, we demonstrate usage of magic number in a if statement";

    public function demonstration(int $numberOfPlanets): string
    {
        if ($numberOfPlanets > self::NUMBER_OF_PLANETS_IN_SOLAR_SYSTEM) {
            throw new RuntimeException('You are not in the solar system!');
        } else if ($numberOfPlanets === 0) {
            throw new RuntimeException('No planets, no chicken!');
        }

        return 'Fried chicken on the way!';
    }
}
