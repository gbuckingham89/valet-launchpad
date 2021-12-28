<?php

namespace Tests\Unit\Entities;

use App\Entities\Project;
use App\Entities\Site;
use App\Enums\SiteTypeEnum;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function test_get_name()
    {
        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', '^8.1', new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertEquals('example.com', $project->getName());
    }

    public function test_get_path()
    {
        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', '^8.1', new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertEquals('/Users/JohnSmith/Code/example.com', $project->getPath());
    }

    public function test_get_php_semver_constraint()
    {
        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', '^8.1', new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertEquals('^8.1', $project->getPhpSemverConstraint());

        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', null, new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertNull($project->getPhpSemverConstraint());
    }

    public function test_get_sites()
    {
        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', '^8.1', new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertInstanceOf(Collection::class, $project->getSites());
        $this->assertEquals(1, $project->getSites()->count());
        $this->assertInstanceOf(Site::class, $project->getSites()->first());
    }

    public function test_supported_on_current_php_version()
    {
        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', phpversion(), new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertTrue($project->supportedOnCurrentPhpVersion());

        $project = new Project('example.com', '/Users/JohnSmith/Code/example.com', '5.1.*', new Collection([
            new Site(SiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true)
        ]));

        $this->assertFalse($project->supportedOnCurrentPhpVersion());
    }
}
