@extends('layouts.app')

@section('content')
    <style>
        /* ===== PAGE BACKGROUND ===== */
        body {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* ===== CONTAINER CARD ===== */
        .ga-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            box-shadow: 0 12px 36px rgba(15, 23, 42, 0.08);
            padding: 2rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            margin-top: 20px;
        }

        /* ===== TITRE ===== */
        .ga-title {
            font-weight: 800;
            color: #1e293b;
            font-size: clamp(26px, 3vw, 34px);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* ===== IMAGE ===== */
        .ga-photo {
            width: 100%;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        /* ===== SECTION INFO ===== */
        .ga-info {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
            padding: 1.5rem;
        }

        .ga-info p {
            margin-bottom: .6rem;
            font-size: 1rem;
        }

        .ga-info strong {
            color: #334155;
        }

        /* ===== BUTTONS ===== */
        .ga-btn {
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            transition: all 0.2s ease;
            color: white;
        }

        .ga-btn.edit {
            background: #f59e0b;
        }

        .ga-btn.edit:hover {
            background: #d97706;
        }

        .ga-btn.delete {
            background: #ef4444;
        }

        .ga-btn.delete:hover {
            background: #dc2626;
        }

        .ga-btn.back {
            background: #6366f1;
            color: white;
        }

        .ga-btn.back:hover {
            background: #4f46e5;
        }

        /* ===== EMPTY PHOTO ===== */
        .ga-empty-photo {
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            border: 1px dashed #94a3b8;
            border-radius: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .ga-card {
                padding: 1.2rem;
            }
        }
    </style>

    <div class="container ga-card">
        {{-- ===== Titre principal ===== --}}
        <h1 class="ga-title">@lang('general.details_vol') #{{ $vol->id }}</h1>

        <div class="row g-4">
            {{-- ===== Colonne gauche : Photo ===== --}}
            <div class="col-md-5">
                @if($vol->photo)
                    {{-- Si une photo est enregistrée, on l’affiche --}}
                    <img src="{{ asset('storage/images/upload/' . $vol->photo) }}" alt="Photo du vol {{ $vol->id }}"
                        class="ga-photo">
                @else
                    {{-- Sinon, on affiche un cadre vide avec un message --}}
                    <div class="ga-empty-photo">
                        <span>@lang('general.aucune_photo')</span>
                    </div>
                @endif
            </div>

            {{-- ===== Colonne droite : Infos du vol ===== --}}
            <div class="col-md-7">
                <div class="ga-info">
                    <p><strong>@lang('general.origine') :</strong> {{ $vol->origine }}</p>
                    <p><strong>@lang('general.destination') :</strong> {{ $vol->destination }}</p>
                    <p><strong>@lang('general.date_depart') :</strong> {{ $vol->date_depart }}</p>
                    <p><strong>@lang('general.date_arrivee') :</strong> {{ $vol->date_arrive }}</p>
                    <p><strong>@lang('general.prix') :</strong> {{ number_format((float) $vol->prix, 2) }} $</p>
                    <p><strong>@lang('general.avion') :</strong>
                        {{ optional($vol->avion)->modele ?? __('general.non_assigne') }}
                    </p>
                </div>

                {{-- ===== Boutons d’action ===== --}}
                <div class="mt-4 d-flex flex-wrap gap-2">
                    {{-- Si l’utilisateur est connecté et admin : boutons Modifier + Supprimer --}}
                    @auth
                        @if(optional(auth()->user())->role === 'admin')
                            <a href="{{ route('vols.edit', $vol->id) }}" class="ga-btn edit">
                                @lang('general.modifier')
                            </a>

                            <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ga-btn delete"
                                    onclick="return confirm('@lang('general.confirmer_suppression')')">
                                    @lang('general.supprimer')
                                </button>
                            </form>
                        @endif
                    @endauth

                    {{-- Bouton retour vers la liste --}}
                    <a href="{{ route('vols.index') }}" class="ga-btn back">
                        @lang('general.retour_liste')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection