<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("ログインしました") }}
                </div>
            </div>
        </div>
    </div>



<div class="bg-dark py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
      <div class="mb-6 flex items-end justify-between gap-4">
        <h2 class="text-2xl font-bold dark:text-gray-100 lg:text-3xl">リンク</h2>
  
        <a href="#" class="inline-block rounded-lg border bg-white px-4 py-2 text-center text-sm font-semibold text-gray-500 outline-none ring-indigo-300 transition duration-100 hover:bg-gray-100 focus-visible:ring active:bg-gray-200 md:px-8 md:py-3 md:text-base">Show more</a>
      </div>
  
      <div class="grid gap-x-4 gap-y-6 sm:grid-cols-2 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-5">
        <!-- 出退勤システム - start -->
        <div>
          <a target="_blank" href="https://e-timecard.systemd.co.jp:18443/WebTimeCard/Auth/Login?ReturnUrl=%2FWebTimeCard%2FHome%2FList" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
            <img src="{{ asset('/assets/image/tokei.png') }}" loading="lazy" alt="Photo by Austin Wade" class="object-contain h-full w-full  object-center transition duration-200 group-hover:scale-110" />
          </a>
  
          <div class="flex flex-col">
            <a target="_blank" href="https://e-timecard.systemd.co.jp:18443/WebTimeCard/Auth/Login?ReturnUrl=%2FWebTimeCard%2FHome%2FList" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">TimeCard</a>
          </div>
        </div>
        <!-- 出退勤システム - end -->
  
        <!-- サイボウズ - start -->
        <div>
            <a target="_blank" href="https://cybozu.systemd.co.jp/" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="{{ asset('/assets/image/cybozu.png') }}" loading="lazy" alt="Photo by engin akyurt" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
            </a>
  
            <div class="flex flex-col">
                <a target="_blank" href="https://cybozu.systemd.co.jp/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">Cybozu</a>
            </div>
        </div>
        <!-- サイボウズ - end -->
        <!-- 郵送依頼 - start -->
        <div>
            <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="{{ asset('/assets/image/mail.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
            </a>
  
            <div class="flex flex-col">
                <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">郵送依頼</a>
            </div>
        </div>
        <!-- 郵送依頼 - end -->

  
        <!--制度変更情報 - start -->
        <div>
            <a target="_blank" href="http://getsserver:50001/wordpress/" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="{{ asset('/assets/image/link.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
            </a>
  
            <div class="flex flex-col">
                <a target="_blank" href="http://getsserver:50001/wordpress/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">制度変更ポータル</a>
            </div>
        </div>
        <!-- 制度変更情報 - end -->
        
        <!-- ナレッジスイート - start -->
        <div>
            <a target="_blank" href="https://gridy.jp/home" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="{{ asset('/assets/image/link.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="https://gridy.jp/home" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">knowledge suite</a>
            </div>
        </div>
        <!-- ナレッジスイート - end -->

        <!-- プロゲート - start -->
        <div>
            <a target="_blank" href="https://prog-8.com/dashboard" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="{{ asset('/assets/image/progate.png') }}" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-contain object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="https://prog-8.com/dashboard" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">Progate</a>
            </div>
        </div>
        <!-- プロゲート - end -->

        <!-- クラウドWiki - start -->
        <div>
            <a target="_blank" href="http://cloudunyo/wordpress/" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="http://cloudunyo/wordpress/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">クラウドWiki</a>
            </div>
        </div>
        <!-- product - end -->
        <!-- product - start -->
        <div>
            <a target="_blank" href="http://www.ntrsupport.jp/setbox/" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="http://www.ntrsupport.jp/setbox/" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">NTR support</a>
            </div>
        </div>
        <!-- product - end -->  
        <!-- product - start -->
        <div>
            <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">#</a>
            </div>
        </div>
        <!-- product - end -->
        <!-- product - start -->
        <div>
            <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="group mb-2 block h-48 overflow-hidden rounded-lg bg-gray-100 shadow-lg lg:mb-3">
                <img src="https://images.unsplash.com/photo-1552668693-d0738e00eca8?auto=format&q=75&fit=crop&crop=top&w=600&h=700" loading="lazy" alt="Photo by Austin Wade" class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
            </a>
    
            <div class="flex flex-col">
                <a target="_blank" href="https://forms.office.com/r/P5ZnLFKaGY" class="text-lg font-bold dark:text-gray-100 transition duration-100 hover:text-gray-500 lg:text-xl">#</a>
            </div>
        </div>
        <!-- product - end -->    

      </div>
    </div>
  </div>

</x-app-layout>