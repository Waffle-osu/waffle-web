<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;

include(base_path() .'/vendor/mitoteam/jpgraph/src/lib/jpgraph.php');
include(base_path() .'/vendor/mitoteam/jpgraph/src/lib/jpgraph_line.php');

class ActivityGraphController extends Controller {
    public function show() {
        $maxCountUsers = 13;
        $graphTop = $maxCountUsers * 1.1;

        $statsGraph = new \Graph(400, 60);

        $osuStats = [
            1, 1, 1, 1, 2, 2, 2, 2, 2, 3,3,3,3,3,3,6,3,3,6,3,3,3,13,13,12,11,10,5,4,6,
            2, 2, 2, 2, 12, 2, 2, 3, 3, 3,3,7,7,7,7,7,7,5,5,5,5,5,3,3,3,3,3,3,3,3,
            2,12,12,12,12,12,12,12,11,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5
        ];

        $statsGraph->SetColor('#faebeb');
        $statsGraph->SetMargin(0, 0, 0, 1);
        $statsGraph->SetMarginColor('#f0ecfa');
        $statsGraph->SetScale("lin", 0, $graphTop, 0, count($osuStats));

        //Create main stats line plot
        $linePlot = new \LinePlot($osuStats);
        $statsGraph->Add($linePlot);
        $linePlot->SetFillColor("#faebeb");
        $linePlot->SetColor("#ad5151");

        //Creates the Peak text.
        $txt = new \Text( "Peak: " . $maxCountUsers . " users");
        $txt->SetScalePos(0.5, $maxCountUsers);
        $txt->SetColor("black");
        $txt->SetMargin(2);
        $txt->SetAlign("left");
        $statsGraph->AddText($txt);

        $statsGraph->xaxis->HideLabels();
        $statsGraph->yaxis->HideLabels();

        //This try catch is a hotfix for windows
        try {
            $statsGraph->Stroke('activity-graph-temp.png');

            copy('activity-graph-temp.png', 'activity-graph.png');
        }catch (Exception $e) {}

        return response()->file('activity-graph.png');
    }
}
