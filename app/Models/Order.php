<?php namespace App\Models;

use App\Models\Helpers\DeleteHelpers;
use App\Models\Order\ExchangeStatus;
use App\Models\Order\PaymentMethodConstants;
use App\Models\Order\PaymentStatusConstants;
use App\Models\Order\StatusConstants;
use Diol\Fileclip\UploaderIntegrator;
use Diol\Fileclip\Version\BoxVersion;
use Diol\FileclipExif\Glue;

/**
 * \App\Models\Order
 *
 * @property int $id
 * @property string $status
 * @property string $type
 * @property int|null $client_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string $payment_status
 * @property string|null $payment_method
 * @property string|null $delivery_method
 * @property string|null $postcode
 * @property int|null $region_id
 * @property string|null $city
 * @property string|null $street
 * @property string|null $building
 * @property string|null $flat
 * @property string|null $comment
 * @property string|null $uid
 * @property string|null $user_agent
 * @property string|null $device_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $exchange_status
 * @property int $psbank_payment_link_sent
 * @property \Illuminate\Support\Carbon|null $psbank_payment_link_sent_date_at
 * @property int $paid_admin_email_sent
 * @property int $paid_client_email_sent
 * @property-read mixed $can_be_paid_by_card
 * @property-read mixed $code1c
 * @property-read mixed $full_address
 * @property-read mixed $is_finished_status
 * @property-read mixed $is_paid
 * @property-read mixed $price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read int|null $psbank_payments_count
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereExchangeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaidAdminEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaidClientEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePsbankPaymentLinkSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePsbankPaymentLinkSentDateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserAgent($value)
 * @mixin \Eloquent
 */
class Order extends \Eloquent
{
    use ExchangeStatus;
    use Glue;

    private const CODE_1C_PREFIX = 'CSO';

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CLOSED = 'closed';

    const DELIVERY_COURIER = 'courier';
    const DELIVERY_SELF = 'self';
    const DELIVERY_CDEK = 'cdek';
    const DELIVERY_SELF_CDEK = 'self_cdek';

    const PAYMENT_CASH = 'cash';
    const PAYMENT_ONLINE = 'cashless';
    const PAYMENT_INVOICE = 'invoice';

    protected $fillable = [
        'client_id',
        'name',
        'status',
        'type',
        'payment_status',
        'payment_method',
        'delivery_method',
        'email',
        'phone',
        'postcode',
        'region_id',
        'city',
        'street',
        'building',
        'flat',
        'comment',
        'uid',
        'user_agent',
        'device_type',
        'exchange_status',
        'icon_file',
        'icon_remove',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function getPriceAttribute()
    {
        $result = 0;

        foreach ($this->items as $item) {
            $result += $item->summary_price;
        }

        return $result;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function (self $order) {
                $order->status = StatusConstants::NOVEL;
                $order->uid = \Str::random();
            }
        );

        self::mountUploader(
            'icon',
            UploaderIntegrator::getUploader('uploads/attributes', ['thumb' => new BoxVersion(25, 25)])
        );

        static::deleting(
            function (self $order) {
                DeleteHelpers::deleteRelatedAll($order->items());
            }
        );
    }
}
