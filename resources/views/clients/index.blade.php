@extends('admin.layout.app')

@section('page-title', __('admin.clients'))

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-title { font-size: 1.25rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem; }
    .page-title i { color: #dd208e; }
    .btn-add { background: linear-gradient(135deg, #dd208e, #b01670); color: #fff; padding: 0.6rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(221,32,142,0.3); }
    .client-table-wrapper { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
    .client-table { width: 100%; border-collapse: collapse; }
    .client-table th { background: #f8fafc; padding: 0.85rem 1.25rem; text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}; font-size: 0.72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .client-table td { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; color: #334155; vertical-align: middle; }
    .client-table tr:last-child td { border-bottom: none; }
    .client-table tr:hover td { background: #fafbfc; }
    .client-info { display: flex; align-items: center; gap: 0.85rem; }
    .client-avatar { width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #fdf2f8, #fce7f3); display: flex; align-items: center; justify-content: center; font-size: 0.95rem; color: #dd208e; font-weight: 700; flex-shrink: 0; }
    .client-name { font-weight: 700; color: #1a1a2e; font-size: 0.9rem; }
    .client-name-sub { font-size: 0.75rem; color: #94a3b8; }
    .client-code { background: #f1f5f9; color: #475569; padding: 0.2rem 0.6rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; font-family: monospace; }
    .client-contact { font-size: 0.85rem; color: #475569; }
    .client-contact a { color: #dd208e; text-decoration: none; }
    .booking-count { background: linear-gradient(135deg, #fdf2f8, #fce7f3); color: #dd208e; padding: 0.3rem 0.85rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem; }
    .action-btn { padding: 0.4rem 0.6rem; border-radius: 0.5rem; font-size: 0.8rem; text-decoration: none; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; }
    .action-edit { background: #fef3c7; color: #92400e; }
    .action-edit:hover { background: #fde68a; }
    .action-view { background: #dbeafe; color: #1e40af; }
    .action-view:hover { background: #bfdbfe; }
    .action-delete { background: #fee2e2; color: #991b1b; }
    .action-delete:hover { background: #fecaca; }
    .empty-state { text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); }
    .empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
    .empty-state p { color: #94a3b8; font-size: 0.95rem; }
    .toast-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.85rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; }

    /* Mobile card layout */
    .client-cards { display: none; }
    @media (max-width: 768px) {
        .client-table-wrapper { display: none; }
        .client-cards { display: grid; grid-template-columns: 1fr; gap: 1rem; }
        .client-card-m { background: #fff; border-radius: 1rem; border: 1px solid rgba(0,0,0,0.05); padding: 1.25rem; transition: all 0.3s; }
        .client-card-m:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
    }
</style>

<div class="page-header">
    <div class="page-title"><i class="fas fa-user-friends"></i> {{ __('admin.clients') }}</div>
    <a href="{{ route('client.create', $salon) }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __('admin.add_client') }}
    </a>
</div>

@if (session('success'))
    <div class="toast-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if($clients->count())
{{-- Desktop Table --}}
<div class="client-table-wrapper">
    <table class="client-table">
        <thead>
            <tr>
                <th>{{ __('admin.client') }}</th>
                <th>{{ __('admin.client_code') }}</th>
                <th>{{ __('admin.phone') }}</th>
                <th>{{ __('admin.email') }}</th>
                <th>{{ __('admin.bookings') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td>
                    <div class="client-info">
                        <div class="client-avatar">
                            {{ mb_substr(app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar), 0, 1) }}
                        </div>
                        <div>
                            <div class="client-name">{{ app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar) }}</div>
                            @if(app()->getLocale() === 'ar' && $client->name_en)
                                <div class="client-name-sub">{{ $client->name_en }}</div>
                            @elseif(app()->getLocale() !== 'ar' && $client->name_ar)
                                <div class="client-name-sub">{{ $client->name_ar }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td><span class="client-code">{{ $client->client_code }}</span></td>
                <td class="client-contact" dir="ltr">{{ $client->phone }}</td>
                <td class="client-contact"><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></td>
                <td><span class="booking-count"><i class="fas fa-calendar-check"></i> {{ $client->bookings->count() }}</span></td>
                <td>
                    <div style="display: flex; gap: 0.35rem;">
                        <a href="{{ route('client.edit', [$salon, $client]) }}" class="action-btn action-edit" title="{{ __('admin.edit') }}">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="{{ route('client.show', [$salon, $client]) }}" class="action-btn action-view" title="{{ __('admin.view') }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('client.destroy', [$salon, $client]) }}" style="margin: 0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn action-delete" title="{{ __('admin.delete') }}" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mobile Cards --}}
<div class="client-cards">
    @foreach ($clients as $client)
    <div class="client-card-m">
        <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1rem;">
            <div class="client-avatar">
                {{ mb_substr(app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar), 0, 1) }}
            </div>
            <div style="flex: 1;">
                <div class="client-name">{{ app()->getLocale() === 'ar' ? $client->name_ar : ($client->name_en ?? $client->name_ar) }}</div>
                @if(app()->getLocale() === 'ar' && $client->name_en)
                    <div class="client-name-sub">{{ $client->name_en }}</div>
                @elseif(app()->getLocale() !== 'ar' && $client->name_ar)
                    <div class="client-name-sub">{{ $client->name_ar }}</div>
                @endif
            </div>
            <span class="booking-count"><i class="fas fa-calendar-check"></i> {{ $client->bookings->count() }}</span>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1rem;">
            <div style="background: #f8fafc; border-radius: 0.5rem; padding: 0.6rem;">
                <div style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase;">{{ __('admin.client_code') }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: #334155; font-family: monospace;">{{ $client->client_code }}</div>
            </div>
            <div style="background: #f8fafc; border-radius: 0.5rem; padding: 0.6rem;">
                <div style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase;">{{ __('admin.phone') }}</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: #334155;" dir="ltr">{{ $client->phone }}</div>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('client.edit', [$salon, $client]) }}" class="action-btn action-edit" style="flex: 1; justify-content: center; gap: 0.3rem;">
                <i class="fas fa-pen"></i> {{ __('admin.edit') }}
            </a>
            <a href="{{ route('client.show', [$salon, $client]) }}" class="action-btn action-view" style="flex: 1; justify-content: center; gap: 0.3rem;">
                <i class="fas fa-eye"></i> {{ __('admin.view') }}
            </a>
            <form method="POST" action="{{ route('client.destroy', [$salon, $client]) }}" style="flex: 1; margin: 0;">
                @csrf @method('DELETE')
                <button type="submit" class="action-btn action-delete" style="width: 100%; justify-content: center; gap: 0.3rem;" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                    <i class="fas fa-trash"></i> {{ __('admin.delete') }}
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
    <div class="empty-state">
        <i class="fas fa-user-friends"></i>
        <p>{{ __('admin.no_clients') }}</p>
        <a href="{{ route('client.create', $salon) }}" class="btn-add" style="margin-top: 1rem; display: inline-flex;">
            <i class="fas fa-plus"></i> {{ __('admin.add_client') }}
        </a>
    </div>
@endif
@endsection
