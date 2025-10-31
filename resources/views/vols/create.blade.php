@extends('layouts.app')

@section('content')
    <style>
        /* ===== FOND GLOBAL (scroll autorisé) ===== */
        /* On enlève overflow:hidden et on ne force pas la hauteur fixe */
        body {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* ===== CONTENEUR DE PAGE =====
         On ne force plus 100vh ; on laisse la page grandir et on garde un minimum agréable.
         On aligne en haut et on met du padding pour respirer. */
        .ga-bg {
            min-height: calc(100vh - 120px);
            /* laisse de la place pour le header + footer */
            display: flex;
            align-items: flex-start;
            /* en haut, pas centré verticalement */
            justify-content: center;
            padding: 32px 0 48px;
        }

        /* ===== CARTE ===== */
        .ga-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
            padding: 2rem;
        }

        .ga-form-control {
            border-radius: .75rem;
        }

        .ga-form-control:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .25) !important;
        }

        .ga-btn-primary {
            background: #6366f1;
            border: none;
            border-radius: .75rem;
            transition: .2s;
        }

        .ga-btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .ga-btn-secondary {
            background: #94a3b8;
            border: none;
            border-radius: .75rem;
        }

        .ga-btn-secondary:hover {
            background: #64748b;
            transform: translateY(-1px);
        }

        .ga-title {
            font-weight: 700;
            color: #1e293b;
        }

        .ga-muted {
            color: #64748b;
        }
    </style>

    <div class="ga-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-9 col-md-8 col-lg-6">
                    <div class="ga-card">
                        <h1 class="h3 text-center ga-title mb-4">@lang('general.creer_vol')</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('vols.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="id" class="form-label">@lang('general.id_vol')</label>
                                <input type="text" class="form-control ga-form-control" id="id" name="id" required>
                            </div>

                            <div class="mb-3">
                                <label for="origine" class="form-label">@lang('general.origine')</label>
                                <input type="text" class="form-control ga-form-control" id="origine" name="origine"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="destination" class="form-label">@lang('general.destination')</label>
                                <input type="text" class="form-control ga-form-control" id="destination" name="destination"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="date_depart" class="form-label">@lang('general.date_depart')</label>
                                <input type="date" class="form-control ga-form-control" id="date_depart" name="date_depart"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="date_arrive" class="form-label">@lang('general.date_arrivee')</label>
                                <input type="date" class="form-control ga-form-control" id="date_arrive" name="date_arrive"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="prix" class="form-label">@lang('general.prix')</label>
                                <input type="number" step="0.01" class="form-control ga-form-control" id="prix" name="prix"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="avion_id" class="form-label">@lang('general.avion')</label>
                                <select name="avion_id" id="avion_id" class="form-select ga-form-control" required>
                                    <option value="">@lang('general.choisir_avion')</option>
                                    @foreach($avions as $avion)
                                        <option value="{{ $avion->id }}">{{ $avion->modele }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">@lang('general.photo_vol')</label>
                                <input type="file" name="photo" class="form-control ga-form-control"
                                    accept=".jpg,.jpeg,.png,.gif,.svg" required>
                                <small class="ga-muted">@lang('general.formats_autorises')</small>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn ga-btn-primary text-white px-4">
                                    @lang('general.enregistrer')
                                </button>
                                <a href="{{ route('vols.index') }}" class="btn ga-btn-secondary text-white px-4">
                                    @lang('general.annuler')
                                </a>
                            </div>
                        </form>

                        <div class="text-center ga-muted small mt-4">
                            © {{ date('Y') }} — Gestion Airline
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection