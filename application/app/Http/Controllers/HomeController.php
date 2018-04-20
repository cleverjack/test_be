<?php namespace App\Http\Controllers;

use App;
use Auth;
use Lang;
use Illuminate\View\View;
use App\Services\DeviceDetector;

class HomeController extends Controller
{

    /**
     * Settings service instance.
     *
     * @var App\Services\Settings;
     */

    /**
     * DeviceDetector service instance.
     *
     * @var App\Services\DeviceDetector;
     */
    private $deviceDetector;

    public function __construct(DeviceDetector $deviceDetector)
    {
        $this->deviceDetector = $deviceDetector;
    }

    /**
     * Show the application home screen to the user.
     *
     * @return View
     */
    public function index()
    {
        $pushStateRootUrl = '/';
        return view('main')
            ->with('user', Auth::user())
            ->with('isDemo', IS_DEMO)
            ->with('version', VERSION);
    }
}
