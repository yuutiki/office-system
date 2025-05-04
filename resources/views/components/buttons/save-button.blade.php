<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'flex items-center pl-2 sm:px-4 py-1.5 text-sm font-medium text-white rounded hover:bg-[#313a48] bg-[#364050] focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800',
  'data-tooltip-target' => 'tooltip-save-button',
  ' data-tooltip-placement' => 'bottom',

  ])}} >
    {{-- <svg class="w-4.5 h-4.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.25" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
    </svg> --}}
    <svg class="w-5 h-5 text-white my-0.5 ml-1 mr-2 sm:ml-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
    </svg>
    <span class="hidden sm:inline text-sm whitespace-nowrap">{{ $slot }}</span>
</button>

<div id="tooltip-save-button" role="tooltip" class="absolute  z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-600">
    Ctrl + S
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>

<script>
    $("form").submit(function() {
    var self = this;
    $(":submit", self).prop("disabled", true);
    setTimeout(function() {
        $(":submit", self).prop("disabled", false);
    }, 3000);
    });
</script>

{{--type を submit ではなく button にし、 onclick=>submit とすることで入力途中にenterを押してもsubmitされなくする（誤submit防止）  --}}
{{-- 上記だと２重サブミット防止と相性が悪いので、typeをsubmitにして、フォーム側でonkeydown="return event.key !== 'Enter';"　を記述して誤submitを防止する --}}
