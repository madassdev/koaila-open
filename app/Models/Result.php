<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
            case 'sale_funnel':
            case 'feature_adoption':
            case 'time_to_value':
            case 'daumau':
                $filePath = "/results/".$this->filename;
                if (Storage::exists($filePath)){
                        $str = Storage::get($filePath);
                        return json_decode($str, true);
                    }
                return null;
            case 'upsell':
                $upsell_filePath = "/results/".$this->filename;
                if (Storage::exists($upsell_filePath)){
                    $csv = Storage::get($upsell_filePath);
                    $rows = preg_split("/\r\n|\n|\r/", $csv);
                    $headers = str_getcsv(array_shift($rows),',');
                    $csv = array();
                    foreach ($rows as $row) {
                        $row=str_getcsv($row, ',');
                        if(count($row)===count($headers)){
                            $csv[] = array_combine($headers, $row);
                        }

                    }
                    return [
                        'headers' => $headers,
                        'rows' => $csv,
                    ];
                }
                return null;
            default:
                throw new Exception('Unknown result type: '.$this->type);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
