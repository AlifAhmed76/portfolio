<?php

namespace Tests;

use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();
    }
}
