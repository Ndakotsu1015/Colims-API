<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bank;

class BankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bank::class; 
    
    public static $banks = [
        [1,"Access Bank Plc", "ACB"],
        [2,"Citibank Nigeria Limited", "CITI"],
        [3,"Diamond Bank Plc", "DBT"],
        [4,"Ecobank Nigeria Plc", "ECO"],
        [5,"Enterprise Bank Plc", "ENT"],
        [6,"Fidelity Bank Plc", "FID"],
        [7,"First Bank of Nigeria Plc", "FBN"],
        [8,"First City Monument Bank Plc", "FCMB"],
        [9,"Guaranty Trust Bank Plc", "GTB"],
        [10,"Heritage Bank Plc", "HGB"],
        [11,"Keystone Bank Limited", "KCB"],
        [12,"MainStreet Bank Plc", "MAIN"],
        [13,"Skye Bank Plc", "SKY"],
        [14,"Stanbic IBTC Bank Plc", "STAN"],
        [15,"Standard Chartered Bank Nigeria Limited", "Sterling"],
        [16,"Union Bank of Nigeria Plc", "UNI"],
        [17,"United Bank for Africa Plc", "UBA"],
        [18,"Unity Bank Plc", "UNITY"],
        [19,"Wema Bank Plc", "WEM"],
        [20,"Zenith Bank Plc", "ZEN"],
    ];
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bank =  $this->faker->unique()->randomElement(self::$banks);
        return [
            'id' => $bank[0],
            'name' => $bank[1],
            'bank_code' => $bank[2],
        ];
    }
}