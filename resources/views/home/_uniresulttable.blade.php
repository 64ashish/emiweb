
@switch($key)

    @case( $key == 'Emigranter registrerade i svenska kyrkböcker')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/scerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_dob%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/scerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_dob%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Immigranter registrerade i svenska kyrkböcker')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/scirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/scirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'SCB Immigranter')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sisrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sisrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'SCB Emigranter')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sesrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&from_parish={{ $keywords['parish'] }}&birth_year={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sesrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&from_parish={{ $keywords['parish'] }}&birth_year={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Emigranter i norska kyrkböcker')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/nerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/nerc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break



    @case( $key == 'Den åländska emigrantdatabasen')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/ierc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_date_of_birth%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/ierc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_date_of_birth%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Immigranter i norska kyrkböcker')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/ncirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/ncirc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break
        @case( $key == 'Den danska emigrantdatabasen')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/danishemigration/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/danishemigration/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
        </td>
    @break

    @case( $key == 'New Yorks passagerarlistor')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/nypr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/nypr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Passagerarlistor för svenska hamnar')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/spplr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/spplr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Svenskar över Kristiania')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sevkrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sevkrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Bröderna Larssons arkiv')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/blarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/blarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Mormonska passagerarlistor')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/msprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/msprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Svenskamerikanska kyrkoarkivet')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/sacar/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/sacar/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Svenskamerikanska föreningsmedlemmar')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/samrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/samrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&birth_parish={{ $keywords['parish'] }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Svenskar i Alaska')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/siarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/siarc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Dalslänningar födda i Amerika')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/dbir/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/dbir/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break


    @case( $key == 'Bröderna Larssons arkiv (Index från Emigranten populär)')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/leprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/leprc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&home_parish={{ $keywords['parish'] }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break



    @case( $key == 'Tidningsnotiser från Värmländska tidningar')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/vnnrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $key }}
        </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/vnnrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_year%5Byear%5D={{ $keywords['year'] }}&action=search">
            {{ $value }}
        </a>
        </td>
    @break


    @case( $key == 'John Ericssons samling')
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
        <a class="block" href="/jear/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $key }}
        </a>
    </td>
    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
        <a class="block" href="/jear/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&action=search">
            {{ $value }}
        </a>
    </td>
    @break

    @case( $key == 'Beväringens Levnadsbeskrivningar')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
            <a class="block" href="/blbrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&date_of_birth={{ $keywords['parish'] }}&action=search">
                {{ $key }}
            </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
            <a class="block" href="/blbrc/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&from_parish={{ $keywords['parish'] }}&action=search">
                {{ $value }}
            </a>
        </td>
        @break

    @case( $key == 'Dödsnotiser från Svenskamerikanska tidningar')
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm

                                                                                font-medium  sm:pl-6 lg:pl-8">
            <a class="block" href="/osanr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&from_parish={{ $keywords['parish'] }}&action=search">
                {{ $key }}
            </a>
        </td>
        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                                font-medium sm:pl-6 lg:pl-8">
            <a class="block" href="/osanr/search?qry_first_name[value]={{$keywords['qry_first_name']}}&qry_first_name[method]={{ null }}&qry_last_name[value]={{ $keywords['qry_last_name'] }}&qry_last_name[method]={{ null }}&array_birth_date%5Byear%5D={{ $keywords['year'] }}&date_of_birth={{ $keywords['parish'] }}&action=search">
                {{ $value }}
            </a>
        </td>
        @break


    @default

@endswitch


