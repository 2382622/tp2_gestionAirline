@extends('layouts.app')

@section('content')
    <style>
        /* ====== FOND GÉNÉRAL ====== */
        body {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Nunito', sans-serif;
        }

        /* ====== CONTAINER PRINCIPAL ====== */
        .ga-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 22px;
            padding: 2.5rem;
            margin-top: 2rem;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Animation d’apparition douce */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ====== TITRE ====== */
        .ga-title {
            font-weight: 800;
            text-align: center;
            color: #1e293b;
            font-size: clamp(28px, 3vw, 38px);
            margin-bottom: 2rem;
            text-shadow: 1px 2px 5px rgba(99, 102, 241, 0.15);
            position: relative;
        }

        .ga-title::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* ====== CARTES DE VOLS ====== */
        .ga-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
            transition: all 0.3s ease-in-out;
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .ga-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }

        /* Bande colorée en haut de la carte */
        .ga-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            opacity: 0.8;
        }

        /* Contenu de la carte */
        .ga-card .card-body {
            padding: 1.5rem;
        }

        .ga-card .card-title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ga-card p {
            margin-bottom: .6rem;
            color: #475569;
            font-size: 0.95rem;
        }

        .ga-card strong {
            color: #1e293b;
        }

        /* ====== PRIX ====== */
        .ga-card p:last-child {
            font-weight: 700;
            color: #16a34a;
            font-size: 1.05rem;
        }

        /* ====== MESSAGE D’ABSENCE ====== */
        .ga-empty {
            text-align: center;
            color: #64748b;
            font-weight: 500;
            margin-top: 2rem;
            font-size: 1.1rem;
        }

        /* ====== ANIMATION AU SURVOL ====== */
        .ga-card:hover .card-title {
            color: #4f46e5;
            transition: color 0.2s ease;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .ga-container {
                padding: 1.5rem;
            }

            .ga-card {
                margin-bottom: 1rem;
            }

            .ga-card .card-body {
                padding: 1rem;
            }
        }
    </style>

    <div class="container ga-container py-4">
        {{-- ===== Titre principal ===== --}}
        <h2 class="ga-title">@lang('general.titre_accueil')</h2>

        {{-- ===== Liste des vols ===== --}}
        <div class="row">
            @forelse ($vols as $vol)
                {{-- Une carte par vol --}}
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="ga-card h-100">
                        <div class="card-body">
                            {{-- Origine → Destination --}}
                            <h5 class="card-title">
                                {{ $vol->origine }} → {{ $vol->destination }}
                            </h5>

                            {{-- Date de départ --}}
                            <p>
                                <strong>@lang('general.date_depart') :</strong>
                                {{ $vol->date_depart }}
                            </p>

                            {{-- Date d’arrivée --}}
                            <p>
                                <strong>@lang('general.date_arrivee') :</strong>
                                {{ $vol->date_arrive }}
                            </p>

                            {{-- Prix du vol --}}
                            <p>
                                <strong>@lang('general.prix') :</strong>
                                {{ number_format((float) $vol->prix, 2) }} $
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Si aucun vol n’est disponible --}}
                <p class="ga-empty">@lang('general.aucun_vol')</p>
            @endforelse
        </div>
    </div>
@endsection