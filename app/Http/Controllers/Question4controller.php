<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Question4controller extends Controller
{
    public function viewHomePage()
    {
        
        return view('Question4');  
    }
    public function roll_item($tiers, $vipRanks) {

        $weights = [];
        // Fibonacci sequence
        $num1 = 1;
        $num2 = 2;
        $next_number = $num2 + $num1;
        

            foreach ($tiers as $tier){
                $weights[] = $next_number;
                $num1 = $num2;
                $num2 = $next_number;
                $next_number = $num1 + $num2;
            }
        
        rsort($weights);
        if ($vipRanks >= count($tiers)) {
            $weights[count($weights) - 1] += 50;
        }
        else{
            $weights[$vipRanks] += 50;
        }

        $totalWeight = array_sum($weights);
        
        $randomNumber = mt_rand(1, $totalWeight);

        $currentWeight = 0;
        foreach ($tiers as $index => $tier) {
            $currentWeight += $weights[$index];
            if ($randomNumber <= $currentWeight) {
                return $tier;
            }
        }
    }   


   public function get_roll_item_result(){

    $lastitemCounts = [];
    $vipRanks = ['V1', 'V2', 'V3', 'V4', 'V5'];

    $tiers = ['T1', 'T2', 'T3', 'T4', 'T5'];

    $itemCounts = ['T1' => 0, 'T2' => 0, 'T3' => 0, 'T4' => 0 , "T5"=>0 ];
    foreach ($vipRanks as $rank => $vipRank) {  
        for ($i = 0; $i < 100; $i++) {
            $item = $this->roll_item($tiers, $rank+1);
            $itemCounts[$item]++;
        } 
        $lastitemCounts[$vipRank] = $itemCounts;
        $itemCounts = ['T1' => 0, 'T2' => 0, 'T3' => 0, 'T4' => 0 , "T5"=>0 ];
    }
    
    $itemCountsJson = json_encode($lastitemCounts);
    return back()->with('message', $itemCountsJson);
    }

}
