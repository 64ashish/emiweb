<x-app-layout>
    <!-- Main 3 column grid -->
    {{--    @include('dashboard._breadcrumb')--}}

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    Northern Pacific Railway Company
                </p>
            </div>

            <div class="mt-6 p-6 bg-white  border-gray-300 shadow md:rounded-lg"  x-data="{ lightbox: false, imgModalSrc : '', imgModalAlt : '', imgModalDesc : '' }">
                {{--                    {{ $archive->NorthenPacificRailwayCompanyRecord->unique('index_letter') }}--}}
                {{--                    {{ __('Your search returned no results') }}--}}
                <ul class="">

                    @foreach($images as $image)
                        <li class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white cursor-pointer"
                            @click="$dispatch('lightbox',
                        {  imgModalSrc: '{{ \Illuminate\Support\Facades\Storage::disk('s3')->url('archives/25/images/'.trim($image->index_letter.'/'.$image->filename)) }}',
                        imgModalAlt: 'First Image', imgModalDesc: 'Random Image One Description' })">{{ $image->filename }}</li>
                        {{--                        src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url('archives/25/images/'.trim($image->index_letter.'/'.$image->filename)) }}">--}}
                    @endforeach

                    {{ $images->links() }}

                </ul>
                <div x-show="lightbox" @lightbox.window="lightbox = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;">
                    <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="fixed inset-0 z-50 flex items-center justify-center w-full p-2 overflow-hidden bg-black bg-opacity-75 h-100">
                        <div @click.away="lightbox = ''" class="w-5/6 h-full overflow-scroll	 ">
                            <img class="w-full" :src="imgModalSrc" :alt="imgModalAlt">
                        </div>
                    </div>
                </div>




            </div>
    </div>


    </section>

    </div>
</x-app-layout>
