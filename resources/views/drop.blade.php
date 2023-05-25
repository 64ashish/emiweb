<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="/public/css/style.css" rel="stylesheet">
</head>
<body>
<div class="flex items-center flex-col md:flex-row justify-center h-screen max-w-7xl m-auto px-5" x-data="effectCalculator()">
    <div class="w-full md:w-2/3">
        <!-- effect or behov -->
        <div class="flex gap-5 items-center">
            <div class="border-2 border-gray-900 text-gray-900 py-3 px-6 text-lg rounded-3xl text-center w-56
           hover:border-sky-600 hover:bg-sky-600 hover:text-white hover:underline">Effekt</div>
            <div class="border-2 border-gray-900 text-gray-900 py-3 px-6 text-lg rounded-3xl text-center w-56
           hover:border-sky-600 hover:bg-sky-600 hover:text-white hover:underline">Behov</div>
            <div>NOLLSTÄLL</div>
        </div>
        <!-- temperature -->
        <div class="my-3.5 flex gap-3  flex-wrap">
            <div class="w-1/4">
                <label class="text-xs mb-3.5 text-gray-600">FRAMLEDNING °C</label>
                <div class="py-3.5">
                    <!--              <a>+</a>-->
                    <input type="number" value="55" min="25" max-="90"
                           class="border border-gray-300 rounded-3xl text-center py-1 w-full">
                    <!--              <a>-</a>-->
                </div>
            </div>
            <div class="w-1/4">
                <label class="text-xs mb-3.5 text-gray-600">RETURLEDNING °C</label>
                <div class="py-3.5">
                    <!--              <a>+</a>-->
                    <input type="number" value="45" min="25" max-="90"
                           class="border border-gray-300 rounded-3xl text-center py-1 w-full">
                    <!--              <a>-</a>-->
                </div>
            </div>
            <div class="w-1/4">
                <label class="text-xs mb-3.5 text-gray-600">RUMSTEMPERATUR °C</label>
                <div class="py-3.5">
                    <!--              <a>+</a>-->
                    <input type="number" value="20" min="25" max-="90"
                           class="border border-gray-300 rounded-3xl text-center py-1 w-full">
                    <!--              <a>-</a>-->
                </div>
            </div>
        </div>
        <!--    display product options here -->
        <div class=" flex flex-col  md:flex-row md:flex-wrap gap-3">
            <div x-data="magicSelect()" x-modelable="selectedItem" x-model="product"
                 class="md:w-1/2 md:max-w-xs ">
                <div class="text-xs mb-3.5 text-gray-600">VÄLJ PRODUKT :</div>
                <div>

                    <div class="mt-5 " @click.away="showDropDown = false">
                        <div class="flex">
                            <input type="text" placeholder="select" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10
                            text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2
                            focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   x-model="search"
                                   @click="showDropDown = true" :value="selectedItem"
                            />
                            <span class="-ml-6 flex items-center pr-2 z-10">
                  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                  </svg>
              </span>
                        </div>
                        <div x-show="showDropDown"
                             class="absolute z-20 mt-1 max-h-60 w-full max-w-xs  overflow-auto rounded-md bg-white py-1 text-base shadow-lg
                                ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ul >
                                <template x-for="product in filteredItems(products)" :key="index">
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900
                                hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        x-text="product.name" @click="selectedItem = product.name; initProductOptions();showDropDown = false"
                                    >
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="magicSelect()" x-modelable="selectedItem" x-model="type"
                 class="md:w-1/2 md:max-w-xs ">
                <div class="text-xs mb-3.5 text-gray-600">VÄLJ EFFEKTGRUPP:</div>
                <div>

                    <div class="mt-5 " @click.away="showDropDown = false">
                        <div class="flex">
                            <input type="text" placeholder="select" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10
            text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2
            focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   x-model="search"
                                   @click="showDropDown = true" :value="selectedItem"
                            />
                            <span class="-ml-6 flex items-center pr-2 z-10">
                  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                  </svg>
              </span>
                        </div>
                        <div x-show="showDropDown"
                             class="absolute z-20 mt-1 max-h-60 w-full max-w-xs  overflow-auto rounded-md bg-white py-1 text-base shadow-lg
                ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ul >
                                <template x-for="type in filteredItems(types)" :key="index">
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900
                                hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        x-text="type" @click="selectedItem = type; filterAndFetchProductOption('type');showDropDown = false"
                                    >
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="magicSelect()" x-modelable="selectedItem" x-model="height"
                 class="md:w-1/2 md:max-w-xs ">
                <div class="text-xs mb-3.5 text-gray-600">VÄLJ HÖJD:</div>
                <div>
                    <div class="mt-5" @click.away="showDropDown = false">
                        <div class="flex">
                            <input type="text" placeholder="select" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10
            text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2
            focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   x-model="search"
                                   @click="showDropDown = true" :value="selectedItem"
                            />
                            <span class="-ml-6 flex items-center pr-2 z-10">
                  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                  </svg>
              </span>
                        </div>
                        <div x-show="showDropDown"
                             class="absolute z-20 mt-1 max-h-60 w-full max-w-xs  overflow-auto rounded-md bg-white py-1 text-base shadow-lg
                ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ul >
                                <template x-for="height in filteredItems(heights)" :key="index">
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900
                                hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        x-text="height" @click="selectedItem = height; filterAndFetchProductOption('height');showDropDown = false"
                                    >
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="magicSelect()" x-modelable="selectedItem" x-model="length"
                 class="md:w-1/2 md:max-w-xs ">
                <div class="text-xs mb-3.5 text-gray-600">VÄLJ LÄNGD:</div>

                <div>
                    <div class="mt-5 " @click.away="showDropDown = false">
                        <div class="flex">
                            <input type="text" placeholder="select" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10
            text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2
            focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   x-model="search"
                                   @click="showDropDown = true" :value="selectedItem"
                            />
                            <span class="-ml-6 flex items-center pr-2 z-10">
                  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                  </svg>
              </span>
                        </div>
                        <div x-show="showDropDown"
                             class="absolute z-20 mt-1 max-h-60 w-full max-w-xs  overflow-auto rounded-md bg-white py-1 text-base shadow-lg
                ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ul >
                                <template x-for="length in filteredItems(lengths)" :key="index">
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900
                                hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        x-text="length" @click="selectedItem = length; filterAndFetchProductOption('length');showDropDown = false"
                                    >
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="connectionPlacementOptions.length == 2"
                 x-data="magicSelect()"
                 x-modelable="selectedItem"
                 x-model="connectionPlacement"
                 class="md:w-1/2 md:max-w-xs ">
                <div class="text-xs mb-3.5 text-gray-600">Connection Placement:</div>

                <div>
                    <div class="mt-5 " @click.away="showDropDown = false">
                        <div class="flex">
                            <input type="text" placeholder="select" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10
            text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2
            focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   x-model="search"
                                   @click="showDropDown = true" :value="selectedItem"
                            />
                            <span class="-ml-6 flex items-center pr-2 z-10">
                  <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                  </svg>
              </span>
                        </div>
                        <div x-show="showDropDown"
                             class="absolute z-20 mt-1 max-h-60 w-full max-w-xs  overflow-auto rounded-md bg-white py-1 text-base shadow-lg
                ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ul >
                                <template x-for="connectionPlacement in filteredItems(connectionPlacementOptions)" :key="index">
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900
                                hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        x-text="connectionPlacement" @click="selectedItem = connectionPlacement; filterAndFetchProductOption('connectionPlacement');showDropDown = false"
                                    >
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>

        </div>
    </div>
    <div class="w-full md:w-1/3 ">

        <div >
            <div class="w-80 h-80 bg-teal-600 rounded-full flex justify-center items-center flex-col">
                <span x-show="effectCalculated" class="text-white">Total effect:</span>
                <spam x-text="effectCalculated" x-show="effectCalculated"
                      class="font-bold text-white text-lg"></spam>
            </div>
        </div>
    </div>
</div>
<script>
    function effectCalculator()
    {
        return{
            init() {
                fetch('https://watt.karabin.se/api/product-groups')
                    .then(response => response.json())
                    .then(result => this.products = result.data);
                // console.log(this.products)
            },
            products:[],
            types:[],
            heights:[],
            lengths:[],
            connectionPlacementOptions:[],
            product:null,
            type:null,
            height:null,
            length:null,
            connectionPlacement:null,
            productName:null,
            productSku:null,
            effectCalculated:null,

            // pull product options
            async initProductOptions()
            {
                this.effectCalculated = null
                this.productSku = null
                this.length = null
                this.type = null
                this.height = null
                this.connectionPlacement = null

                let fetchURL = "https://watt.karabin.se/api/product-search/"+this.product.name
                // console.log(this.product)
                let productInfo = await this.fetchProductInfo(fetchURL);
                // console.log(productInfo)
                this.types = productInfo.availableTypes
                this.heights = productInfo.availableHeights
                this.lengths = productInfo.availableLengths
                this.connectionPlacementOptions = productInfo.availableConnectionPlacements

            },

            //  run fetch
            async fetchProductInfo(fetchURL)
            {
                return await fetch(fetchURL)
                    .then(response => response.json())
            },


            async filterAndFetchProductOption(source)
            {
                console.log(this.type)
                if(source === "type")
                {
                    this.effectCalculated = null
                    this.productSku = null
                    this.length = null
                    // this.selectedType = null
                    this.height = null
                    this.connectionPlacement = null
                }

                if(source === "height")
                {
                    this.length = null
                    this.effectCalculated = null
                    this.productSku = null
                }

                if(source === "length")
                {

                }
                // prepare filter options
                let options = {
                    type:this.type,
                    height:this.height,
                    length:this.length,
                    connection_placement:this.connectionPlacement
                }
                //     generate query
                let query = Object.entries(options)
                    .filter(([_, value]) => value !== null)
                    .map(([key, value]) => `filter[${key}]=${encodeURIComponent(value)}`)
                    .join("&");
                // create url with query
                let fetchURL = "https://watt.karabin.se/api/product-search/"+this.product+'?'+query
                //     commence the fetch
                let productOptions =  await this.fetchProductInfo(fetchURL);

                // find a smarter way to do this later
                if(source === "height")
                {
                    this.lengths = productOptions.availableLengths
                }
                // fetch and plot the calculations, sku and product name
                if(productOptions.productCandidates.length == 1)
                {
                    this.productSku = productOptions.productCandidates[0]

                    await fetch('https://watt.karabin.se/api/calculate-effect/'+this.productSku)
                        .then(response => response.json())
                        .then(result => {
                            this.effectCalculated = Math.round(result.totalEffect*100)/100
                        })
                }

            }


        }
    }

    function magicSelect(initItems)
    {
        return {
            // initialise the product names
            search:'',
            showDropDown:false,
            selectedItem:null,
            filteredItems(items)
            {
                // return this.products
                return items.filter(
                    item => Object.hasOwn(item, 'name')?item.name.startsWith(this.search.toUpperCase()):item.startsWith(this.search.toUpperCase())
                )
            }
        }
    }

</script>
</body>
</html>