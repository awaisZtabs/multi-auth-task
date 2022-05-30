<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PacksController extends Controller
{
    public function getPacks(Request $request)
    {
        $request->validate([
            'order' => 'required',
        ]);

        $order = $request->order;
        $p1 = 250;
        $p2 = 500;
        $p3 = 1000;
        $p4 = 2000;
        $p5 = 5000;
        $packlist = array();
        do {
            if ($order <= $p1) {
                array_push($packlist, "P1");
                break;
            } else if ($order >= $p1 && $order < $p2) {
                array_push($packlist, "P2");
                $order = 0;
            } else if ($order >= $p2 && $order < $p3) {
                array_push($packlist, "P2");
                $order = $order - $p2;
            } else if ($order >= $p3 && $order < $p4) {
                array_push($packlist, "P3");
                $order = $order - $p3;
            } else if ($order >= $p4 && $order < $p5) {
                array_push($packlist, "P4");
                $order = $order - $p4;
            } else if ($order >= $p5) {
                array_push($packlist, "P5");
                $order = $order - $p5;
            }
            //   dd($order);
        } while ($order != 0);
        return response()->json(['status' => 'success',
            'packlist' => $packlist]);

    }
}
