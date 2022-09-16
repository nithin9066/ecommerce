<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
    <style>
        
         *,
        :after,
        :before {
            border: 0 solid #e5e7eb;
            box-sizing: border-box;
        }

        :after,
        :before {
            --tw-content: "";
        }

        html {
            -webkit-text-size-adjust: 100%;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5;
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4;
        }

        body {
            line-height: inherit;
            margin: 0;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        table {
            border-collapse: collapse;
            border-color: inherit;
            text-indent: 0;
        }

        :-moz-focusring {
            outline: auto;
        }

        p {
            margin: 0;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        :disabled {
            cursor: default;
        }

        img {
            display: block;
            vertical-align: middle;
        }

        img {
            height: auto;
            max-width: 100%;
        }

        *,
        :after,
        :before {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-scroll-snap-strictness: proximity;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgba(63, 131, 248, .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
        }

        .relative {
            position: relative;
        }

        .my-10 {
            margin-bottom: 2.5rem;
            margin-top: 2.5rem;
        }

        .my-4 {
            margin-bottom: 1rem;
            margin-top: 1rem;
        }

        .ml-auto {
            margin-left: auto;
        }

        .mt-10 {
            margin-top: 2.5rem;
        }

        .flex {
            display: flex;
        }

        .h-full {
            height: 100%;
        }

        .h-24 {
            height: 6rem;
        }

        .h-screen {
            height: 100vh;
        }

        .w-full {
            width: 100%;
        }

        .w-24 {
            width: 6rem;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .space-y-2>:not([hidden])~:not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-bottom: calc(.5rem*var(--tw-space-y-reverse));
            margin-top: calc(.5rem*(1 - var(--tw-space-y-reverse)));
        }

        .space-y-1>:not([hidden])~:not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-bottom: calc(.25rem*var(--tw-space-y-reverse));
            margin-top: calc(.25rem*(1 - var(--tw-space-y-reverse)));
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-r {
            border-right-width: 1px;
        }

        .border-t {
            border-top-width: 1px;
        }

        .border {
            border-width: 1px;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255/var(--tw-bg-opacity));
        }

        .bg-indigo-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(229 237 255/var(--tw-bg-opacity));
        }

        .bg-indigo-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(88 80 236/var(--tw-bg-opacity));
        }

        .bg-indigo-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(104 117 245/var(--tw-bg-opacity));
        }

        .p-5 {
            padding: 1.25rem;
        }

        .py-1 {
            padding-bottom: .25rem;
            padding-top: .25rem;
        }

        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .py-3 {
            padding-bottom: .75rem;
            padding-top: .75rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-4 {
            padding-bottom: 1rem;
            padding-top: 1rem;
        }

        .text-left {
            text-align: left;
        }

        .text-sm {
            font-size: .875rem;
            line-height: 1.25rem;
        }

        .text-xs {
            font-size: .75rem;
            line-height: 1rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39/var(--tw-text-opacity));
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128/var(--tw-text-opacity));
        }

        /*! CSS Used from: Embedded */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }

        ::after,
        ::before {
            --tw-content: '';
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        body {
            margin: 0;
            line-height: inherit;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse;
        }

        :-moz-focusring {
            outline: auto;
        }

        p {
            margin: 0;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        :disabled {
            cursor: default;
        }

        img {
            display: block;
            vertical-align: middle;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-scroll-snap-strictness: proximity;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
        }

        .relative {
            position: relative;
        }

        .m-auto {
            margin: auto;
        }

        .my-10 {
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
        }

        .my-5 {
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .my-4 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .mx-5 {
            margin-left: 1.25rem;
            margin-right: 1.25rem;
        }

        .my-20 {
            margin-top: 5rem;
            margin-bottom: 5rem;
        }

        .mt-10 {
            margin-top: 2.5rem;
        }

        .ml-auto {
            margin-left: auto;
        }

        .flex {
            display: flex;
        }

        .h-screen {
            height: 100vh;
        }

        .h-full {
            height: 100%;
        }

        .h-1\/4 {
            height: 25%;
        }

        .h-24 {
            height: 6rem;
        }

        .w-24 {
            width: 6rem;
        }

        .w-full {
            width: 100%;
        }

        .w-fit {
            width: -moz-fit-content;
            width: fit-content;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
        }

        .space-y-1> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.25rem * var(--tw-space-y-reverse));
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .border-r {
            border-right-width: 1px;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-t {
            border-top-width: 1px;
        }

        .border-indigo-100 {
            --tw-border-opacity: 1;
            border-color: rgb(224 231 255 / var(--tw-border-opacity));
        }

        .border-indigo-400 {
            --tw-border-opacity: 1;
            border-color: rgb(129 140 248 / var(--tw-border-opacity));
        }

        .bg-indigo-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(79 70 229 / var(--tw-bg-opacity));
        }

        .bg-indigo-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(224 231 255 / var(--tw-bg-opacity));
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }

        .bg-indigo-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(99 102 241 / var(--tw-bg-opacity));
        }

        .p-5 {
            padding: 1.25rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .p-10 {
            padding: 2.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .text-left {
            text-align: left;
        }

        .text-start {
            text-align: start;
        }

        .text-end {
            text-align: end;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-medium {
            font-weight: 500;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-slate-200 {
            --tw-text-opacity: 1;
            color: rgb(226 232 240 / var(--tw-text-opacity));
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity));
        }

        .text-indigo-500 {
            --tw-text-opacity: 1;
            color: rgb(99 102 241 / var(--tw-text-opacity));
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity));
        }

        .text-black {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity));
        }

        .text-center {
            text-align: center
        }

        @media (prefers-color-scheme: dark) {
            .dark\:text-gray-400 {
                --tw-text-opacity: 1;
                color: rgb(156 163 175 / var(--tw-text-opacity));
            }

            .dark\:text-white {
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity));
            }
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tr style="background: black; color: white" class="w-full">
            <td class="p-5">
                <table>
                    <tr>
                        <td>
                            <div>
                                <img width="300" src="https://apsensyscare.com/logo.png" alt=""><span class="font-bold" style="color: white; font-size: 1.5rem">.com</span>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="text-base">
                                <span>Contact Us : +91 9986123677 || info@apsensyscare.com</span>
                            </div>
                            <div>
                                <span>298/299, SGR Towers,
                                    7th cross, Domlur Layout,
                                    Bangalore, Karnataka, India 560071.</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="w-full">
                <div class="p-5 w-full">
                    <div class="space-y-2 font-medium my-5">
                        <p><span class="font-bold uppercase">Date: </span> {{\now()->format('d-m-Y | h:i:s A')}}</p>
                        <p><span class="font-bold uppercase">Order Id: </span> #{{$details[0]->order_id}}</p>
                    </div>
                    <div class="border-b border-indigo-100 py-10">
                        <div>
                            <p class="border-b border-indigo-100 font-bold my-4">BILL TO</p>
                            <ul class="font-medium space-y-1">
                                <li><span class="font-bold">Name: </span>{{$address->name}}</li>
                                <li><span class="font-bold">Address: </span>{{$address->address}}</li>
                                <li><span class="font-bold">Conatct: </span>{{$address->phone}}</li>
                                <li><span class="font-bold">Email: </span>{{$address->email}}</li>
                            </ul>
                        </div>
                        <div class="my-5">
                            <p class="border-b border-indigo-100 font-bold my-4">SHIP TO</p>
                            <ul class="font-medium space-y-1">
                                <li><span class="font-bold">Name: </span>{{$address->name}}</li>
                                <li><span class="font-bold">Address: </span>{{$address->address}}</li>
                                <li><span class="font-bold">Conatct: </span>{{$address->phone}}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="overflow-x-auto relative mt-10">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border">
                            <thead class="text-xs text-indigo-500 uppercase bg-indigo-100">
                                <tr class="text-center border-b">
                                    <th scope="col" class="py-3 px-6">
                                        Product name
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        QTY
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Unit Price
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($details as $item)
                                <tr class="bg-white border-b border-indigo-100">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->product_name}}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{$item->items}}
                                    </td>
                                    <td class="py-4 px-6">
                                        <img src="https://cdn-icons-png.flaticon.com/512/25/25473.png" width="10" alt="">{{$item->cost/$item->items}}
                                    </td>
                                    <td class="py-4 px-6">
                                        <img src="https://cdn-icons-png.flaticon.com/512/25/25473.png" width="10" alt="">{{$item->cost}}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">
                                        <table class="p-10">
                                            <tr class="text-base">
                                                <td>
                                                    <div class="w-full">
                                                        <table>
                                                            <tr>
                                                                <td class="px-6">SubTotal:</td>
                                                                <td class="px-6"><img src="https://cdn-icons-png.flaticon.com/512/25/25473.png" width="10" alt="">{{$subtotal}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-6">Shipping:</td>
                                                                <td class="px-6"><img src="https://cdn-icons-png.flaticon.com/512/25/25473.png" width="10" alt="">{{$shipping}}</td>
                                                            </tr>
                                                            <tr class="font-bold">
                                                                <td class="px-6">Total:</td>
                                                                <td class="px-6"><img src="https://cdn-icons-png.flaticon.com/512/25/25473.png" width="10" alt="">{{$shipping + $subtotal}}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="my-20 w-full">
                        <table class="w-full">
                            <tr class="w-full">
                                <td class="mx-5 text-base font-medium my-20">
                                    Company Signature:
                                    
                                </td>
                                <td class="text-base font-medium my-20" style="text-align: center">Customer Signature:</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>