<?php

namespace App\Entities;

use Composer\Semver\Semver;
use Illuminate\Support\Collection;

class Project
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string|null
     */
    protected ?string $phpSemverConstraint;

    /**
     * @var \Illuminate\Support\Collection<int, \App\Entities\Site>
     */
    protected Collection $sites;

    /**
     * @param string $name
     * @param string $path
     * @param string|null $phpSemverConstraint
     * @param \Illuminate\Support\Collection<int, \App\Entities\Site> $sites
     */
    public function __construct(string $name, string $path, ?string $phpSemverConstraint, Collection $sites)
    {
        $this->name = $name;
        $this->path = $path;
        $this->phpSemverConstraint = $phpSemverConstraint;
        $this->sites = $sites;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string|null
     */
    public function getPhpSemverConstraint(): ?string
    {
        return $this->phpSemverConstraint;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    /**
     * @return bool|null
     */
    public function supportedOnCurrentPhpVersion(): ?bool
    {
        if ($this->phpSemverConstraint === null) {
            return null;
        }

        return Semver::satisfies(phpversion(), $this->phpSemverConstraint);
    }
}
