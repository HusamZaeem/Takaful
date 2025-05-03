<?php

namespace Database\Seeders;

use App\Models\CaseForm;
use App\Models\CaseType;
use Illuminate\Database\Seeder;
use App\Models\CaseFormCaseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaseFormCaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caseForms = CaseForm::all();
        $caseTypeIds = CaseType::pluck('case_type_id')->toArray();

        foreach ($caseForms as $caseForm) {
            // Pick 1–3 random case type IDs without duplicates
            $randomTypeIds = collect($caseTypeIds)->random(rand(1, 3))->all();

            foreach ($randomTypeIds as $typeId) {
                $caseForm->caseTypes()->attach($typeId);
            }
        }
    }
}
