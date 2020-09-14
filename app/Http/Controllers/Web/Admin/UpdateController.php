<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Traits\requestFetchers;
use Codedge\Updater\UpdaterManager;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    use requestFetchers;

    protected $manager;

    public function __construct(UpdaterManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;
    }

    public function index()
    {
        $version_installed = $this->manager->source()->getVersionInstalled();
        $has_update = $this->manager->source()->isNewVersionAvailable($version_installed);
        $new_version = $this->manager->source()->getVersionAvailable();

        return \View::make('pages.admin.updates.check-for-updates')
            ->with(
                [
                    'current_version' => $version_installed,
                    'new_version' => $new_version,
                    'has_update' => $has_update,
                ]
            );
    }

    public function update(Request $request)
    {
        if ($this->hasRequestKey($request, 'user')) {
            $user = decrypt($this->getRequestValueOnKey($request, 'user'));

            \Log::info("{$user} attempting to update");
        }

        \Artisan::call('admin:update');

        session()->flash('alert', 'App updated');

        return back();
    }
}
