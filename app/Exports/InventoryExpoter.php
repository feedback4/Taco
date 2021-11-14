<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;


class InventoryExpoter implements FromCollection , ShouldAutoSize ,WithMapping ,WithHeadings,WithEvents
{
    private $items ;
    public function __construct($items)
    {
        //  dd($selectedOrders);
        $this->items = $items;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
     return Item::with('element','inventory')->find($this->items);
    }
    public function map($item): array
    {
        // TODO: Implement map() method.
        return [
            $item->element->name,
            $item->amount . $item->unit,
            $item->expire_at->format('d/m/Y'),
            $item->inventory->name,
            $item->inventory->manager->name,
            $item->creator->name,
            $item->created_at->format('d/m/Y'),
        ];
    }
    public function headings():array
    {

        return [
            'Element',
            'Amount',
            'Expire At',
            'Inevntory',
            'Inevntory Manager',
            'Buyer',
            'buy at',
        ];
    }
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function(AfterSheet $event){
                //    $event->sheet->getDelegate()->setRightToLeft(true);
                $event->sheet->getStyle('A1:J1')->applyFromArray(
                    [
                        'font'=>['bold'=>true]
                    ]);
            }
        ];
    }
}
