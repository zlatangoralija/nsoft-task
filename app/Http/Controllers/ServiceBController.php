<?php

namespace App\Http\Controllers;

use DeepCopy\f002\A;
use Illuminate\Http\Request;
use App\Account;

class ServiceBController extends Controller
{
    public function store(){
        //Reading message(consumer) data that was previously saved to a data.json file
        $path = base_path('data/data.json'); // path to JSON file
        $data = file_get_contents($path); // put the contents of the file into a variable
        $moneyInformation = json_decode($data, true); // decode the JSON feed
        $amount = $moneyInformation['amount'];

        //Checking if record already exists in database
        $account = Account::all();
        if(count($account)<1){ //If record doesn't exist, make a new record
            $account = new Account;
            $account->balance = $amount;
            $account->save();
            return "Balance successfully saved";
        }else{ //If record does exist, update existing record by increasing or decreasing balance
            $account = Account::all()->first();
            $previousBalance = $account->balance;
            $account->balance = ($previousBalance) + ($amount);
            $account->update();
            return "Balance successfully updated";
        }
    }

    public function show(){
        //Function that displays balance state and the time it was last updated at
        $account = Account::all()->first();
        echo "\n------------------------------------\n";
        echo "Current balance: ".+number_format(($account->balance)/100, 2, '.', '')." EUR";
        echo "\n------------------------------------\n";
        echo "Last updated: ".$account->updated_at->diffForHumans();
        echo "\n-------------------------------------\n";
    }

}
