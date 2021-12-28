<?php

namespace App\Http\Controllers\Web;

use App\Entities\Repositories\Projects\Repository;
use App\Http\Controllers\WebController;
use Illuminate\Contracts\View\View;

class DashboardController extends WebController
{
    /**
     * @param \App\Entities\Repositories\Projects\Repository $projectsRepository
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getIndex(Repository $projectsRepository): View
    {
        return view('dashboard.index', [
            'projects' => $projectsRepository->all(),
        ]);
    }
}
