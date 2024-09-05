<div class="flex gap-2 flex-wrap mt-3">
    <div class="grow relative">
        <input type="radio" name="payment" value="Cash" id="cash" class="peer sr-only" checked />
        <label for="cash"
            class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed text-teal-400 primary-bg-color-light h-12 border-2 border-transparent peer-checked:primary-boder-color cursor-pointer">
            <img src="{{ asset('public/icons/cash.svg') }}" alt="" />
            <span>{{ __('cash') }}</span>
        </label>
    </div>

    <div class="grow relative">
        <input type="radio" name="payment" id="card" value="Card" class="peer sr-only" />
        <label for="card"
            class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed text-blue-500 bg-blue-100 h-12 border-2 border-transparent peer-checked:border-blue-500 cursor-pointer peer-disabled:text-blue-300 peer-disabled:cursor-not-allowed">
            <img src="{{ asset('public/icons/card.svg') }}" alt="" />
            <span>{{ __('card') }}</span>
        </label>
    </div>

    <div class="grow relative">
        <input type="radio" name="payment" id="paypal" value="PayPal" class="peer sr-only" />
        <label for="paypal"
            class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-slate-200 text-indigo-900 h-12 border-2 border-transparent peer-checked:border-indigo-900 cursor-pointer peer-disabled:text-indigo-300 peer-disabled:cursor-not-allowed">
            <img src="{{ asset('public/icons/paypal.svg') }}" alt="" />
            <span>{{ __('paypal') }}</span>
        </label>
    </div>

    <div class="grow relative">
        <input type="radio" name="payment" id="Cheque" value="Cheque" class="peer sr-only" />
        <label for="Cheque"
            class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-red-100 text-red-400 h-12 border-2 border-transparent peer-checked:border-red-400 cursor-pointer peer-disabled:text-red-300 peer-disabled:cursor-not-allowed">
            <img src="{{ asset('public/icons/cheque.svg') }}" alt="" />
            <span>{{ __('cheque') }}</span>
        </label>
    </div>

    {{-- <div class="grow relative">
        <input type="radio" name="payment" id="Gift" value="Gift Card"
            class="peer sr-only" disabled />
        <label for="Gift"
            class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-violet-100 text-violet-700 h-12 border-2 border-transparent peer-checked:border-violet-700 cursor-pointer peer-disabled:text-violet-300 peer-disabled:cursor-not-allowed">
            <img src="{{ asset('public/icons/gift.svg') }}" alt="" />
            <span>Gift Card</span>
        </label>
    </div> --}}
</div>
