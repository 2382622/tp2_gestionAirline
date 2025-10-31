@extends('layouts.app')

@section('content')
    <style>
        /* ====== PAGE WRAPPER ====== */
        .page-wrap {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            border-radius: 18px;
            padding: 28px 24px 30px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
        }

        /* ====== TITLE ====== */
        .ga-title {
            font-weight: 800;
            letter-spacing: .3px;
            color: #0f172a;
            margin-bottom: 18px;
            text-align: center;
            font-size: clamp(26px, 3.4vw, 36px);
        }

        /* ====== SEARCH + CTA ====== */
        .topbar {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: center;
            margin-bottom: 16px;
        }

        .search-input {
            height: 46px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: #fff;
            padding: 10px 14px;
            outline: none;
            transition: box-shadow .15s ease, border-color .15s ease;
        }

        .search-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 .20rem rgba(99, 102, 241, .18);
        }

        .cta-create {
            background: #6366f1;
            color: #fff;
            padding: 10px 16px;
            border-radius: 12px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            gap: 8px;
            align-items: center;
            transition: transform .15s ease, background .15s ease;
            white-space: nowrap;
        }

        .cta-create:hover {
            background: #4f46e5;
            color: #fff;
            transform: translateY(-1px);
        }

        .cta-create:active {
            transform: translateY(0);
        }

        /* ====== TABLE ====== */
        .ga-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, .06);
        }

        .ga-table thead th {
            background: #eef2ff;
            color: #1f2937;
            font-weight: 700;
            padding: 12px 14px;
            border-bottom: 1px solid rgba(15, 23, 42, .08);
            white-space: nowrap;
        }

        .ga-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            vertical-align: middle;
        }

        .ga-table tbody tr:hover {
            background: #fafafa;
        }

        /* ====== BADGES / BUTTONS ====== */
        .badge-pill {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: .82rem;
            line-height: 1;
            border: 1px solid rgba(15, 23, 42, .08);
            background: #fff;
        }

        .badge-plane {
            background: #ecfeff;
            border-color: #06b6d4;
            color: #0e7490;
        }

        .badge-warn {
            background: #fff7ed;
            border-color: #fb923c;
            color: #c2410c;
        }

        .btn-chip {
            background: #22c55e;
            border: none;
            color: #fff;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .12s ease, background .12s ease;
        }

        .btn-chip:hover {
            background: #16a34a;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-chip:active {
            transform: translateY(0);
        }

        .btn-chip.warn {
            background: #f59e0b;
        }

        .btn-chip.warn:hover {
            background: #d97706;
        }

        .btn-chip.danger {
            background: #ef4444;
        }

        .btn-chip.danger:hover {
            background: #dc2626;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .topbar {
                grid-template-columns: 1fr;
            }

            .ga-table thead {
                display: none;
            }

            .ga-table,
            .ga-table tbody,
            .ga-table tr,
            .ga-table td {
                display: block;
                width: 100%;
            }

            .ga-table tbody tr {
                margin-bottom: 14px;
                border: 1px solid rgba(15, 23, 42, .06);
                border-radius: 12px;
                overflow: hidden;
            }

            .ga-table tbody td {
                border-bottom: 1px dashed rgba(15, 23, 42, .06);
            }

            .ga-table tbody td:last-child {
                border-bottom: 0;
            }

            .ga-table tbody td::before {
                content: attr(data-label);
                display: block;
                font-weight: 700;
                color: #334155;
                margin-bottom: 4px;
            }
        }
    </style>

    <div class="page-wrap container">
        <h1 class="ga-title">@lang('general.liste_vols')</h1>

        {{-- Barre de recherche + bouton créer --}}
        <div class="topbar">
            <input id="vol_search" type="text" class="search-input" placeholder="@lang('general.rechercher_vol')">
            @if(auth()->check() && optional(auth()->user())->role === 'admin')
                <a href="{{ route('vols.create') }}" class="cta-create">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="#fff" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    @lang('general.creer_vol')
                </a>
            @endif
        </div>

        {{-- Flash succès --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tableau --}}
        <div class="table-responsive">
            <table class="ga-table">
                <thead>
                    <tr>
                        <th>@lang('general.id')</th>
                        <th>@lang('general.date_depart')</th>
                        <th>@lang('general.date_arrivee')</th>
                        <th>@lang('general.origine')</th>
                        <th>@lang('general.destination')</th>
                        <th>@lang('general.prix')</th>
                        <th>@lang('general.avion')</th>
                        <th>@lang('general.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vols as $vol)
                        <tr>
                            <td data-label="@lang('general.id')">{{ $vol->id }}</td>
                            <td data-label="@lang('general.date_depart')">{{ $vol->date_depart }}</td>
                            <td data-label="@lang('general.date_arrivee')">{{ $vol->date_arrive }}</td>
                            <td data-label="@lang('general.origine')">{{ $vol->origine }}</td>
                            <td data-label="@lang('general.destination')">{{ $vol->destination }}</td>
                            <td data-label="@lang('general.prix')">{{ number_format((float) $vol->prix, 2) }} $</td>

                            {{-- ✅ Compatible PHP 7.x : optional() au lieu de ?-> --}}
                            <td data-label="@lang('general.avion')">
                                @if(optional($vol->avion)->modele)
                                    <span class="badge-pill badge-plane">{{ optional($vol->avion)->modele }}</span>
                                @else
                                    <span class="badge-pill badge-warn">@lang('general.non_assigne')</span>
                                @endif
                            </td>

                            <td data-label="@lang('general.actions')">
                                <a href="{{ route('vols.show', $vol->id) }}" class="btn-chip">@lang('general.voir')</a>

                                @if(auth()->check() && optional(auth()->user())->role === 'admin')
                                    <a href="{{ route('vols.edit', $vol->id) }}" class="btn-chip warn">@lang('general.modifier')</a>
                                    <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-chip danger"
                                            onclick="return confirm('@lang('general.confirmer_suppression')')">
                                            @lang('general.supprimer')
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">@lang('general.aucun_vol_trouve')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $vols->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /**
         * Autocomplétion jQuery UI pour rechercher un vol.
         * - Envoie { search, _token } vers la route vols.autocomplete (POST, JSON)
         * - Affiche jusqu'à 10 suggestions "ID — origine → destination"
         * - Sur sélection : redirection vers /vols/{id}
         */
        $(function () {
            var $search = $('#vol_search');
            if (!$search.length) return;

            $search.autocomplete({
                minLength: 2,
                delay: 200,
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('vols.autocomplete') }}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            search: request.term,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) { response(data); },
                        error: function () { response([]); }
                    });
                },
                select: function (event, ui) {
                    if (!ui.item || !ui.item.value) return false;
                    window.location.href = "{{ url('vols') }}/" + encodeURIComponent(ui.item.value);
                    return false;
                }
            })
                .autocomplete('instance')._renderItem = function (ul, item) {
                    return $('<li>').append('<div>' + item.label + '</div>').appendTo(ul);
                };
        });
    </script>
@endpush