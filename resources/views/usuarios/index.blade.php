@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                        <i class="bi bi-people-fill text-indigo-600 me-2"></i>Gerenciar Usuários
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Visualizando {{ $users->count() }} de {{ $users->total() }} usuários cadastrados.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="uppercase tracking-wider border-b border-gray-200 bg-gray-50 text-gray-500">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Usuário</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status / Função</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Data Cadastro</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0 border border-indigo-200">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800 text-base">{{ $user->name }}</span>
                                                <span class="text-gray-500 text-xs">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($user->is_admin)
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700 ring-1 ring-inset ring-purple-700/10">
                                                <i class="bi bi-shield-lock-fill"></i> Administrador
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700 ring-1 ring-inset ring-purple-700/10">
                                                <i class="bi bi-person-check-fill"></i> Cliente
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                                            <span class="text-xs text-gray-400">às {{ $user->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-end">
                                        <div class="flex justify-end gap-3 items-center">
                                            {{-- Botão Editar --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="text-gray-400 hover:text-indigo-600 transition-colors" title="Editar">
                                                <i class="bi bi-pencil-square text-lg"></i>
                                            </a>

@if(Auth::id() !== $user->id)
    {{-- Alpine.js Data Scope para o Modal --}}
    <div x-data="{ open: false, userName: '{{ $user->name }}' }">
        
        {{-- Botão para Abrir o Modal --}}
        <button type="button"
            @click="open = true"
            class="text-gray-400 hover:text-red-600 transition-colors pt-1"
            title="Excluir">
            <i class="bi bi-trash text-lg"></i> {{-- Ícone de lixeira (substitua se usar outro) --}}
        </button>

        {{-- O Modal em si --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-0"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true"
             style="display: none;"> {{-- Esconde por padrão para evitar FOUC --}}

            {{-- Overlay de Fundo (Backdrop) --}}
            <div @click="open = false"
                 class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity"
                 aria-hidden="true">
            </div>

            {{-- Painel do Conteúdo do Modal --}}
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full w-full mx-auto">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        {{-- Ícone de Alerta --}}
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i> {{-- Ícone de alerta (substitua se usar outro) --}}
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Confirmar Exclusão
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Você tem certeza que deseja excluir o usuário <strong x-text="userName"></strong>? Esta ação é **irreversível** e todos os dados associados serão perdidos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Rodapé e Botões de Ação --}}
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    {{-- Formulário de Exclusão --}}
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block sm:ml-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                            Sim, Excluir
                        </button>
                    </form>
                    
                    {{-- Botão de Cancelar --}}
                    <button type="button"
                        @click="open = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection