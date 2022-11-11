<x-app-layout>
    <!-- Main 3 column grid -->


    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-4 pl-4 pr-3  border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 ">
                    {{ __('Browse in') }} Bröderna Larssons arkiv
                </p>
            </div>

            <div class="mt-6 p-6 bg-white  border-gray-300 shadow md:rounded-lg">

                <div class="grid grid-cols-2 md:grid-cols-6 gap-2">
                    @foreach( $years as $year)
                        <a  href="{{ route('blarc.documents',[$year->year]) }}" class=" border-b bg-emerald-600 p-5 flex justify-center text-white font-bold">{{ $year->year }}</a>
                    @endforeach

                </div>
            </div>


        </section>

    </div>
</x-app-layout>
