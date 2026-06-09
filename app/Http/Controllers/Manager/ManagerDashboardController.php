<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard');
    }
}