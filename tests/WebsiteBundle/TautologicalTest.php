<?php

namespace Tests\WebsiteBundle;

use PHPUnit\Framework\TestCase;

/**
 * TautologicalTest
 */
class TautologicalTest extends TestCase
{
    /**
     * Placeholder test
     */
    public function testTautology()
    {
        static::assertTrue(true);
    }
}
