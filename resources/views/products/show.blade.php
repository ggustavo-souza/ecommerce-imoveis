@extends('layouts.app')

@section('content')
{{-- Adiciona um espaçamento vertical (padding) maior no container --}}
<div class="container py-5">
    <div class="row align-items-center">
        
        {{-- Coluna da Imagem --}}
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded shadow-sm mb-4 mb-md-0" 
                     alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Imagem" 
                     class="img-fluid rounded shadow-sm mb-4 mb-md-0" 
                     alt="Sem imagem">
            @endif
        </div>
        <div class="col-md-6">
            {{-- Título com mais destaque (font-weight bold) --}}
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            
            {{-- Descrição com a classe 'lead' para ficar um pouco maior e mais legível --}}
            <p class="lead text-muted mt-3">{{ $product->description }}</p>

            <h2 class="display-4 text-success my-4 fw-bold">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </h2>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf

                <button type="submit" class="btn bg-orange-500 text-white hover:bg-orange-600 btn-lg w-100 mb-3">
                    Adicionar ao Carrinho
                </button>
            </form>

            {{-- Ação Secundária: Voltar (com estilo mais sutil) --}}
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                Voltar ao Catálogo
            </a>
        </div>
    </div>
</div>
@endsection