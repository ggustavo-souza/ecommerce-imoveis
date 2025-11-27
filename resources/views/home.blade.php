@extends('layouts.app')

@section('content')

<style>
    .card-img-top.fixed-img {
        height: 220px;
        object-fit: cover;
        width: 100%;
    }
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .text-truncate-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2; 
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 40px; 
    }
    .card-title-link {
        text-decoration: none;
        color: inherit;
    }
    .card-title-link:hover {
        color: var(--bs-primary);
    }
</style>

<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="https://stgecommerceprd.blob.core.windows.net/blob-ecom-img/assets/locacao_imoveis_0411d5d55c.jpg" 
                 class="d-block mx-lg-auto img-fluid rounded-3 shadow-lg" 
                 alt="Rack com roupas estilosas penduradas" 
                 width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-4">Sua nova vida começa aqui!</h1>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="btn bg-orange-500 text-white hover:bg-orange-600 btn-sm btn-lg px-4 me-md-2 fw-bold">
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container py-4" style="max-width: 1200px;">
        <h2 class="text-center fw-bold mb-4">Nossos Destaques</h2>
        
        @if(isset($products) && $products->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm card-hover">
                            
                            <a href="{{ route('products.show', $product->id) }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top fixed-img" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="card-img-top fixed-img" alt="Sem imagem">
                                @endif
                            </a>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product->id) }}" class="card-title-link">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                
                                <p class="card-text text-muted small text-truncate-lines">
                                    {{ $product->description }}
                                </p>
                                <div class="mt-auto">
                                    <span class="h5 mb-0 fw-bold text-success">
                                        R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-12">
                <p class="text-center text-muted">Nenhum produto em destaque no momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection