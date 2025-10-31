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
            margin-bottom: 1.5rem;
        }

        .ga-form-group {
            margin-bottom: 1.25rem;
        }

        .ga-form-group label {
            display: block;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .ga-form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid #cbd5f5;
            background: #f8fafc;
            font-size: 1rem;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        .ga-form-group input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .ga-error {
            margin-top: 0.5rem;
            color: #b91c1c;
            font-size: 0.875rem;
        }

        .ga-alert-warning {
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
            gap: 0.75rem;
            margin-top: 1.5rem;
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
    </style>

    <div class="ga-wrapper container">
        <h1 class="ga-title">Ajouter un avion</h1>

        @if(session('warning'))
            <div class="ga-alert-warning">{{ session('warning') }}</div>
        @endif

        @if($errors->any())
            <div class="ga-alert-warning">
                Merci de corriger les champs en erreur.
            </div>
        @endif

        <form action="{{ route('avions.store') }}" method="POST">
            @csrf

            <div class="ga-form-group">
                <label for="modele">Modele</label>
                <input id="modele" type="text" name="modele" value="{{ old('modele') }}" required>
                @error('modele')
                    <p class="ga-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ga-form-group">
                <label for="capacite">Capacite</label>
                <input id="capacite" type="number" name="capacite" value="{{ old('capacite') }}" min="1" required>
                @error('capacite')
                    <p class="ga-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="ga-actions">
                <a href="{{ route('avions.index') }}" class="ga-btn ga-btn-secondary">Annuler</a>
                <button type="submit" class="ga-btn ga-btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
