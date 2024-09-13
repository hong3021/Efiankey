<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;

class Question3controller extends Controller
{
    public function viewHomePage()
    {
        
        return view('Question3');  
    }
    public function checkDate(Request $request){
        $date1 = new DateTime($request->input('date1'));
        $date2 = new DateTime($request->input('date2'));

        // Calculate the difference
        $interval = $date1->diff($date2);

        // Get the number of days
        $daysDifference = $interval->days;

        // Check if the number of days is odd or even
        if ($daysDifference % 2 == 0) {
            $dayType = "even";
        } else {
            $dayType = "odd";
        }
        $answer = '[ Day(s) Between '.$request->input('date2'). ' and ' .$request->input('date1') . ' is '. $daysDifference .' Then Answer is ' . $dayType . ']';
        return back()->with('success', $answer);
    }
}
