@extends('layouts.app')

@section('content')
    <style>
        .ga-wrapper {
            max-width: 720px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        }

        .ga-title {
            font-size: clamp(28px, 3vw, 36px);
            text-align: center;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 2rem;
        }

        .ga-details {
            display: grid;
            gap: 1.25rem;
        }

        .ga-detail {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .ga-detail span {
            display: block;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 0.35rem;
            letter-spacing: 0.08em;
        }

        .ga-detail strong {
            font-size: 1.35rem;
            color: #111827;
        }

        .ga-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .ga-action-group {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .ga-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 1.5rem;
            border-radius: 9999px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .ga-btn-secondary {
            background: #e2e8f0;
            color: #1f2937;
        }

        .ga-btn-secondary:hover {
            background: #cbd5e1;
        }

        .ga-btn-primary {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.25);
        }

        .ga-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(99, 102, 241, 0.35);
        }

        .ga-btn-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .ga-btn-danger:hover {
            background: #fecaca;
        }

        .ga-inline-form {
            display: inline;
        }
    </style>

    <div class="ga-wrapper container">
        <h1 class="ga-title">Details de l'avion</h1>

        <div class="ga-details">
            <div class="ga-detail">
                <span>Identifiant</span>
                <strong>{{ $avion->id }}</strong>
            </div>

            <div class="ga-detail">
                <span>Modele</span>
                <strong>{{ $avion->modele }}</strong>
            </div>

            <div class="ga-detail">
                <span>Capacite</span>
                <strong>{{ $avion->capacite }}</strong>
            </div>
        </div>

        <div class="ga-actions">
            <a href="{{ route('avions.index') }}" class="ga-btn ga-btn-secondary">Retour</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="ga-action-group">
                        <a href="{{ route('avions.edit', $avion) }}" class="ga-btn ga-btn-primary">Modifier</a>
                        <form action="{{ route('avions.destroy', $avion) }}" method="POST" class="ga-inline-form" onsubmit="return confirm('Supprimer cet avion ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ga-btn ga-btn-danger">Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection
