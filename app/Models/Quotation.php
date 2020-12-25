<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'salesPerson',
        'quotationValidity',
        'paymentTerms',
        'refNumber',
        'deliveryDate',
        'currency',
        'subTotalJobCost',
        'totalJobCost',
        'profit',
        'comment',
        'jobId',
        'items',
        'payments'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'id', 'created_at', 'updated_at'
    // ];
}
