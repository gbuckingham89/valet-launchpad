<?php

namespace Tests\Feature\Http\Web\DashboardController;

use App\Entities\Project;
use App\Entities\Repositories\Projects\Repository;
use App\Entities\Site;
use App\Enums\SiteTypeEnum;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_with_projects()
    {
        $this->mock(Repository::class, function (MockInterface $mock) {
            $mock->shouldReceive('all')
                ->once()
                ->andReturn(new Collection([
                    new Project('example.com', '/Users/Someone/Code/example.com', '^8.0', new Collection([
                        new Site(SiteTypeEnum::parked(), 'example.com', 'https://exmaple.com.test', true),
                        new Site(SiteTypeEnum::linked(), 'child.example.com', 'http://child.exmaple.com.test', false),
                    ])),
                    new Project('foobar.co.uk', '/Users/Someone/Code/foorbar.co.uk', '^7.4|^8.0', new Collection([
                        new Site(SiteTypeEnum::parked(), 'foobar.co.uk', 'https://foobar.co.uk.test', true),
                    ]))
                ]));
        });

        $response = $this->get(route('web.dashboard.index'));

        $response->assertOk()
            ->assertViewIs('dashboard.index')
            ->assertSeeTextInOrder([
                config('app.name'),
                'example.com',
                'https://exmaple.com.test',
                'http://child.exmaple.com.test',
                '/Users/Someone/Code/example.com',
                'PHP: ^8.0',
                'foobar.co.uk',
                '/Users/Someone/Code/foorbar.co.uk',
                'PHP: ^7.4|^8.0',
            ], false)
            ->assertDontSeeText('https://foobar.co.uk.test', false) // This site URL shouldn't be visible because URLs are only shown if a project has more than 1 site
            ->assertDontSeeText('It appears you don\'t have any projects being served through Laravel Valet.', false);
    }

    public function test_page_loads_ok_with_no_projects()
    {
        $this->mock(Repository::class, function (MockInterface $mock) {
            $mock->shouldReceive('all')
                ->once()
                ->andReturn(new Collection());
        });

        $response = $this->get(route('web.dashboard.index'));

        $response->assertOk()
            ->assertViewIs('dashboard.index')
            ->assertSeeTextInOrder([
                config('app.name'),
                'It appears you don\'t have any projects being served through Laravel Valet.',
            ], false);
    }
}
