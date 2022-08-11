
@switch($key)
    @case( $key == 'Den danska emigrantdatabasen')
    <a href="/danishemigration/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Svenskamerikanska kyrkoarkivet')
    <a href="/sacar/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_parish={{ $keywords['parish'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'New Yorks passagerarlistor')
    <a href="/nypr/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_year={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Passagerarlistor för svenska hamnar')
    <a href="/spplr/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Emigranter registrerade i svenska kyrkböcker')
    <a href="/scerc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_parish={{ $keywords['parish'] }}&dob={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Immigranter registrerade i svenska kyrkböcker')
    <a href="/sisrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_parish={{ $keywords['parish'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Svenskar över Kristiania')
    <a href="/sevkrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'SCB Immigranter')
    <a href="/sisrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'SCB Emigranter')
    <a href="/sesrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&from_parish={{ $keywords['parish'] }}&birth_year={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Bröderna Larssons arkiv (Index från Emigranten populär)')
    <a href="/leprc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&home_parish={{ $keywords['parish'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Bröderna Larssons arkiv')
    <a href="/blarc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&home_parish={{ $keywords['parish'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'John Ericssons samling')
    <a href="/jear/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Immigranter i norska kyrkböcker')
    <a href="/ncirc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Mormonska passagerarlistor')
    <a href="/msprc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Svenskamerikanska föreningsmedlemmar')
    <a href="/samrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_parish={{ $keywords['parish'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Svenskar i Alaska')
    <a href="/siarc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Tidningsnotiser från Värmländska tidningar')
    <a href="/vnnrc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_year={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Dalslänningar födda i Amerika')
    <a href="/dbir/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Emigranter i norska kyrkböcker')
    <a href="/nerc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&birth_date={{ $keywords['year'] }}&action=search">
    {{ $value }}
    </a>
    @break

    @case( $key == 'Den åländska emigrantdatabasen')
    <a href="/ierc/search?first_name={{$keywords['first_name']}}&last_name={{ $keywords['last_name'] }}&date_of_birth={{ $keywords['year'] }}&action=search">
    {{ $value }}
            </a>
    @break

    @default
    {{ $value }}
@endswitch
