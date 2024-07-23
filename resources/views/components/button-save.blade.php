{{-- @props(['form' => null])

<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'])}} form="{{ $form }}">
    {{ $slot }}
</button> --}}
<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'inline-flex items-center text-center px-1 md:px-2 py-[3px] rounded text-xs text-white
              focus:outline-none
              border border-blue-700 border-transparent
              bg-blue-700 hover:bg-blue-800 focus:bg-gray-700 active:bg-gray-900
              dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:bg-blue-600
              dark:focus:ring-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
              transition ease-in-out duration-150'
  ])}} >
    {{-- <svg class="w-4.5 h-4.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.25" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
    </svg> --}}
    <svg class="w-5 h-5 text-white my-0.5 ml-1 sm:ml-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
    </svg>
    {{ $slot }}
</button>



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
