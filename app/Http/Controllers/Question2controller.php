<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Question2controller extends Controller
{
    public function viewHomePage()
    {
        
        return view('Question2', ['message' => "[]"]);  
    }
    public function checkDiscount(Request $request){
        $purchaseValue = $request->input('value');
        if ($purchaseValue >= 500) {
            $discount = "discount is 10%"; // 10% discount
        } elseif ($purchaseValue >= 100) {
            $discount = "discount is 5%"; // 5% discount
        } else {
            $discount = "there are no discount"; // No discount
        }
        $answer = '[Purchase Value is '. $purchaseValue . ' ,' . $discount . ']';
        return back()->with('message', $answer);
    }
}
