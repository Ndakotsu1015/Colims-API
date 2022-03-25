<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ContractDocumentType;

class ContractDocumentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractDocumentType::class;


    public static $contractDocumentTypes = [
        [1, 'Contract Agreement'],
        [2, 'Bill Of Quantity'],
        [3, 'CAC Business Registration Certificate'],
        [4, 'TAX Certificate'],
        [5, 'TAX Clearance Certificate'],
        [6, 'Company Profile'],
        [7, 'Contract Agreement'],
        [8, 'NSITF'],
        [9, 'PENCOM Certificate'],
        [10, 'BPP'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $documentType =  $this->faker->unique()->randomElement(self::$contractDocumentTypes);
        return [
            'id' => $documentType[0],
            'name' => $documentType[1],
        ];
    }
}
