<?php

namespace App\Entities\Repositories\Projects;

use App\Entities\Project;
use App\Entities\Site;
use App\Enums\SiteTypeEnum;
use App\Exceptions\Exception;
use Gbuckingham89\ValetAssistant\Entities\Project as VAProject;
use Gbuckingham89\ValetAssistant\Entities\Site as VASite;
use Gbuckingham89\ValetAssistant\Enums\SiteTypeEnum as VASiteTypeEnum;
use Gbuckingham89\ValetAssistant\ValetAssistant;
use Illuminate\Support\Collection;

class ValetAssistantRepository implements Repository
{
    /**
     * @var \Gbuckingham89\ValetAssistant\ValetAssistant
     */
    protected ValetAssistant $valetAssistant;

    /**
     * @param \Gbuckingham89\ValetAssistant\ValetAssistant $valetAssistant
     */
    public function __construct(ValetAssistant $valetAssistant)
    {
        $this->valetAssistant = $valetAssistant;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        return $this->valetAssistant
            ->projects()
            ->map(function (VAProject $vaProject): Project {
                return new Project(
                    $vaProject->getName(),
                    $vaProject->getPath(),
                    $vaProject->getPhpSemverConstraint(),
                    $vaProject->getSites()->map(function (VASite $vaSite): Site {
                        return new Site(
                            $this->mapSiteType($vaSite->getType()),
                            $vaSite->getHostname(),
                            $vaSite->getUrl(),
                            $vaSite->isSecured()
                        );
                    }),
                );
            });
    }

    /**
     * @param \Gbuckingham89\ValetAssistant\Enums\SiteTypeEnum $vaSiteType
     *
     * @return \App\Enums\SiteTypeEnum
     * @throws \App\Exceptions\Exception
     */
    private function mapSiteType(VASiteTypeEnum $vaSiteType): SiteTypeEnum
    {
        switch ($vaSiteType->value) {
            case 'linked':
                return SiteTypeEnum::linked();
            case 'parked':
                return SiteTypeEnum::parked();
        }
        throw new Exception('Unsupported Gbuckingham89\ValetAssistant\Enums\SiteTypeEnum: ' . $vaSiteType->value);
    }
}
