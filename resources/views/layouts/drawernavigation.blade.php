{{-- Start 画面上部のナビゲーション --}}
<div class="flex justify-between  w-full fixed top-0 z-50 bg-gray-100  dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    {{-- スマホ用drawerサイドメニュー表示ボタン --}}
    <div class="flex">
        <div class="flex items-center">
            <button  class="inline-flex items-center  p-2 rounded-sm ml-[1px] text-gray-900 dark:text-gray-500 hover:text-gray-500  dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out" type="button" data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation" data-drawer-trigger="hover">
                <div class="flex items-center mx-1 mt-1 ">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 128 130" class="h-full w-6 fill-current text-gray-950 dark:fill-white">
                    <path d="M115.415,62.89c-0.058-2.641-0.327-5.254-0.783-7.83l6.194-1.231l-0.219-1.088c-0.671-3.368-1.646-6.634-2.883-9.794  l5.835-2.416l-0.426-1.025c-3.233-7.797-7.902-14.782-13.879-20.759l-0.784-0.784l-8.899,8.896c-1.905-1.826-3.942-3.484-6.09-4.985  l3.506-5.245l-0.922-0.616c-2.852-1.908-5.85-3.53-8.962-4.89l2.415-5.831l-1.024-0.425C80.711,1.637,72.471,0,64,0h-1.109v12.584  c-2.641,0.057-5.254,0.326-7.831,0.782l-1.231-6.19L52.74,7.392c-3.369,0.672-6.635,1.646-9.793,2.884L40.53,4.439l-1.024,0.426  c-7.803,3.235-14.787,7.905-20.761,13.881l-0.784,0.784l8.897,8.896c-1.827,1.906-3.484,3.944-4.986,6.09l-5.246-3.504l-0.616,0.921  c-1.907,2.852-3.529,5.85-4.887,8.962L5.289,38.48l-0.426,1.024C1.637,47.29,0,55.53,0,63.999v1.109l12.584-0.001  c0.059,2.641,0.326,5.254,0.783,7.832l-6.193,1.231l0.219,1.089c0.672,3.367,1.645,6.633,2.883,9.791l-5.836,2.418l0.424,1.025  c3.238,7.803,7.908,14.787,13.882,20.76l0.784,0.783l8.898-8.898c1.906,1.828,3.943,3.484,6.09,4.986l-3.507,5.248l0.922,0.615  c2.853,1.908,5.85,3.529,8.962,4.889l-2.415,5.832l1.024,0.424C47.291,126.361,55.531,128,64,128h1.109v-12.587  c2.641-0.058,5.254-0.326,7.83-0.781l1.232,6.192l1.088-0.217c3.367-0.672,6.634-1.646,9.792-2.883l2.417,5.835l1.025-0.426  c7.801-3.235,14.785-7.905,20.761-13.88l0.784-0.785l-8.897-8.898c1.827-1.906,3.484-3.942,4.986-6.088l5.246,3.504l0.616-0.921  c1.907-2.853,3.528-5.851,4.887-8.962l5.833,2.416l0.424-1.025c3.229-7.789,4.866-16.03,4.866-24.495V62.89H115.415z   M118.205,52.088l-4.007,0.796c-0.565-2.555-1.317-5.071-2.276-7.533l3.755-1.556C116.728,46.48,117.58,49.245,118.205,52.088z   M106.905,62.891h-4.081c-0.053-1.795-0.223-3.59-0.526-5.378l3.99-0.794C106.64,58.751,106.851,60.811,106.905,62.891z   M118.198,75.912c-0.624,2.846-1.473,5.609-2.521,8.292l-5.795-2.4l-0.424,1.024c-1.102,2.657-2.428,5.181-3.948,7.574l-3.385-2.262  c1.374-2.172,2.574-4.461,3.571-6.869l0.424-1.025l-11.634-4.818c1.242-3.312,1.93-6.773,2.048-10.318h4.067  c-0.061,2.02-0.279,4.034-0.677,6.037l-0.217,1.088L118.198,75.912z M99.704,55.767l0.217,1.087  c0.398,2.006,0.618,4.021,0.681,6.037h-6.267V64c0,4.012-0.775,7.918-2.305,11.61l-0.425,1.024l11.604,4.808  c-0.846,1.903-1.827,3.725-2.925,5.468l-5.217-3.484l-0.615,0.922c-1.135,1.7-2.404,3.28-3.786,4.75l-4.433-4.432l-0.785,0.784  c-2.83,2.832-6.141,5.046-9.841,6.58l-1.024,0.425l4.81,11.603c-1.943,0.747-3.926,1.341-5.937,1.796l-1.223-6.15l-1.089,0.217  c-1.985,0.396-4.01,0.613-6.038,0.676l0.002-6.26H64c-4.014,0-7.92-0.775-11.61-2.306l-1.025-0.425l-4.808,11.604  c-1.902-0.846-3.725-1.828-5.467-2.926l3.483-5.215l-0.921-0.616c-1.701-1.136-3.281-2.405-4.752-3.786l4.432-4.432l-0.784-0.784  c-2.833-2.835-5.047-6.146-6.58-9.841l-0.424-1.023l-11.603,4.805c-0.748-1.941-1.342-3.924-1.796-5.935l6.148-1.224l-0.217-1.087  c-0.398-2.003-0.617-4.019-0.681-6.036h6.269V64c0-4.016,0.774-7.922,2.303-11.611l0.425-1.024L24.79,46.558  c0.845-1.903,1.827-3.726,2.925-5.468l5.217,3.484l0.615-0.922c1.135-1.7,2.404-3.28,3.785-4.751l4.432,4.433l0.784-0.785  c2.835-2.834,6.146-5.048,9.843-6.58l1.025-0.425L48.607,23.94c1.942-0.748,3.925-1.34,5.936-1.796l1.223,6.151l1.089-0.217  c1.986-0.396,4.008-0.613,6.036-0.675v6.26H64c4.014,0,7.92,0.775,11.608,2.305l1.025,0.426l4.807-11.605  c1.904,0.847,3.726,1.828,5.469,2.926l-3.485,5.216l0.922,0.617c1.701,1.136,3.281,2.404,4.751,3.784l-4.432,4.433l0.784,0.784  c2.831,2.83,5.045,6.142,6.581,9.841l0.424,1.023l11.604-4.806c0.748,1.942,1.342,3.925,1.797,5.936L99.704,55.767z M99.052,88.756  c-1.188,1.686-2.495,3.291-3.929,4.799l-2.901-2.901c1.232-1.307,2.397-2.68,3.447-4.158L99.052,88.756z M93.901,110.746  c-2.45,1.57-5.008,2.924-7.647,4.08l-2.4-5.795l-1.025,0.425c-2.654,1.1-5.375,1.944-8.145,2.563l-0.794-3.991  c2.511-0.566,4.977-1.335,7.383-2.332l1.024-0.424l-4.821-11.634c3.226-1.466,6.159-3.428,8.745-5.847l2.878,2.877  c-1.471,1.384-3.051,2.654-4.748,3.789l-0.923,0.615L93.901,110.746z M45.17,109.456c-2.656-1.101-5.18-2.427-7.573-3.946  l2.263-3.385c2.172,1.373,4.46,2.574,6.868,3.57l1.024,0.426l4.82-11.633c3.309,1.242,6.771,1.93,10.318,2.048l-0.002,4.06  c-2.028-0.06-4.051-0.277-6.038-0.672l-1.087-0.215l-3.677,18.49c-2.847-0.625-5.611-1.476-8.293-2.521l2.4-5.797L45.17,109.456z   M65.107,102.82c1.805-0.053,3.604-0.222,5.381-0.523l0.793,3.99c-2.033,0.351-4.093,0.563-6.174,0.616V102.82z M18.541,82.827  c-1.099-2.654-1.943-5.376-2.562-8.146l3.992-0.794c0.565,2.51,1.334,4.977,2.331,7.383l0.425,1.024l11.633-4.818  c1.466,3.223,3.427,6.156,5.848,8.745l-2.878,2.877c-1.384-1.472-2.653-3.052-3.786-4.749l-0.617-0.922L17.251,93.9  c-1.569-2.451-2.923-5.008-4.079-7.647l5.795-2.401L18.541,82.827z M37.346,92.222c1.307,1.231,2.68,2.396,4.16,3.445l-2.262,3.384  c-1.686-1.189-3.291-2.496-4.798-3.929L37.346,92.222z M21.096,65.108l4.079,0.001c0.052,1.795,0.222,3.59,0.525,5.377l-3.988,0.794  C21.36,69.247,21.148,67.189,21.096,65.108z M9.803,52.088c0.623-2.847,1.473-5.611,2.52-8.293l5.795,2.399l0.424-1.024  c1.101-2.657,2.427-5.181,3.947-7.573l3.386,2.262c-1.374,2.173-2.575,4.461-3.571,6.87l-0.424,1.024l11.632,4.818  c-1.241,3.31-1.929,6.771-2.046,10.319h-4.068c0.061-2.019,0.28-4.034,0.676-6.038l0.216-1.087L9.803,52.088z M28.946,39.244  c1.19-1.687,2.495-3.291,3.929-4.799l2.902,2.901c-1.231,1.307-2.396,2.68-3.446,4.158L28.946,39.244z M34.099,17.253  c2.451-1.569,5.008-2.924,7.646-4.08l2.399,5.794l1.025-0.425c2.653-1.1,5.377-1.945,8.146-2.563l0.794,3.993  c-2.509,0.563-4.976,1.333-7.383,2.33l-1.025,0.425l4.823,11.634c-3.225,1.464-6.159,3.426-8.749,5.848l-2.877-2.877  c1.472-1.385,3.051-2.654,4.748-3.789l0.923-0.616L34.099,17.253z M82.828,18.542c2.658,1.101,5.182,2.427,7.574,3.946l-2.262,3.385  c-2.173-1.373-4.461-2.573-6.87-3.57l-1.024-0.425l-4.82,11.634c-3.309-1.242-6.77-1.929-10.316-2.048v-4.061  c2.028,0.061,4.051,0.277,6.037,0.672l1.088,0.216l3.677-18.49c2.847,0.624,5.611,1.474,8.294,2.521l-2.401,5.797L82.828,18.542z   M62.891,25.18c-1.803,0.052-3.603,0.221-5.379,0.522l-0.793-3.99c2.033-0.352,4.092-0.563,6.172-0.616V25.18z M90.651,35.777  c-1.307-1.231-2.68-2.396-4.159-3.445l2.264-3.386c1.686,1.19,3.291,2.497,4.798,3.929L90.651,35.777z M105.697,46.728l-0.425-1.024  l-11.635,4.819c-1.467-3.226-3.429-6.159-5.848-8.745l2.877-2.877c1.385,1.471,2.654,3.051,3.787,4.748l0.616,0.923l15.677-10.473  c1.569,2.452,2.922,5.009,4.079,7.646l-5.793,2.399l0.426,1.024c1.098,2.655,1.943,5.378,2.561,8.148l-3.991,0.793  C107.463,51.602,106.693,49.134,105.697,46.728z M98.793,29.202l0.785,0.786l8.885-8.883c5.142,5.326,9.235,11.449,12.188,18.228  l-3.776,1.564c-1.359-3.106-2.983-6.104-4.891-8.959l-0.615-0.923L95.671,41.502c-1.048-1.477-2.213-2.851-3.448-4.157l4.479-4.479  l-0.784-0.785c-1.839-1.84-3.824-3.494-5.932-4.977l2.262-3.386C94.575,25.351,96.766,27.173,98.793,29.202z M93.904,17.247  l-2.268,3.394c-2.206-1.403-4.517-2.65-6.938-3.713l1.556-3.759C88.899,14.325,91.456,15.679,93.904,17.247z M64,14.79h1.109V2.229  c7.416,0.13,14.642,1.564,21.507,4.271l-1.563,3.774c-3.155-1.233-6.422-2.205-9.796-2.876l-1.089-0.216l-3.683,18.517  c-1.774-0.301-3.574-0.469-5.377-0.52v-6.315H64c-2.603,0-5.177,0.235-7.714,0.675l-0.794-3.993  C58.288,15.054,61.128,14.792,64,14.79z M52.087,9.796l0.796,4.004c-2.555,0.566-5.071,1.319-7.533,2.278l-1.555-3.755  C46.479,11.273,49.244,10.421,52.087,9.796z M29.203,29.204l0.785-0.785l-8.883-8.882c5.322-5.141,11.445-9.234,18.229-12.188  l1.563,3.776c-3.106,1.359-6.104,2.981-8.96,4.891l-0.921,0.616l10.486,15.696c-1.479,1.048-2.851,2.215-4.157,3.449l-4.479-4.479  l-0.785,0.785c-1.84,1.839-3.493,3.825-4.975,5.931l-3.386-2.263C25.351,33.425,27.174,31.232,29.203,29.204z M17.247,34.095  l3.394,2.268c-1.404,2.206-2.65,4.517-3.714,6.938l-3.757-1.557C14.326,39.102,15.679,36.543,17.247,34.095z M14.791,63.997v-1.108  L2.229,62.89c0.129-7.415,1.564-14.639,4.27-21.507l3.775,1.563c-1.232,3.155-2.203,6.422-2.875,9.794l-0.217,1.088l18.515,3.684  c-0.302,1.787-0.47,3.582-0.522,5.379l-6.312-0.001v1.109c0.001,2.604,0.236,5.178,0.676,7.713l-3.992,0.794  C15.055,69.709,14.793,66.87,14.791,63.997z M9.795,75.912l4.006-0.797c0.565,2.554,1.318,5.069,2.277,7.531l-3.756,1.557  C11.273,81.52,10.42,78.754,9.795,75.912z M29.203,98.794l-0.783-0.785l-8.884,8.885c-5.138-5.323-9.233-11.445-12.188-18.228  l3.777-1.564c1.359,3.107,2.98,6.104,4.888,8.961l0.616,0.922l15.698-10.488c1.048,1.477,2.214,2.851,3.449,4.158l-4.478,4.477  l0.785,0.785c1.839,1.84,3.823,3.494,5.93,4.977l-2.263,3.385C33.426,102.646,31.232,100.824,29.203,98.794z M34.094,110.752  l2.269-3.396c2.206,1.403,4.516,2.65,6.938,3.714l-1.557,3.758C39.1,113.673,36.542,112.32,34.094,110.752z M64,113.207h-1.109  v12.564c-7.414-0.131-14.639-1.565-21.509-4.272l1.563-3.774c3.157,1.234,6.424,2.206,9.796,2.877l1.088,0.217l3.684-18.518  c1.776,0.301,3.574,0.469,5.377,0.52v6.316h1.109c2.604-0.002,5.179-0.236,7.715-0.676l0.795,3.992  C69.711,112.943,66.872,113.205,64,113.207z M75.913,118.203l-0.796-4.006c2.553-0.566,5.069-1.318,7.531-2.277l1.556,3.756  C81.52,116.727,78.755,117.578,75.913,118.203z M98.797,98.793l-0.785,0.785l8.883,8.884c-5.325,5.14-11.447,9.233-18.229,12.188  l-1.564-3.776c3.108-1.36,6.104-2.981,8.962-4.89l0.922-0.617L86.496,95.672c1.478-1.049,2.851-2.215,4.158-3.449l4.479,4.479  l0.784-0.784c1.84-1.839,3.494-3.825,4.978-5.931l3.385,2.261C102.648,94.573,100.826,96.765,98.797,98.793z M110.753,93.904  l-3.394-2.268c1.403-2.205,2.649-4.518,3.714-6.938l3.756,1.557C113.674,88.898,112.321,91.455,110.753,93.904z M121.501,86.616  l-3.776-1.563c1.235-3.156,2.206-6.423,2.877-9.794l0.216-1.088l-18.516-3.683c0.303-1.787,0.473-3.582,0.523-5.379h6.313v-1.11  c-0.001-2.604-0.236-5.178-0.676-7.712l3.991-0.794c0.492,2.795,0.754,5.634,0.756,8.506l0.001,1.109h12.563  C125.642,72.52,124.207,79.744,121.501,86.616z"/></svg>
                    {{-- <img src="{{ asset('/assets/image/logo.svg') }}" loading="lazy" alt="Photo by engin akyurt" class="h-full w-6 fill-current text-gray-950 dark:fill-white" /> --}}
                </div>
            </button>
            <!-- Page Heading -->
            {{-- @if (isset($header))
                <div class="w-full whitespace-nowrap md:text-base text-xs">
                    {{ $header }}
                </div>
            @endif --}}
            {{-- <h5 class="ml-2 text-base font-semibold text-gray-700 dark:text-gray-400 hidden md:block">社内システム</h5> --}}
        </div>
    </div>

    <div class="flex items-center">
        
        {{-- 共通リンク一覧 --}}
        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" tabindex="-1" class="inline-flex items-center p-2.5 text-sm font-medium text-center text-gray-900 rounded-sm hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button"> 
            <svg class="w-5 h-5 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 19">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.013 7.962a3.519 3.519 0 0 0-4.975 0l-3.554 3.554a3.518 3.518 0 0 0 4.975 4.975l.461-.46m-.461-4.515a3.518 3.518 0 0 0 4.975 0l3.553-3.554a3.518 3.518 0 0 0-4.974-4.975L10.3 3.7"/>
            </svg>
            {{-- <svg class="w-5 h-5 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
              </svg> --}}
          </button>
          
          <!-- Dropdown menu -->
          <div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                @foreach ($links as $link)
                <li>
                    <a href="{{ $link->url }}" target="_blank" class="block px-4 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $link->display_name }}</a>
                </li>
                @endforeach
              </ul>
          </div>

        {{-- ダークモードスイッチャー --}}
        <button id="theme-toggle" type="button" class="h-10 p-2.5 my-auto text-sm rounded-sm text-gray-800 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 dark:focus:ring-gray-700" tabindex="-1">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button>

        {{-- 通知ボックス --}}
        <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="relative flex items-end h-10 p-2.5 my-auto text-sm rounded-sm font-medium px-3 mr-2 text-right text-white focus:ring-2 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" tabindex="-1" type="button">
            {{-- <svg class="w-4 h-4 my-auto text-gray-600 dark:text-white focus:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 10h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H17M1 10v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M1 10l2-9h12l2 9M6 4h6M5 7h8"/>
            </svg> --}}
            <svg class="w-4 h-4 my-auto text-gray-800 dark:text-gray-400 focus:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
            </svg>
            <span class="sr-only">Notifications</span>
            <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-gray-300 rounded-full -top-1 -right-2 dark:border-gray-900">
                {{ count($unreadNotifications) }}
            </div>
        </button>
        
        <!-- 通知ボックスDropdown -->
        <div id="dropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-auto dark:bg-gray-700 dark:divide-gray-600 whitespace-nowrap">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                @foreach ($unreadNotifications  as $notification)
                <li class="flex justify-between hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    {{-- <p  class="block px-4 py-2">{{ $notification->data['notification_data']['reporter'] }}</p> --}}
                    <form action="{{ route('notifications.read', $notification) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="{{ is_null($notification->read_at) ? 'un-read' : '' }}">
                            <div class="flex justify-between hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <p class="block px-4 py-2">{{ $notification->data['notification_data']['reporter'] }}</p>
                                <p class="block px-4 py-2">{{ $notification->data['notification_data']['message'] }}</p>
                            </div>
                        </button>
                    </form>
                    {{-- <a href="{{ $notification->data['notification_data']['action_url'] }}" class="block px-4 py-2">{{ $notification->data['notification_data']['message'] }}</a> --}}
                    <div class="px-4 py-2">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</div>
                </li>
                @endforeach

            </ul>
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">すべてのメッセージを見る</a>
            </div>
        </div>

        <img class="w-10 h-10 rounded" src="{{ asset('assets/image/usericon.png') }}" alt="Default avatar">
        {{-- ユーザ設定 --}}
        <div class=" sm:flex sm:items-center sm:ml-1">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center bg-gray-100 px-3 py-4 border border-transparent text-sm leading-4 font-medium rounded-sm text-gray-900 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        {{-- <svg class="sm:hidden w-6 h-6 text-gray-800 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                        </svg> --}}
                        <div class="">
                            @if(Auth::check())
                            {{ Auth::user()->user_name }}
                            @endif
                        </div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
{{-- End 画面上部のナビゲーション --}}


<nav X-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

{{-- デスクトップ画面用 --}}
<div id="accordion-collapse" data-accordion="collapse" class="fixed mt-10 pt-4 dark:bg-gray-800 bg-gray-100 h-screen w-12 overflow-x-hidden hover:w-52 whitespace-nowrap transition-all duration-500 ease-in-out z-40 invisible md:visible border-r border-gray-200 dark:border-gray-700">

        <div class="py-4 pl-2">
        <ul class="space-y-1">
            <li>
                <x-nav-link :href="route('dashboard')" :tabindex="-1" :active="request()->routeIs('dashboard')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap" tabindex="-1">{{ __('ホーム') }}</span>
                </x-nav-link>
            </li>
            <li>
                <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-1" aria-expanded="false" aria-controls="accordion-body-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('取引先管理') }}</span>
                    <svg data-accordion-icon class="w-3 h-3 mr-1 rotate-270 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
                <ul  class="hidden py-1 space-y-1" id="accordion-body-1" aria-labelledby="accordion-heading-1">
                    <li>
                        @can('view_corporations')
                        <x-nav-link :href="route('corporations.index')" :active="request()->routeIs('corporations.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('法人一覧') }}</span>
                        </x-nav-link>
                        @endcan
                    </li>
                    <li>
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('vendors.index')" :active="request()->routeIs('vendors.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('client-person.index')" :active="request()->routeIs('client-person.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('顧客担当者一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('client-person.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('業者担当者一覧') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-2" aria-expanded="false" aria-controls="accordion-body-2">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.079 4.839a3 3 0 0 0-4.255.1M11 18h1.083A3.916 3.916 0 0 0 16 14.083V7A6 6 0 1 0 4 7v7m7 4v-1a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4V8H3a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1V8Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('サポート管理') }}</span>
                    <svg data-accordion-icon class="w-3 h-3 mr-1 rotate-270 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
                <ul  class="hidden py-1 space-y-1" id="accordion-body-2" aria-labelledby="accordion-heading-2">
                    <li>
                        <x-nav-link :href="route('support.index')" :active="request()->routeIs('support.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('サポート一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('契約一覧') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>

            <li>
                <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-3" aria-expanded="false" aria-controls="accordion-body-3">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/>
                        <path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('プロジェクト管理') }}</span>
                    <svg data-accordion-icon class="w-3 h-3 mr-1 rotate-270 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
                <ul  class="hidden py-1 space-y-1" id="accordion-body-3" aria-labelledby="accordion-heading-3">
                    <li>
                        <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('プロジェクト一覧') }}</span>
                        </x-nav-link>
                    </li>
                    {{-- <li>
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('受注情報一覧') }}</span>
                        </x-nav-link>
                    </li> --}}
                    <li>
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('発注情報一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('営業経費一覧') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('社内工数一覧') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>

            {{-- <li>
                <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/>
                        <path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('プロジェクト管理') }}</span>
                </x-nav-link>
            </li> --}}
            <li>
                <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                    </svg>
                    {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('営業報告管理') }}</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 5 4 4-4 4m5 0h5M2 1h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('工数管理') }}</span>
                </x-nav-link>
            </li>
            {{-- <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"fill="none" viewBox="0 0 17 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12v5m5-9v9m5-5v5m5-9v9M1 7l5-6 5 6 5-6"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('分析画面') }}</span>
                </x-nav-link>
            </li> --}}
            <li>
                <x-nav-link :href="route('keepfile.index')" :active="request()->routeIs('keepfile.index')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 19">
                        <path d="M1 19h13a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H0v10a1 1 0 0 0 1 1ZM0 6h7.443l-1.2-1.6a1 1 0 0 0-.8-.4H1a1 1 0 0 0-1 1v1Z"/>
                        <path d="M17 4h-4.557l-2.4-3.2a2.009 2.009 0 0 0-1.6-.8H4a2 2 0 0 0-2 2h3.443a3.014 3.014 0 0 1 2.4 1.2l2.1 2.8H14a3 3 0 0 1 3 3v8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Z"/>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('預託管理') }}</span>
                </x-nav-link>
            </li>

            <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
            
                {{-- <li>
                <a href="#" class="flex items-center p-2 text-gray-900 transition duration-75 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                   <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-900 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400" focusable="false" data-prefix="fas" data-icon="gem" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M378.7 32H133.3L256 182.7L378.7 32zM512 192l-107.4-141.3L289.6 192H512zM107.4 50.67L0 192h222.4L107.4 50.67zM244.3 474.9C247.3 478.2 251.6 480 256 480s8.653-1.828 11.67-5.062L510.6 224H1.365L244.3 474.9z"></path></svg>
                   <span class="ml-4">Upgrade to Pro</span>
                </a>
            </li> --}}
            <li>
                @can('adminOrAbobe')
                <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" data-accordion-target="#accordion-body-90" aria-expanded="false" aria-controls="accordion-body-90">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-900 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          <path d="M19 11V9a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L12 2.757V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L2.929 4.343a1 1 0 0 0 0 1.414l.536.536L2.757 8H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535L8 17.243V18a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H18a1 1 0 0 0 1-1Z"/>
                          <path d="M10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </g>
                    </svg>
                    <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('共通機能') }}</span>
                    <svg data-accordion-icon class="w-3 h-3 mr-1 rotate-270 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
                <ul  class="hidden py-1 space-y-1" id="accordion-body-90" aria-labelledby="accordion-heading-90">
                    @can('view_users')
                    <li>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('ユーザ管理') }}</span>
                        </x-nav-link>
                    </li>
                    @endcan
                    <li>
                        <x-nav-link :href="route('role-groups.index')" :active="request()->routeIs('role-groups.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('権限グループ') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('link.index')" :active="request()->routeIs('link.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('所属別リンク管理') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('masters.index')" :active="request()->routeIs('masters.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('マスタ管理') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('製品管理') }}</span>
                        </x-nav-link>
                    </li>  
                    @endcan
                    <li>
                        <x-nav-link :href="url('/log-viewer')" :active="request()->routeIs('log-viewer')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{-- <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg> --}}
                            <span class="flex-1 ml-10 whitespace-nowrap">{{ __('ログ調査') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>





{{-- スマホ画面 --}}    
    {{-- <div id="drawer-navigation" class=" top-0 left-2 z-40 h-screen p-4 w-16 transition-all transform duration-500   hover:w-56 overflow-x-hidden bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label"> --}}
    <div id="drawer-navigation" class="mt-12  fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full w-60 bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-1 font-medium">
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-900 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="flex-1 pt-1 ml-6 whitespace-nowrap">{{ __('ホーム') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-sm-client" data-collapse-toggle="dropdown-sm-client" tabindex="-1">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('取引先管理') }}</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="dropdown-sm-client" class="hidden py-1 space-y-1">
                        <li>
                            @can('view_corporations')
                            <x-nav-link :href="route('corporations.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('法人一覧') }}</span>
                            </x-nav-link>
                            @endcan
                        </li>
                        <li>
                            <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('顧客一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('vendors.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('業者一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('client-person.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('顧客担当者一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('client-person.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('業者担当者一覧') }}</span>
                            </x-nav-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" aria-controls="dropdown-sm-support" data-collapse-toggle="dropdown-sm-support">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.079 4.839a3 3 0 0 0-4.255.1M11 18h1.083A3.916 3.916 0 0 0 16 14.083V7A6 6 0 1 0 4 7v7m7 4v-1a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4V8H3a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1V8Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('サポート管理') }}</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-sm-support" class="hidden py-1 space-y-1">
                        <li>
                            <x-nav-link :href="route('support.index')" :active="request()->routeIs('support.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('サポート一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('契約一覧') }}</span>
                            </x-nav-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" tabindex="-1" aria-controls="dropdown-sm-project" data-collapse-toggle="dropdown-sm-project">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/>
                            <path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('プロジェクト管理') }}</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-sm-project" class="hidden py-1 space-y-1">
                        <li>
                            <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('プロジェクト一覧') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('clients.index')" :active="request()->routeIs('#')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" tabindex="-1">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('受注情報一覧') }}</span>
                            </x-nav-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17v1a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2M6 1v4a1 1 0 0 1-1 1H1m13.14.772 2.745 2.746M18.1 5.612a2.086 2.086 0 0 1 0 2.953l-6.65 6.646-3.693.739.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('営業報告管理') }}</span>
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 5 4 4-4 4m5 0h5M2 1h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('工数管理') }}</span>
                    </x-nav-link>
                </li>
                {{-- <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('#')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"fill="none" viewBox="0 0 17 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12v5m5-9v9m5-5v5m5-9v9M1 7l5-6 5 6 5-6"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('分析画面') }}</span>
                    </x-nav-link>
                </li> --}}
                <li>
                    <x-nav-link :href="route('keepfile.index')" :active="request()->routeIs('keepfile.index')" class="flex w-full items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 19">
                            <path d="M1 19h13a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H0v10a1 1 0 0 0 1 1ZM0 6h7.443l-1.2-1.6a1 1 0 0 0-.8-.4H1a1 1 0 0 0-1 1v1Z"/>
                            <path d="M17 4h-4.557l-2.4-3.2a2.009 2.009 0 0 0-1.6-.8H4a2 2 0 0 0-2 2h3.443a3.014 3.014 0 0 1 2.4 1.2l2.1 2.8H14a3 3 0 0 1 3 3v8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Z"/>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 whitespace-nowrap">{{ __('預託管理') }}</span>
                    </x-nav-link>
                </li>
                <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                <li>
                @can('adminOrAbobe')
                    <button type="button" class="flex items-center w-full pt-1 pr-1 pb-2 pl-1 text-sm  text-gray-900 transition duration-75 rounded-sm group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-sm-admin" data-collapse-toggle="dropdown-sm-admin" tabindex="-1">
                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                              <path d="M19 11V9a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L12 2.757V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L2.929 4.343a1 1 0 0 0 0 1.414l.536.536L2.757 8H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535L8 17.243V18a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H18a1 1 0 0 0 1-1Z"/>
                              <path d="M10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </g>
                        </svg>
                        <span class="flex-1 pt-1 ml-3 text-left whitespace-nowrap">{{ __('管理者機能') }}</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="dropdown-sm-admin" class="hidden py-1 space-y-1">
                        <li>
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('ユーザ管理') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('link.index')" :active="request()->routeIs('link.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('所属別リンク管理') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('masters.index')" :active="request()->routeIs('masters.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('マスタ管理') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('製品管理') }}</span>
                            </x-nav-link>
                        </li>
                    @endcan
                        @can('systemAdmin')
                        <li>
                            <x-nav-link :href="url('/log-viewer')" :active="request()->routeIs('log-viewer')" class="flex w-full items-center px-2 pb-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="flex-1 pt-1 ml-10 whitespace-nowrap">{{ __('ログ調査') }}</span>
                            </x-nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>