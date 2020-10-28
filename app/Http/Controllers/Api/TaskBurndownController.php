<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Graph\TaskBurndown;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskBurndownController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response((new TaskBurndown(now(), auth()->user()))->get());
    }
}
