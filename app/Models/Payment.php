<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    /**
     * Payment model
     *
     * @property string $uuid Publicly usable unique UUID
     * @property float $amount Payment amount
     * @property string $currency Payment currency
     * @property int $status Payment status (STATUS_* constants)
     * @property Carbon $created_at Creation date
     * @property Carbon $updated_at Update date
     */
    use HasUuids;

    const int STATUS_PENDING = 0; // Created
    const int STATUS_SUCCESS = 1; // Successful payment
    const int STATUS_FAILED = 2; //Failed payment
    const array VALID_CURRENCY = ['RUB', 'USD', 'EUR'];


    protected $fillable = ['amount', 'currency','status'];
    protected $primaryKey = 'uuid';
    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    /**
     * Return status as text
     *
     * @return string
     */
    public function status_text(): string
    {
        return match ($this->status){
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
            default => 'Unknown',
        };
    }

    /**
     * Validate currency value
     *
     * @param string $input
     * @return bool
     */
    static function isValidCurrency(string $input): bool
    {
        return in_array($input, self::VALID_CURRENCY, true);
    }
}
