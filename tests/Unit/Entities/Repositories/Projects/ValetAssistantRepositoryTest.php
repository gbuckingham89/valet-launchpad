<?php

namespace Tests\Unit\Entities\Repositories\Projects;

use App\Entities\Project;
use App\Entities\Repositories\Projects\ValetAssistantRepository;
use App\Entities\Site;
use App\Enums\SiteTypeEnum;
use Gbuckingham89\ValetAssistant\Entities\Project as VAProject;
use Gbuckingham89\ValetAssistant\Entities\Site as VASite;
use Gbuckingham89\ValetAssistant\Enums\SiteTypeEnum as VASiteTypeEnum;
use Gbuckingham89\ValetAssistant\ValetAssistant;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Spatie\Enum\Phpunit\EnumAssertions;
use Tests\TestCase;

class ValetAssistantRepositoryTest extends TestCase
{
    public function test_returns_all_projects()
    {
        $this->mock('files', function ($mock) {
            $mock->shouldReceive('exists')
                ->with('/Users/WalterWhite/Code/example.com/composer.json')
                ->once()
                ->andReturn(true);
            $mock->shouldReceive('get')
                ->with('/Users/WalterWhite/Code/example.com/composer.json')
                ->once()
                ->andReturn('{ "name": "foo/bar", "require": { "php": "^7.3|^8.0", "ext-json": "*", "illuminate/support": "^8.77" } }');
            $mock->shouldReceive('exists')
                ->with('/Users/WalterWhite/Code/foobar.co.uk/composer.json')
                ->once()
                ->andReturn(true);
            $mock->shouldReceive('get')
                ->with('/Users/WalterWhite/Code/foobar.co.uk/composer.json')
                ->once()
                ->andReturn('{ "name": "foo/bar", "require": { "php": "8.1.*", "ext-json": "*", "illuminate/support": "^8.77" } }');
        });

        $this->mock(ValetAssistant::class, function (MockInterface $mock) {
            $mock->shouldReceive('projects')
                ->once()
                ->andReturn(new Collection([
                    new VAProject('/Users/WalterWhite/Code/example.com', new Collection([
                        new VASite(VASiteTypeEnum::parked(), 'example.com', 'https://example.com.test', true),
                    ])),
                    new VAProject('/Users/WalterWhite/Code/foobar.co.uk', new Collection([
                        new VASite(VASiteTypeEnum::linked(), 'baz', 'https://baz.test', true),
                        new VASite(VASiteTypeEnum::parked(), 'foobar.co.uk', 'http://foobar.co.uk.test', false),
                    ])),
                ]));
        });

        $repository = $this->app->make(ValetAssistantRepository::class);

        $projects = $repository->all();

        $this->assertInstanceOf(Collection::class, $projects);
        $this->assertEquals(2, $projects->count());

        // Project 0
        $this->assertInstanceOf(Project::class, $projects->get(0));
        $this->assertEquals('example.com', $projects->get(0)->getName());
        $this->assertEquals('/Users/WalterWhite/Code/example.com', $projects->get(0)->getPath());
        $this->assertEquals('^7.3|^8.0', $projects->get(0)->getPhpSemverConstraint());

        $this->assertInstanceOf(Collection::class, $projects->get(0)->getSites());
        $this->assertEquals(1, $projects->get(0)->getSites()->count());

        $this->assertInstanceOf(Site::class, $projects->get(0)->getSites()->get(0));
        EnumAssertions::assertEqualsEnum(SiteTypeEnum::parked(), $projects->get(0)->getSites()->get(0)->getType());
        $this->assertEquals('example.com', $projects->get(0)->getSites()->get(0)->getHostname());
        $this->assertEquals('https://example.com.test', $projects->get(0)->getSites()->get(0)->getUrl());
        $this->assertTrue($projects->get(0)->getSites()->get(0)->isSecured());

        // Project 1
        $this->assertInstanceOf(Project::class, $projects->get(1));
        $this->assertEquals('foobar.co.uk', $projects->get(1)->getName());
        $this->assertEquals('/Users/WalterWhite/Code/foobar.co.uk', $projects->get(1)->getPath());
        $this->assertEquals('8.1.*', $projects->get(1)->getPhpSemverConstraint());

        $this->assertInstanceOf(Collection::class, $projects->get(1)->getSites());
        $this->assertEquals(2, $projects->get(1)->getSites()->count());

        $this->assertInstanceOf(Site::class, $projects->get(1)->getSites()->get(0));
        EnumAssertions::assertEqualsEnum(SiteTypeEnum::linked(), $projects->get(1)->getSites()->get(0)->getType());
        $this->assertEquals('baz', $projects->get(1)->getSites()->get(0)->getHostname());
        $this->assertEquals('https://baz.test', $projects->get(1)->getSites()->get(0)->getUrl());
        $this->assertTrue($projects->get(1)->getSites()->get(0)->isSecured());

        $this->assertInstanceOf(Site::class, $projects->get(1)->getSites()->get(1));
        EnumAssertions::assertEqualsEnum(SiteTypeEnum::parked(), $projects->get(1)->getSites()->get(1)->getType());
        $this->assertEquals('foobar.co.uk', $projects->get(1)->getSites()->get(1)->getHostname());
        $this->assertEquals('http://foobar.co.uk.test', $projects->get(1)->getSites()->get(1)->getUrl());
        $this->assertFalse($projects->get(1)->getSites()->get(1)->isSecured());
    }

    public function test_when_has_no_projects()
    {
        $this->mock(ValetAssistant::class, function (MockInterface $mock) {
            $mock->shouldReceive('projects')
                ->once()
                ->andReturn(new Collection());
        });

        $repository = $this->app->make(ValetAssistantRepository::class);

        $projects = $repository->all();

        $this->assertInstanceOf(Collection::class, $projects);
        $this->assertTrue($projects->isEmpty());
    }
}
