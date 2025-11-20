@extends('layouts.app')

@section('content')
    <style>
        body {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Nunito', sans-serif;
        }

        .ga-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08);
            animation: fadeIn 0.8s ease-in-out;
        }

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

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 10px;
            font-weight: 600;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .ga-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
        }

        .ga-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.4rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.25);
        }

        .ga-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(99, 102, 241, 0.35);
        }

        .ga-action-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .ga-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.45rem 0.9rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .ga-link-muted {
            background: #f1f5f9;
            color: #1e293b;
        }

        .ga-link-muted:hover {
            background: #e2e8f0;
        }

        .ga-link-primary {
            background: #6366f1;
            color: white;
        }

        .ga-link-primary:hover {
            background: #4f46e5;
        }

        .ga-link-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .ga-link-danger:hover {
            background: #fecaca;
        }

        .ga-inline-form {
            display: inline;
        }

        .ga-pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

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
        <h1 class="ga-title">Liste des avions</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('warning'))
            <div class="alert-warning">{{ session('warning') }}</div>
        @endif

        @auth
            @if(auth()->user()->role === 'admin')
                <div class="ga-actions">
                    <a href="{{ route('avions.create') }}" class="ga-btn">Ajouter un avion</a>
                </div>
            @endif
        @endauth

        <table class="ga-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Modele</th>
                <th>Capacite</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach($avions as $avion)
                <tr>
                    <td>{{ $avion->id }}</td>
                    <td>{{ $avion->modele }}</td>
                    <td>{{ $avion->capacite }}</td>
                    <td>
                        <div class="ga-action-list">
                            <a href="{{ route('avions.show', $avion) }}" class="ga-link ga-link-muted">Voir</a>
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('avions.edit', $avion) }}" class="ga-link ga-link-primary">Modifier</a>
                                    <form action="{{ route('avions.destroy', $avion) }}" method="POST" class="ga-inline-form" onsubmit="return confirm('{{ __('general.avion_delete_confirm') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ga-link ga-link-danger">Supprimer</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="ga-pagination">
            {{ $avions->links() }}
        </div>
    </div>
@endsection
