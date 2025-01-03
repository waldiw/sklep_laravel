<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Orders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'street',
        'city',
        'post',
        'email',
        'phone',
        'comments',
        'vat',
        'vatNumber',
        'vatName',
        'vatStreet',
        'vatCity',
        'vatPost',
        'status',
        'uuid',
        'shipping_id',
        'delete',
    ];

    // w widoku dzięki getAdressAttribute pobieramy cały adres $order->adress
    public function getAdressAttribute(): string
    {
        $string = ':street, :city, :post';

        $replaced = preg_replace_array('/:[a-z_]+/', [$this->street, $this->city, $this->post], $string);
        return $replaced;
        //return Storage::url($this->image);
    }

    // w widoku dzięki getvatAdressAttribute pobieramy cały adres $order->vatAdress
    public function getvatAdressAttribute(): string
    {
        $string = ':street, :city, :post';

        $replaced = preg_replace_array('/:[a-z_]+/', [$this->street, $this->city, $this->post], $string);
        return $replaced;
        //return Storage::url($this->image);
    }

    // relacja one to many
    public function carts(): HasMany
    {
        // orderUuid - klucz z klasy Orders, uuid - klucz z klasy Cart
        // czyli w klasie Cart do klucza uuid odnosi się klucz orderUuid z klasy Orders
        return $this->hasMany(Cart::class, 'orderUuid', 'uuid');
    }

    // relacja one to one
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shippings::class);
    }

    // this is the recommended way for declaring event handlers
    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($orders) { // before delete() method call this
            $orders->carts()->each(function($cart) {
                $cart->delete(); // <-- direct deletion
            });
         });
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function scopeCreatedBetweenDates($query, array $dates)
    {
        $start = ($dates[0] instanceof Carbon) ? $dates[0] : Carbon::parse($dates[0]);
        $end   = ($dates[1] instanceof Carbon) ? $dates[1] : Carbon::parse($dates[1]);

        return $query->whereBetween('created_at', [
            $start->startOfDay(),
            $end->endOfDay()
        ]);
    }
}
