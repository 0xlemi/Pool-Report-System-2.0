<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Report;


/**
 * Transformer for the report class
 */
class ReportDatatableTransformer extends Transformer
{
    /**
     * Transform report for today's route to datatable friendly array
     * @param  report $report
     * @return array
     */
    public function transform(Report $report)
    {
        $technician = $report->technician;
        return [
            'id' => $report->seq_id,
            'service' => $report->service->name,
            'on_time' => $report->onTime()->styled(),
            'technician' => $technician->name.' '.$technician->last_name,
        ];
    }

}
