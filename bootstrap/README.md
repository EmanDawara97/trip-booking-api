# Trip Booking API

نظام حجز رحلات (Laravel، API فقط بدون أي View).

## التشغيل
composer install
cp .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File
php artisan migrate:fresh --seed
php artisan serve

## الـ Endpoints
| Method | Path | الوظيفة |
|---|---|---|
| GET | /api/trips | قائمة الرحلات |
| GET | /api/trips/{trip} | تفاصيل رحلة |
| GET | /api/trips/{trip}/seats/available | المقاعد المتاحة |
| POST | /api/trips/{trip}/bookings | حجز مقعد |
| GET | /api/bookings/{booking} | تفاصيل حجز |
| PATCH | /api/bookings/{booking}/confirm | تأكيد حجز |
| PATCH | /api/bookings/{booking}/cancel | إلغاء حجز |

## القرارات المعمارية
- singleton: PricingPolicyResolver مسجل كـ singleton في AppServiceProvider. يختار سياسة التسعير (عادية/VIP) حسب نوع الرحلة. الحل singleton لأنه ما يحمل أي حالة، ونوع الرحلة يُعرف وقت الطلب، لذلك ما استعملنا bind مباشر للـ Interface.
- Contextual Binding: لم نستعمله، لأنه لا توجد حالة فعلية تحتاج تنفيذاً مختلفاً عن الباقي.
- Repository: لم نستعمله. الاستعلامات بسيطة ولا تتكرر، والتعامل مع الـ Model مباشرة كافٍ.
- منع الحجز المزدوج: DB::transaction مع lockForUpdate() على صف المقعد داخل BookingService.
- الأخطاء: Exceptions مخصصة (409/422) تُترجم لـ JSON في bootstrap/app.php، وكل ردود الـ API بنفس الصيغة {success, ...}.
- العناصر المحفوظة من الأسابيع السابقة: Enum (BookingStatus, TripType)، Trait (HasSeatAvailability)، Interface (PricingPolicyInterface).