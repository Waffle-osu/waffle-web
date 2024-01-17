<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class IndexController extends Controller {
    public function show(): View {
        return view('index');
    }
}
