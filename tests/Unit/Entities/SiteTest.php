<?php

namespace Tests\Unit\Entities;

use App\Entities\Site;
use App\Enums\SiteTypeEnum;
use Spatie\Enum\Phpunit\EnumAssertions;
use Tests\TestCase;

class SiteTest extends TestCase
{
    public function test_get_type()
    {
        $site = new Site(SiteTypeEnum::linked(), 'example.com', 'http://example.com.test', false);

        EnumAssertions::assertEqualsEnum(SiteTypeEnum::linked(), $site->getType());
    }

    public function test_get_hostname()
    {
        $site = new Site(SiteTypeEnum::linked(), 'example.com', 'http://example.com.test', false);

        $this->assertEquals('example.com', $site->getHostname());
    }

    public function test_get_url()
    {
        $site = new Site(SiteTypeEnum::linked(), 'example.com', 'http://example.com.test', false);

        $this->assertEquals('http://example.com.test', $site->getUrl());
    }

    public function test_is_secured()
    {
        $site = new Site(SiteTypeEnum::linked(), 'example.com', 'http://example.com.test', false);

        $this->assertFalse($site->isSecured());

        $site = new Site(SiteTypeEnum::linked(), 'example.com', 'https://example.com.test', true);

        $this->assertTrue($site->isSecured());
    }
}
