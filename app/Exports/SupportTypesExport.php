<?php

namespace App\Exports;

use App\Models\SupportType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SupportTypesExport implements FromCollection, WithHeadings, WithTitle, WithCustomCsvSettings, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SupportType::select('id', 'type_code', 'type_name')->orderBy('type_code', 'asc')->get();
    }

    public function headings():array
	{
		return [
				'ID', 
				'コード', 
				'名称', 
			]; 
	}

    public function title(): string{

		return 'マスタ';

	}

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
