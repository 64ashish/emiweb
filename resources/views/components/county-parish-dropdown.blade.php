<div class="col-span-2">
    <div x-data="loadCounties"
         x-init="county:{{ $keywords[$filterAttribute[0]] }}" x-cloak class="sm:grid sm:grid-cols-2 sm:items-start  gap-x-6">
        <label for="{{ $filterAttribute[0] }}"
               class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">
            {{ __(ucfirst(str_replace('_', ' ', $filterAttribute[0]))) }}:
            <select x-model="county" name="{{ $filterAttribute[0] }}" class=" block w-full rounded-md border-gray-300
                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                          focus:ring-indigo-500 sm:text-sm col-span-2">
                <option value="">-- {{ __('Select a province') }} --</option>
                <template x-for="province in counties">
                    <option x-bind:value="province.county"
                            x-bind:selected="province.county == '{{ $keywords[$filterAttribute[0]]??false }}'">
                        <span x-text="province.county"></span>
                    </option>
                </template>
            </select>
        </label>

        <label x-bind:disabled="!county"  for="{{ $filterAttribute[1] }}"
               class=" text-sm font-medium text-gray-700 sm:mt-px sm:grid sm:grid-cols-3  sm:pt-2 gap-x-2 items-center">{{ __(ucfirst(str_replace('_', ' ', $filterAttribute[1]))) }}:
            <select x-model="parish" x-bind:disabled="!county" name="{{ $filterAttribute[1] }}" class="block w-full rounded-md border-gray-300
                                         py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none
                                          focus:ring-indigo-500 sm:text-sm col-span-2" >
                <option value="">-- {{ __('Select a parish') }} --</option>
                <template x-for="parishData in parishes">
                    <option :value="parishData"
                            x-bind:selected="parishData == '{{ $keywords[$filterAttribute[1]]??false }}'"><span x-text="parishData"></span></option>
                </template>
            </select>
        </label>
    </div>

</div>



@if(isset($ProvincesParishes))
    <script>

        document.addEventListener('alpine:init', () => {
            Alpine.data('loadCounties', () => ({
                counties:getCounties(),
                county:{!! $keywords[$filterAttribute[0]] !!},
                parish:null,

                parishes() {

                    return getParishes(this.county)
                },


            }))
        });

        const getCounties = () => {
            return {!! $ProvincesParishes !!}
        }

        /*
        generates fake cities, later states have more values
        */
        const getParishes = (county) => {
            if(!county) return [];
            return getCounties().find(i => i.county === county).parish

        }
    </script>

@endif
