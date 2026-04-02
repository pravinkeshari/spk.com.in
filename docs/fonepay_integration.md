# Fonepay + Fonepay QR Integration (SPK)

## 1. Overview
**Purpose of integration**
Enable customers to pay using Fonepay (standard) and Fonepay QR from the checkout flow, with secure DV hash verification and callback handling.

**Supported payment types**
- Fonepay (standard redirect)
- Fonepay QR

---
## 2. Architecture Flow
1. **Payment request** created in checkout (`PaymentRequest` record saved)
2. **Redirect** to Fonepay dev/live endpoint with signed DV hash
3. **Callback** to merchant Return URL after payment
4. **Verification** of DV hash and marking payment as paid

---
## 3. Implementation Details

### Controllers
- **Fonepay (existing):**
  `/Users/sumitraj/Desktop/public_html/Modules/Gateways/Http/Controllers/FonepayController.php`
- **Fonepay QR (new):**
  `/Users/sumitraj/Desktop/public_html/Modules/Gateways/Http/Controllers/FonepayQrController.php`

### Routes
- `/payment/fonepay/pay`
- `/payment/fonepay/callback`
- `/payment/fonepay-qr/pay`
- `/payment/fonepay-qr/callback`

Defined in:
- `/Users/sumitraj/Desktop/public_html/Modules/Gateways/Routes/web.php`

### Views (redirect forms)
- `/Users/sumitraj/Desktop/public_html/Modules/Gateways/Resources/views/payment/fonepay.blade.php`
- `/Users/sumitraj/Desktop/public_html/Modules/Gateways/Resources/views/payment/fonepay_qr.blade.php`

Both views auto-submit a **GET** form with:
```
PID, MD, PRN, AMT, CRN, DT, R1, R2, RU, DV
```

---
## 4. Configuration Changes
Configurations are stored in `addon_settings` under `payment_config`.

**Required keys:**
- `merchant_code`
- `secret_key`
- `return_url`
- `r1`
- `r2`
- `mode`
- `status`

**Location:**
- Table: `addon_settings`
- Records: `key_name = fonepay`, `key_name = fonepay_qr`

---
## 5. Admin Panel Changes

### Payment method display
To show Fonepay / Fonepay QR in admin payment list:
- `/Users/sumitraj/Desktop/public_html/app/Enums/GlobalConstant.php`
- `/Users/sumitraj/Desktop/public_html/app/Library/Constant.php`
- `/Users/sumitraj/Desktop/public_html/app/Utils/Helpers.php`
- `/Users/sumitraj/Desktop/public_html/app/Traits/PaymentGatewayTrait.php`

### Error fixes (live_values as JSON string)
To prevent `count()` / `foreach()` crashes:
- `/Users/sumitraj/Desktop/public_html/app/Http/Controllers/Admin/ThirdParty/PaymentMethodController.php`
- `/Users/sumitraj/Desktop/public_html/resources/views/admin-views/third-party/payment-method/index.blade.php`
- `/Users/sumitraj/Desktop/public_html/resources/views/admin-views/third-party/payment-method/_payment-gateways-offcanvas.blade.php`

---
## 6. Bug Fixes

### JSON decode issue
`live_values` stored as JSON string was treated as array. Fixed by decoding before `count()` / `foreach()`.

### Swiper UI fix (product details)
Added missing `.swiper` class to product image slider containers:
- `/Users/sumitraj/Desktop/public_html/resources/themes/theme_aster/theme-views/product/details.blade.php`

---
## 7. Database Changes
**Schema changes:** none.

**New / updated config rows:**
- `addon_settings` with keys:
  - `fonepay`
  - `fonepay_qr`

These rows store the payment gateway credentials and mode.

---
## Endpoints
**Dev**
- https://dev-clientapi.fonepay.com/api/merchantRequest

**Live**
- https://clientapi.fonepay.com/api/merchantRequest

---
## DV Hash Reference
**Request DV format:**
```
PID,MD,PRN,AMT,CRN,DT,R1,R2,RU
```

**Callback DV format:**
```
PRN,PID,PS,RC,UID,BC,INI,P_AMT,R_AMT
```

---
## Local Testing Notes
- Fonepay dev requires a **public Return URL**.
- Use ngrok:
  ```
  ngrok http 8000
  ```
- Update Return URL to:
  ```
  https://<ngrok-domain>/payment/fonepay/callback
  ```

---
## Troubleshooting
- **Fonepay dev returns 500**
  - invalid PID/Secret
  - invalid RU (not registered)
  - wrong DV hash format

- **Redirect to home instead of Fonepay**
  - missing mapping in `/Users/sumitraj/Desktop/public_html/app/Traits/Payment.php`

- **Admin payment methods crash**
  - `live_values` stored as string; decode before use
