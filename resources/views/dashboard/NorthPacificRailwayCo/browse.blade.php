<x-app-layout>
    <!-- Main 3 column grid -->
{{--    @include('dashboard._breadcrumb')--}}

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-4 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-lg mt-4 font-bold text-gray-900   pb-4">
                    {{ __('Search in') }}  {{ __($archive_name) }}
                </p>

            </div>

            <div class="mt-6 p-6 bg-white  border-gray-300 shadow md:rounded-lg"
                 x-data=data()>
                <div class="grid grid-cols-1 lg:grid-cols-6 lg:gap-8">
                    @foreach($images as $image)

{{--                        {{ \Illuminate\Support\Facades\Storage::disk('s3')->temporaryUrl('archives/25/images/'.$image->filename, now()->addMinutes(10)) }}--}}
                        <div @click="openImageViewer =! openImageViewer, openImage('{{ \Illuminate\Support\Facades\Storage::disk('s3')->temporaryUrl('archives/25/images/'.$image->index_letter."/".$image->filename, now()->addMinutes(60)) }}')"
                             class="flex flex-col items-center shadow-lg rounded-lg hover:shadow-2xl p-5 hover:transition-all">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-14">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="text-sm text-center">
                                {{ $image->filename }}<br>
                            </div>

                        </div>
                    @endforeach


                </div>


                <div  x-show="openImageViewer"  x-transition:enter="ease-out duration-300"
                      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      x-transition:leave="transition ease-in duration-75"
                      x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                      class="fixed inset-0 z-20 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog"
                      aria-modal="true" style="display:none">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"
                         aria-hidden="true"></div>

                    <div x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 opacity-100 scale-100"
                         class="mx-auto max-w-4xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                        <div>
                            <div  @click.away="openImageViewer = false">
                                <div class="h-[70vh] overflow-scroll">
                                    <img :src="imageUrl" class="w-full">

                                </div>
                            </div>
                        </div>


                    </div>


                </div>

                <div class="pt-5">
                    {{ $images->links() }}
                </div>



            </div>


        </section>

    </div>

    <script>
{{--     imagebaseUrl:@json(\Illuminate\Support\Facades\Storage::disk('s3')->url('archives/25/images/'))+@json($image->index_letter."/"),    --}}
        function data(){
            return {
                openImageViewer:false,
                imagebaseUrl:@json(\Illuminate\Support\Facades\Storage::disk('s3')->url('archives/25/images/'))+@json($image->index_letter."/"),
                imageUrl:'',
                openImage(file_name){
                    this.imageUrl = file_name;
                }
            }
        }
    </script>
</x-app-layout>
