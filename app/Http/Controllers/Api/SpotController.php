<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Spot;
use App\Http\Resources\SpotResource;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;

class SpotController extends Controller
{
    public function search()
    {
        $request = request();
        $query = Spot::query();

        if ($val = $request->input('l')) {
            $query->limit($val);
        } else {
            $query->limit(300);
        }

        if ($request->has('official')) {
            $query->official(($request->input('official')));
        }

        if ($val = $request->input('q')) {
            $query->searchName($val);
        }

        if ($val = $request->input('address')) {
            $query->searchAddress($val);
        }

        if ($val = $request->input('category')) {
            $query->searchCategory($val);
        }

        if ($val = $request->input('lang')) {
            $query->lang($val);
        }

        if (($ne = $request->input('ne')) && ($sw = $request->input('sw'))) {
            if (preg_match('/\A\-?\d{2}\.\d+,\-?\d{3}\.\d+\z/', $ne)
                && preg_match('/\A\-?\d{2}\.\d+,\-?\d{3}\.\d+\z/', $sw)
            ) {
                list($nelat, $nelng, $swlat, $swlng) = explode(',', $ne.','.$sw);
                $ne = new Point($nelat, $nelng);
                $sw = new Point($swlat, $swlng);
                $bounds = new Polygon([new LineString([
                    new Point($sw->getLat(), $ne->getLng()),
                    $sw,
                    new Point($ne->getLat(), $sw->getLng()),
                    $ne,
                    new Point($sw->getLat(), $ne->getLng()),
                ])]);
                $query->intersects('point', $bounds);
            }

            if (($val = $request->input('center'))
                && preg_match('/\A\-?\d{2}\.\d+,\-?\d{3}\.\d+\z/', $val)
            ) {
                list($lat, $lng) = explode(',', $val);
                $query
                ->addSelect(\DB::raw("ST_Distance(`point`, ST_GeomFromText(?)) * 0.9462943706 * 100000 AS `_distance`"))
                ->addBinding(['POINT('.$lng.' '.$lat.')'], 'select')
                ->orderBy('_distance', 'asc');
            }
        }

        // dd($query->toSql(),$query->getBindings());

        return SpotResource::collection($query->get());
    }
}
