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

        /* ===== CONTAINER PRINCIPAL ===== */
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

        /* ===== FORMULAIRE ===== */
        .ga-form label {
            font-weight: 600;
            color: #334155;
        }

        .ga-form .form-control,
        .ga-form .form-select {
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            transition: all 0.2s ease-in-out;
            background: #fff;
        }

        .ga-form .form-control:focus,
        .ga-form .form-select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.2);
        }

        /* ===== PHOTO ACTUELLE ===== */
        .ga-photo {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
            margin-top: 10px;
        }

        /* ===== BOUTONS ===== */
        .ga-btn {
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            transition: all 0.2s ease;
            color: white;
        }

        .ga-btn.save {
            background: #22c55e;
        }

        .ga-btn.save:hover {
            background: #16a34a;
        }

        .ga-btn.cancel {
            background: #6366f1;
        }

        .ga-btn.cancel:hover {
            background: #4f46e5;
        }

        /* ===== ALERTES ===== */
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-radius: 12px;
            border: 1px solid #fecaca;
            padding: 1rem;
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
        <h1 class="ga-title">@lang('general.modifier_vol') #{{ $vol->id }}</h1>

        {{-- ===== Message d’erreur (si validation échoue) ===== --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===== Formulaire de modification ===== --}}
        <form class="ga-form" action="{{ route('vols.update', $vol->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Origine --}}
            <div class="mb-3">
                <label>@lang('general.origine')</label>
                <input type="text" name="origine" class="form-control" value="{{ $vol->origine }}" required>
            </div>

            {{-- Destination --}}
            <div class="mb-3">
                <label>@lang('general.destination')</label>
                <input type="text" name="destination" class="form-control" value="{{ $vol->destination }}" required>
            </div>

            {{-- Date de départ --}}
            <div class="mb-3">
                <label>@lang('general.date_depart')</label>
                <input type="date" name="date_depart" class="form-control"
                    value="{{ \Carbon\Carbon::parse($vol->date_depart)->format('Y-m-d') }}" required>
            </div>

            {{-- Date d’arrivée --}}
            <div class="mb-3">
                <label>@lang('general.date_arrivee')</label>
                <input type="date" name="date_arrive" class="form-control"
                    value="{{ \Carbon\Carbon::parse($vol->date_arrive)->format('Y-m-d') }}" required>
            </div>

            {{-- Prix --}}
            <div class="mb-3">
                <label>@lang('general.prix')</label>
                <input type="number" step="0.01" name="prix" class="form-control" value="{{ $vol->prix }}" required>
            </div>

            {{-- Avion associé --}}
            <div class="mb-3">
                <label>@lang('general.avion')</label>
                <select name="avion_id" class="form-select" required>
                    @foreach($avions as $avion)
                        <option value="{{ $avion->id }}" {{ $avion->id == $vol->avion_id ? 'selected' : '' }}>
                            {{ $avion->modele }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Photo actuelle --}}
            <div class="mb-3">
                <label class="d-block">@lang('general.photo_actuelle')</label>
                @if($vol->photo)
                    <img src="{{ asset('storage/images/upload/' . $vol->photo) }}" alt="@lang('general.photo_actuelle')"
                        class="ga-photo img-fluid" width="250">
                @else
                    <span class="text-muted">@lang('general.aucune_photo')</span>
                @endif
            </div>

            {{-- Changer la photo --}}
            <div class="mb-3">
                <label>@lang('general.changer_photo')</label>
                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif,.svg">
                <small class="text-muted">@lang('general.formats_autorises')</small>
            </div>

            {{-- Boutons de validation / annulation --}}
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="ga-btn save">@lang('general.enregistrer')</button>
                <a href="{{ route('vols.index') }}" class="ga-btn cancel">@lang('general.annuler')</a>
            </div>
        </form>
    </div>
@endsection