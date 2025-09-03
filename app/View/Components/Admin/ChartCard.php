<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ChartCard extends Component
{
    public $id;
    public $title;
    public $labels;
    public $data;
    public $borderColor;
    public $bgColor;

    public function __construct($id, $title, $labels, $data, $borderColor = '#3b82f6', $bgColor = '#93c5fd')
    {
        $this->id = $id;
        $this->title = $title;
        $this->labels = $labels;
        $this->data = $data;
        $this->borderColor = $borderColor;
        $this->bgColor = $bgColor;
    }

    public function render()
    {
        return view('components.admin.chart-card');
    }
}
