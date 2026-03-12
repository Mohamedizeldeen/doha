@extends('admin.layout.app')

@section('page-title', __('admin.new_invoice'))

@section('content')
<form method="POST" action="{{ route('invoice.store', $salon) }}" id="invoiceForm">
    @csrf
    
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start;">
        <!-- Left: Items -->
        <div>
            <!-- Client & Booking -->
            <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; margin-bottom: 1rem;">
                <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                    <i class="fas fa-user" style="color: var(--primary);"></i> {{ __('admin.client_info') }}
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.client') }}</label>
                        <select name="client_id" style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; font-size: 0.8rem; margin-top: 0.25rem;">
                            <option value="">{{ __('admin.walk_in_client') }}</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ ($booking && $booking->client_id == $client->id) ? 'selected' : '' }}>
                                    {{ app()->getLocale() === 'ar' ? $client->name_ar : $client->name_en }} - {{ $client->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if($booking)
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    @endif
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.payment_method') }}</label>
                        <select name="payment_method" style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; font-size: 0.8rem; margin-top: 0.25rem;">
                            <option value="cash">{{ __('admin.pay_cash') }}</option>
                            <option value="card">{{ __('admin.pay_card') }}</option>
                            <option value="wallet">{{ __('admin.pay_wallet') }}</option>
                            <option value="partial">{{ __('admin.pay_partial') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Add Items -->
            <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
                <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                    <i class="fas fa-list" style="color: var(--primary);"></i> {{ __('admin.invoice_items') }}
                </h3>

                <!-- Quick Add Buttons -->
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                    <button type="button" onclick="showServicePicker()" style="padding: 0.4rem 0.75rem; background: #fdf2f8; color: var(--primary); border: 1px solid var(--primary); border-radius: 0.5rem; font-size: 0.75rem; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-concierge-bell"></i> {{ __('admin.add_service') }}
                    </button>
                    <button type="button" onclick="showProductPicker()" style="padding: 0.4rem 0.75rem; background: #f0f9ff; color: #2563eb; border: 1px solid #2563eb; border-radius: 0.5rem; font-size: 0.75rem; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-box"></i> {{ __('admin.add_product') }}
                    </button>
                </div>

                <!-- Items List -->
                <div id="itemsList">
                    @if($booking)
                    <div class="invoice-item" data-type="service" data-id="{{ $booking->service_id }}" data-price="{{ $booking->service->price }}">
                        <input type="hidden" name="items[0][type]" value="service">
                        <input type="hidden" name="items[0][id]" value="{{ $booking->service_id }}">
                        <input type="hidden" name="items[0][quantity]" value="1">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem; margin-bottom: 0.5rem;">
                            <div>
                                <span style="font-size: 0.7rem; padding: 0.1rem 0.4rem; background: #fdf2f8; color: var(--primary); border-radius: 0.25rem;">{{ __('admin.service') }}</span>
                                <span style="font-size: 0.8rem; font-weight: 600; margin-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0.5rem;">
                                    {{ app()->getLocale() === 'ar' ? $booking->service->name_ar : $booking->service->name_en }}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-weight: 700; color: #1f2937; font-size: 0.85rem;">{{ number_format($booking->service->price, 2) }}</span>
                                <button type="button" onclick="removeItem(this)" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.85rem;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div id="emptyMessage" style="text-align: center; padding: 2rem; color: #d1d5db; {{ $booking ? 'display:none;' : '' }}">
                    <i class="fas fa-receipt" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
                    <span style="font-size: 0.8rem;">{{ __('admin.add_items_to_invoice') }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Summary -->
        <div style="background: #fff; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem; position: sticky; top: 80px;">
            <h3 style="font-size: 0.9rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                <i class="fas fa-calculator" style="color: var(--primary);"></i> {{ __('admin.summary') }}
            </h3>
            
            <div style="space-y: 0.5rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.8rem; color: #6b7280;">
                    <span>{{ __('admin.subtotal') }}</span>
                    <span id="subtotalDisplay">0.00</span>
                </div>
                
                <div style="padding: 0.5rem 0;">
                    <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.discount') }}</label>
                    <input type="number" name="discount_amount" value="0" min="0" step="0.01" 
                           onchange="updateTotals()" 
                           style="width: 100%; padding: 0.4rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.8rem; margin-top: 0.25rem;">
                </div>

                <div style="padding: 0.5rem 0;">
                    <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.coupon_code') }}</label>
                    <div style="display: flex; gap: 0.5rem; margin-top: 0.25rem;">
                        <input type="text" name="coupon_code" id="couponCode" placeholder="{{ __('admin.enter_coupon') }}"
                               style="flex: 1; padding: 0.4rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.8rem;">
                        <button type="button" onclick="validateCoupon()" style="padding: 0.4rem 0.75rem; background: var(--primary); color: #fff; border: none; border-radius: 0.375rem; font-size: 0.75rem; cursor: pointer;">
                            {{ __('admin.apply') }}
                        </button>
                    </div>
                    <span id="couponMessage" style="font-size: 0.7rem; margin-top: 0.25rem; display: block;"></span>
                </div>

                <div style="border-top: 2px solid #e5e7eb; margin-top: 0.5rem; padding-top: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; color: #1f2937;">
                        <span>{{ __('admin.total') }}</span>
                        <span id="totalDisplay" style="color: var(--primary);">0.00 {{ $salon->currency ?? 'OMR' }}</span>
                    </div>
                </div>

                <div style="padding: 0.75rem 0;">
                    <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.paid_amount') }}</label>
                    <input type="number" name="paid_amount" id="paidAmount" value="0" min="0" step="0.01" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.9rem; font-weight: 700; margin-top: 0.25rem;">
                </div>

                <div style="padding: 0.5rem 0;">
                    <label style="font-size: 0.75rem; font-weight: 600; color: #374151;">{{ __('admin.notes') }}</label>
                    <textarea name="notes" rows="2" style="width: 100%; padding: 0.4rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-size: 0.8rem; margin-top: 0.25rem; resize: none;"></textarea>
                </div>

                <button type="submit" style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border: none; border-radius: 0.625rem; font-size: 0.9rem; font-weight: 700; cursor: pointer; margin-top: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="fas fa-check-circle"></i> {{ __('admin.create_invoice') }}
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Service Picker Modal -->
<div id="serviceModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 1rem; padding: 1.5rem; max-width: 500px; width: 90%; max-height: 70vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <h3 style="font-size: 1rem; font-weight: 700;">{{ __('admin.select_service') }}</h3>
            <button type="button" onclick="closeModals()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #6b7280;">&times;</button>
        </div>
        @foreach($services as $service)
        <div onclick="addItem('service', {{ $service->id }}, '{{ addslashes(app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en) }}', {{ $service->price }})"
             style="padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; margin-bottom: 0.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center;"
             onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#e5e7eb'">
            <div>
                <div style="font-size: 0.85rem; font-weight: 600;">{{ app()->getLocale() === 'ar' ? $service->name_ar : $service->name_en }}</div>
                <div style="font-size: 0.7rem; color: #6b7280;">{{ $service->duration_minutes }} {{ __('admin.minutes') }}</div>
            </div>
            <span style="font-weight: 700; color: var(--primary);">{{ number_format($service->price, 2) }}</span>
        </div>
        @endforeach
    </div>
</div>

<!-- Product Picker Modal -->
<div id="productModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 1rem; padding: 1.5rem; max-width: 500px; width: 90%; max-height: 70vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
            <h3 style="font-size: 1rem; font-weight: 700;">{{ __('admin.select_product') }}</h3>
            <button type="button" onclick="closeModals()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #6b7280;">&times;</button>
        </div>
        @foreach($products as $product)
        <div onclick="addItem('product', {{ $product->id }}, '{{ addslashes(app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en) }}', {{ $product->price }})"
             style="padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; margin-bottom: 0.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center;"
             onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='#e5e7eb'">
            <div>
                <div style="font-size: 0.85rem; font-weight: 600;">{{ app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en }}</div>
                <div style="font-size: 0.7rem; color: #6b7280;">{{ __('admin.stock') }}: {{ $product->stock_quantity }}</div>
            </div>
            <span style="font-weight: 700; color: #2563eb;">{{ number_format($product->price, 2) }}</span>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
let itemIndex = {{ $booking ? 1 : 0 }};

function showServicePicker() {
    document.getElementById('serviceModal').style.display = 'flex';
}
function showProductPicker() {
    document.getElementById('productModal').style.display = 'flex';
}
function closeModals() {
    document.getElementById('serviceModal').style.display = 'none';
    document.getElementById('productModal').style.display = 'none';
}

function addItem(type, id, name, price) {
    closeModals();
    document.getElementById('emptyMessage').style.display = 'none';
    
    const list = document.getElementById('itemsList');
    const badge = type === 'service' ? '{{ __("admin.service") }}' : '{{ __("admin.product") }}';
    const badgeBg = type === 'service' ? '#fdf2f8' : '#f0f9ff';
    const badgeColor = type === 'service' ? 'var(--primary)' : '#2563eb';
    
    const html = `
    <div class="invoice-item" data-price="${price}">
        <input type="hidden" name="items[${itemIndex}][type]" value="${type}">
        <input type="hidden" name="items[${itemIndex}][id]" value="${id}">
        <input type="hidden" name="items[${itemIndex}][quantity]" value="1" class="qty-input">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem; margin-bottom: 0.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 0.65rem; padding: 0.1rem 0.35rem; background: ${badgeBg}; color: ${badgeColor}; border-radius: 0.25rem;">${badge}</span>
                <span style="font-size: 0.8rem; font-weight: 600;">${name}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.25rem;">
                    <button type="button" onclick="changeQty(this, -1)" style="width: 24px; height: 24px; border: 1px solid #e5e7eb; border-radius: 0.25rem; background: #fff; cursor: pointer; font-size: 0.7rem;">-</button>
                    <span class="qty-display" style="font-size: 0.8rem; font-weight: 600; min-width: 20px; text-align: center;">1</span>
                    <button type="button" onclick="changeQty(this, 1)" style="width: 24px; height: 24px; border: 1px solid #e5e7eb; border-radius: 0.25rem; background: #fff; cursor: pointer; font-size: 0.7rem;">+</button>
                </div>
                <span class="item-total" style="font-weight: 700; color: #1f2937; font-size: 0.85rem; min-width: 60px; text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">${parseFloat(price).toFixed(2)}</span>
                <button type="button" onclick="removeItem(this)" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.85rem;"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>`;
    
    list.insertAdjacentHTML('beforeend', html);
    itemIndex++;
    updateTotals();
}

function changeQty(btn, delta) {
    const item = btn.closest('.invoice-item');
    const qtyInput = item.querySelector('.qty-input');
    const qtyDisplay = item.querySelector('.qty-display');
    const itemTotal = item.querySelector('.item-total');
    let qty = parseInt(qtyInput.value) + delta;
    if (qty < 1) qty = 1;
    qtyInput.value = qty;
    qtyDisplay.textContent = qty;
    itemTotal.textContent = (parseFloat(item.dataset.price) * qty).toFixed(2);
    updateTotals();
}

function removeItem(btn) {
    btn.closest('.invoice-item').remove();
    updateTotals();
    if (document.querySelectorAll('.invoice-item').length === 0) {
        document.getElementById('emptyMessage').style.display = 'block';
    }
}

function updateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.invoice-item').forEach(item => {
        const price = parseFloat(item.dataset.price || 0);
        const qty = parseInt(item.querySelector('.qty-input')?.value || 1);
        subtotal += price * qty;
    });
    
    const discount = parseFloat(document.querySelector('[name="discount_amount"]').value) || 0;
    const total = Math.max(0, subtotal - discount);
    
    document.getElementById('subtotalDisplay').textContent = subtotal.toFixed(2);
    document.getElementById('totalDisplay').textContent = total.toFixed(2) + ' {{ $salon->currency ?? "OMR" }}';
    document.getElementById('paidAmount').value = total.toFixed(2);
}

function validateCoupon() {
    const code = document.getElementById('couponCode').value;
    if (!code) return;
    
    fetch(`{{ route('invoice.validate-coupon', $salon) }}?code=${code}`)
        .then(r => r.json())
        .then(data => {
            const msg = document.getElementById('couponMessage');
            if (data.valid) {
                msg.style.color = '#059669';
                msg.textContent = data.type === 'percentage' ? `${data.value}% {{ __('admin.discount') }}` : `${data.value} {{ __('admin.discount') }}`;
            } else {
                msg.style.color = '#dc2626';
                msg.textContent = '{{ __("admin.invalid_coupon") }}';
            }
        });
}

// Init totals
updateTotals();
</script>
@endpush
@endsection
