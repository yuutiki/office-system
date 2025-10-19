<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'flex items-center pl-2 sm:pl-2 sm:pr-4  py-1.5 text-sm font-medium text-white rounded bg-indigo-700 hover:bg-indigo-800 focus:ring-2 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800'
])}} >
    <svg class="w-5 h-5 text-white my-0.5  mr-2 sm:ml-0" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
        <path d="M252.31-100Q222-100 201-121q-21-21-21-51.31v-615.38Q180-818 201-839q21-21 51.31-21H570l210 210v477.69Q780-142 759-121q-21 21-51.31 21H252.31ZM540-620v-180H252.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v615.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h455.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46V-620H540ZM240-800v180-180V-160v-640Z"/>
    </svg>
    <span class="hidden sm:inline text-sm whitespace-nowrap">
        {{ $slot }}
    </span>
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
