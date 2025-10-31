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
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08);
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
            text-align: center;
            font-weight: 800;
            color: #1e293b;
            font-size: clamp(28px, 3vw, 36px);
            margin-bottom: 2rem;
            text-shadow: 1px 1px 4px rgba(99, 102, 241, 0.15);
            position: relative;
        }

        .ga-title::after {
            content: "";
            display: block;
            width: 90px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* ====== TABLE ====== */
        .ga-table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .ga-table thead {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ga-table th,
        .ga-table td {
            padding: 14px 18px;
            text-align: center;
        }

        .ga-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .ga-table tbody tr:hover {
            background: #eef2ff;
            transition: background 0.2s ease-in-out;
        }

        .ga-table td {
            color: #334155;
            font-weight: 500;
        }

        /* ====== ALERTES ====== */
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            font-weight: 600;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .ga-container {
                padding: 1.5rem;
            }

            .ga-table th,
            .ga-table td {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>

    <div class="container ga-container">
        {{-- ===== Titre principal ===== --}}
        <h1 class="ga-title">Liste des avions</h1>

        {{-- ===== Message de succès (ex: avion ajouté/supprimé) ===== --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ===== Tableau des avions ===== --}}
        <table class="ga-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modèle</th>
                    <th>Capacité</th>
                </tr>
            </thead>

            <tbody>
                @foreach($avions as $avion)
                    <tr>
                        {{-- ID de l’avion --}}
                        <td>{{ $avion->id }}</td>

                        {{-- Modèle de l’avion --}}
                        <td>{{ $avion->modele }}</td>

                        {{-- Capacité de passagers --}}
                        <td>{{ $avion->capacite }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection