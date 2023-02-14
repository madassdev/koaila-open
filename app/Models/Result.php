<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'filename',
    ];

    public function loadData() {
        switch($this->type) {
            case 'time_to_value':
            case 'daumau':
                $filePath = public_path("/results/".$this->filename);
                if (file_exists($filePath)){
                    $str = file_get_contents($filePath);
                    $data = json_decode($str, true);
                    return json_decode($str, true);
                }   
                return null;
            case 'upsell':
                $upsell_filePath = public_path("/results/".$this->filename);
                if (file_exists($upsell_filePath)){
                    $rows = array_map('str_getcsv', file($upsell_filePath));
                    $headers = array_shift($rows);
                    $csv = array();
                    foreach ($rows as $row) {
                        $csv[] = array_combine($headers, $row);
                    }
                    return [
                        'headers' => $headers,
                        'rows' => $csv,
                    ];
                }
            default:
                throw new Exception('Unknown result type: '.$this->type);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
