<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'flex items-center pl-2 sm:px-2.5  py-1.5 text-sm text-white rounded hover:bg-[#313a48] bg-[#364050] focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800',
  'data-tooltip-target' => 'tooltip-save-button',
  ' data-tooltip-placement' => 'bottom',

  ])}} >
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" class="w-6 h-6 text-white  sm:mr-2 mr-1.5 sm:ml-0" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
        <path d="M820-671.54v459.23Q820-182 799-161q-21 21-51.31 21H212.31Q182-140 161-161q-21-21-21-51.31v-535.38Q140-778 161-799q21-21 51.31-21h459.23L820-671.54ZM760-646 646-760H212.31q-5.39 0-8.85 3.46t-3.46 8.85v535.38q0 5.39 3.46 8.85t8.85 3.46h535.38q5.39 0 8.85-3.46t3.46-8.85V-646ZM480-269.23q41.54 0 70.77-29.23Q580-327.69 580-369.23q0-41.54-29.23-70.77-29.23-29.23-70.77-29.23-41.54 0-70.77 29.23Q380-410.77 380-369.23q0 41.54 29.23 70.77 29.23 29.23 70.77 29.23ZM255.39-564.62h328.45v-139.99H255.39v139.99ZM200-646v446-560 114Z"/>
    </svg>
    <span class="hidden sm:inline text-sm whitespace-nowrap pr-2">{{ $slot }}</span>
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
