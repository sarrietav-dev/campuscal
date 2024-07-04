<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamsController extends Controller
{
    public function index()
    {
        return Inertia::render('Team/Index');
    }
}
