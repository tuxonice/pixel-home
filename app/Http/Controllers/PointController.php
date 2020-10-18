<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPoints = Point::orderBy('added_on', 'DESC')->paginate(15);
        return View('points.index', ['dataPoints' => $dataPoints]);
    }

}
