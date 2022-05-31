<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\ListLocationsRequest;
use MatanYadaev\EloquentSpatial\Objects\Point;

class LocationController extends Controller
{
    public function getLocations (ListLocationsRequest $request) {
        $point = new Point($request->input('latitude'), $request->input('longitude'));
        $rows = Location::whereDistanceSphere('position', $point, '<', $request->input('radius'))
            ->withDistanceSphere('position', $point)
            ->orderByDistanceSphere('position', $point)
            ->get();

        return response()->json([
            'data' => $rows,
            'total' => count($rows)
        ]);
    }
}
