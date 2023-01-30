<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-lg mt-4 font-bold text-gray-900   pb-4">
                    {{ __('Search in') }}  {{ __($archive_name->name) }}
                </p>
            </div>

                <div class="mt-6 p-6 bg-white  border-gray-300 shadow md:rounded-lg">

                    <div class="grid grid-cols-2 md:grid-cols-6 gap-2">
                        @foreach( $archive->NorthenPacificRailwayCompanyRecord->unique('index_letter') as $alphabet)
                        <a  href="{{ route('npr.browse',[$alphabet->index_letter]) }}" class=" border-b bg-emerald-600 p-5 flex justify-center text-white font-bold">{{ $alphabet->index_letter }}</a>
                        @endforeach

                    </div>
                </div>


        </section>

    </div>
</x-app-layout>
