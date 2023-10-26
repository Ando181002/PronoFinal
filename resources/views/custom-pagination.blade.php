@if ($paginator->hasPages())
    <ul class="pagination justify-content-center">
        {{-- Afficher le bouton "Précédent" --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" style="color: rgb(252, 136, 4)">Précédent</a>
            </li>
        @endif

        {{-- Afficher le numéro de page --}}
        <li class="page-item active" aria-current="page" style="color: rgb(252, 136, 4)">
            <a class="page-link" href="#" style="background-color:rgb(252, 136, 4); border-color: rgb(252, 136, 4) ">{{ $paginator->currentPage() }}</a>
        </li>

        {{-- Afficher le bouton "Suivant" --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" style="color: rgb(252, 136, 4)">Suivant</a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Suivant</a>
            </li>
        @endif
    </ul>
@endif
