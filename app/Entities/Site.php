<?php

namespace App\Entities;

use App\Enums\SiteTypeEnum;

class Site
{
    /**
     * @var \App\Enums\SiteTypeEnum
     */
    protected SiteTypeEnum $type;

    /**
     * @var string
     */
    protected string $hostname;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var bool
     */
    protected bool $secured;

    /**
     * @param \App\Enums\SiteTypeEnum $type
     * @param string $hostname
     * @param string $url
     * @param bool $secured
     */
    public function __construct(SiteTypeEnum $type, string $hostname, string $url, bool $secured)
    {
        $this->type = $type;
        $this->hostname = $hostname;
        $this->url = $url;
        $this->secured = $secured;
    }

    /**
     * @return \App\Enums\SiteTypeEnum
     */
    public function getType(): SiteTypeEnum
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isSecured(): bool
    {
        return $this->secured;
    }
}
