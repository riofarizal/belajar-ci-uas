<?php

namespace App\Models;

use CodeIgniter\Model;

class DiskonModel extends Model
{
    protected $table            = 'diskon';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'nominal'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal' => 'required|valid_date|is_unique[diskon.tanggal]',
        'nominal' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'tanggal' => [
            'is_unique' => 'Diskon untuk tanggal ini sudah ada!'
        ]
    ];

    /**
     * Get discount for specific date
     */
    public function getDiscountByDate($date)
    {
        return $this->where('tanggal', $date)->first();
    }

    /**
     * Get today's discount
     */
    public function getTodayDiscount()
    {
        return $this->getDiscountByDate(date('Y-m-d'));
    }
}