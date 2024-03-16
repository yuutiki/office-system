{{-- @props(['form' => null])

<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'])}} form="{{ $form }}">
    {{ $slot }}
</button> --}}
<button {{ $attributes->merge([
  'type' => 'submit',
  'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'])}} >
    {{ $slot }}
</button>

<script>

$("form").submit(function() {
  var self = this;
  $(":submit", self).prop("disabled", true);
  setTimeout(function() {
    $(":submit", self).prop("disabled", false);
  }, 10000);
});
</script>

{{--type を submit ではなく button にし、 onclick=>submit とすることで入力途中にenterを押してもsubmitされなくする（誤submit防止）  --}}
{{-- 上記だと２重サブミット防止と相性が悪いので、typeをsubmitにして、フォーム側でonkeydown="return event.key !== 'Enter';"　を記述して誤submitを防止する --}}
