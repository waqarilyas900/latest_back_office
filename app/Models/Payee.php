<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'vendor_name', 'contact_name', 'phone', 'email', 'fax',
        'state', 'city', 'zip_code', 'account_number', 'payment_method',
        'address_1', 'address_2', 'term_id', 'pos_id', 'department_id',
        'default_margin', 'default_bank_account_id', 'fintech_vendor_code',
        'types'
    ];

    protected $casts = [
        'types' => 'array',
    ];

    public function term() 
    { 
        return $this->belongsTo(Term::class); 
    }
    public function department() 
    { 
        return $this->belongsTo(Department::class); 
    }
    public function bankAccount() 
    { 
        return $this->belongsTo(BankAccount::class, 'default_bank_account_id');
    }
}
