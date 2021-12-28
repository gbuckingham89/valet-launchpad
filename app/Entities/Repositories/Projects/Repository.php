<?php

namespace App\Entities\Repositories\Projects;

use Illuminate\Support\Collection;

interface Repository
{
    /**
     * @return \Illuminate\Support\Collection<int, \App\Entities\Project>
     */
    public function all(): Collection;
}
