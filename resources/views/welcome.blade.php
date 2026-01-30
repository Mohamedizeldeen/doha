<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Doha - Salon</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">

       
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--color-red-50:oklch(.971 .013 17.38);--color-red-100:oklch(.936 .032 17.717);--color-red-200:oklch(.885 .062 18.334);--color-red-300:oklch(.808 .114 19.571);--color-red-400:oklch(.704 .191 22.216);--color-red-500:oklch(.637 .237 25.331);--color-red-600:oklch(.577 .245 27.325);--color-red-700:oklch(.505 .213 27.518);--color-red-800:oklch(.444 .177 26.899);--color-red-900:oklch(.396 .141 25.723);--color-red-950:oklch(.258 .092 26.042);--color-orange-50:oklch(.98 .016 73.684);--color-orange-100:oklch(.954 .038 75.164);--color-orange-200:oklch(.901 .076 70.697);--color-orange-300:oklch(.837 .128 66.29);--color-orange-400:oklch(.75 .183 55.934);--color-orange-500:oklch(.705 .213 47.604);--color-orange-600:oklch(.646 .222 41.116);--color-orange-700:oklch(.553 .195 38.402);--color-orange-800:oklch(.47 .157 37.304);--color-orange-900:oklch(.408 .123 38.172);--color-orange-950:oklch(.266 .079 36.259);--color-amber-50:oklch(.987 .022 95.277);--color-amber-100:oklch(.962 .059 95.617);--color-amber-200:oklch(.924 .12 95.746);--color-amber-300:oklch(.879 .169 91.605);--color-amber-400:oklch(.828 .189 84.429);--color-amber-500:oklch(.769 .188 70.08);--color-amber-600:oklch(.666 .179 58.318);--color-amber-700:oklch(.555 .163 48.998);--color-amber-800:oklch(.473 .137 46.201);--color-amber-900:oklch(.414 .112 45.904);--color-amber-950:oklch(.279 .077 45.635);--color-yellow-50:oklch(.987 .026 102.212);--color-yellow-100:oklch(.973 .071 103.193);--color-yellow-200:oklch(.945 .129 101.54);--color-yellow-300:oklch(.905 .182 98.111);--color-yellow-400:oklch(.852 .199 91.936);--color-yellow-500:oklch(.795 .184 86.047);--color-yellow-600:oklch(.681 .162 75.834);--color-yellow-700:oklch(.554 .135 66.442);--color-yellow-800:oklch(.476 .114 61.907);--color-yellow-900:oklch(.421 .095 57.708);--color-yellow-950:oklch(.286 .066 53.813);--color-lime-50:oklch(.986 .031 120.757);--color-lime-100:oklch(.967 .067 122.328);--color-lime-200:oklch(.938 .127 124.321);--color-lime-300:oklch(.897 .196 126.665);--color-lime-400:oklch(.841 .238 128.85);--color-lime-500:oklch(.768 .233 130.85);--color-lime-600:oklch(.648 .2 131.684);--color-lime-700:oklch(.532 .157 131.589);--color-lime-800:oklch(.453 .124 130.933);--color-lime-900:oklch(.405 .101 131.063);--color-lime-950:oklch(.274 .072 132.109);--color-green-50:oklch(.982 .018 155.826);--color-green-100:oklch(.962 .044 156.743);--color-green-200:oklch(.925 .084 155.995);--color-green-300:oklch(.871 .15 154.449);--color-green-400:oklch(.792 .209 151.711);--color-green-500:oklch(.723 .219 149.579);--color-green-600:oklch(.627 .194 149.214);--color-green-700:oklch(.527 .154 150.069);--color-green-800:oklch(.448 .119 151.328);--color-green-900:oklch(.393 .095 152.535);--color-green-950:oklch(.266 .065 152.934);--color-emerald-50:oklch(.979 .021 166.113);--color-emerald-100:oklch(.95 .052 163.051);--color-emerald-200:oklch(.905 .093 164.15);--color-emerald-300:oklch(.845 .143 164.978);--color-emerald-400:oklch(.765 .177 163.223);--color-emerald-500:oklch(.696 .17 162.48);--color-emerald-600:oklch(.596 .145 163.225);--color-emerald-700:oklch(.508 .118 165.612);--color-emerald-800:oklch(.432 .095 166.913);--color-emerald-900:oklch(.378 .077 168.94);--color-emerald-950:oklch(.262 .051 172.552);--color-teal-50:oklch(.984 .014 180.72);--color-teal-100:oklch(.953 .051 180.801);--color-teal-200:oklch(.91 .096 180.426);--color-teal-300:oklch(.855 .138 181.071);--color-teal-400:oklch(.777 .152 181.912);--color-teal-500:oklch(.704 .14 182.503);--color-teal-600:oklch(.6 .118 184.704);--color-teal-700:oklch(.511 .096 186.391);--color-teal-800:oklch(.437 .078 188.216);--color-teal-900:oklch(.386 .063 188.416);--color-teal-950:oklch(.277 .046 192.524);--color-cyan-50:oklch(.984 .019 200.873);--color-cyan-100:oklch(.956 .045 203.388);--color-cyan-200:oklch(.917 .08 205.041);--color-cyan-300:oklch(.865 .127 207.078);--color-cyan-400:oklch(.789 .154 211.53);--color-cyan-500:oklch(.715 .143 215.221);--color-cyan-600:oklch(.609 .126 221.723);--color-cyan-700:oklch(.52 .105 223.128);--color-cyan-800:oklch(.45 .085 224.283);--color-cyan-900:oklch(.398 .07 227.392);--color-cyan-950:oklch(.302 .056 229.695);--color-sky-50:oklch(.977 .013 236.62);--color-sky-100:oklch(.951 .026 236.824);--color-sky-200:oklch(.901 .058 230.902);--color-sky-300:oklch(.828 .111 230.318);--color-sky-400:oklch(.746 .16 232.661);--color-sky-500:oklch(.685 .169 237.323);--color-sky-600:oklch(.588 .158 241.966);--color-sky-700:oklch(.5 .134 242.749);--color-sky-800:oklch(.443 .11 240.79);--color-sky-900:oklch(.391 .09 240.876);--color-sky-950:oklch(.293 .066 243.157);--color-blue-50:oklch(.97 .014 254.604);--color-blue-100:oklch(.932 .032 255.585);--color-blue-200:oklch(.882 .059 254.128);--color-blue-300:oklch(.809 .105 251.813);--color-blue-400:oklch(.707 .165 254.624);--color-blue-500:oklch(.623 .214 259.815);--color-blue-600:oklch(.546 .245 262.881);--color-blue-700:oklch(.488 .243 264.376);--color-blue-800:oklch(.424 .199 265.638);--color-blue-900:oklch(.379 .146 265.522);--color-blue-950:oklch(.282 .091 267.935);--color-indigo-50:oklch(.962 .018 272.314);--color-indigo-100:oklch(.93 .034 272.788);--color-indigo-200:oklch(.87 .065 274.039);--color-indigo-300:oklch(.785 .115 274.713);--color-indigo-400:oklch(.673 .182 276.935);--color-indigo-500:oklch(.585 .233 277.117);--color-indigo-600:oklch(.511 .262 276.966);--color-indigo-700:oklch(.457 .24 277.023);--color-indigo-800:oklch(.398 .195 277.366);--color-indigo-900:oklch(.359 .144 278.697);--color-indigo-950:oklch(.257 .09 281.288);--color-violet-50:oklch(.969 .016 293.756);--color-violet-100:oklch(.943 .029 294.588);--color-violet-200:oklch(.894 .057 293.283);--color-violet-300:oklch(.811 .111 293.571);--color-violet-400:oklch(.702 .183 293.541);--color-violet-500:oklch(.606 .25 292.717);--color-violet-600:oklch(.541 .281 293.009);--color-violet-700:oklch(.491 .27 292.581);--color-violet-800:oklch(.432 .232 292.759);--color-violet-900:oklch(.38 .189 293.745);--color-violet-950:oklch(.283 .141 291.089);--color-purple-50:oklch(.977 .014 308.299);--color-purple-100:oklch(.946 .033 307.174);--color-purple-200:oklch(.902 .063 306.703);--color-purple-300:oklch(.827 .119 306.383);--color-purple-400:oklch(.714 .203 305.504);--color-purple-500:oklch(.627 .265 303.9);--color-purple-600:oklch(.558 .288 302.321);--color-purple-700:oklch(.496 .265 301.924);--color-purple-800:oklch(.438 .218 303.724);--color-purple-900:oklch(.381 .176 304.987);--color-purple-950:oklch(.291 .149 302.717);--color-fuchsia-50:oklch(.977 .017 320.058);--color-fuchsia-100:oklch(.952 .037 318.852);--color-fuchsia-200:oklch(.903 .076 319.62);--color-fuchsia-300:oklch(.833 .145 321.434);--color-fuchsia-400:oklch(.74 .238 322.16);--color-fuchsia-500:oklch(.667 .295 322.15);--color-fuchsia-600:oklch(.591 .293 322.896);--color-fuchsia-700:oklch(.518 .253 323.949);--color-fuchsia-800:oklch(.452 .211 324.591);--color-fuchsia-900:oklch(.401 .17 325.612);--color-fuchsia-950:oklch(.293 .136 325.661);--color-pink-50:oklch(.971 .014 343.198);--color-pink-100:oklch(.948 .028 342.258);--color-pink-200:oklch(.899 .061 343.231);--color-pink-300:oklch(.823 .12 346.018);--color-pink-400:oklch(.718 .202 349.761);--color-pink-500:oklch(.656 .241 354.308);--color-pink-600:oklch(.592 .249 .584);--color-pink-700:oklch(.525 .223 3.958);--color-pink-800:oklch(.459 .187 3.815);--color-pink-900:oklch(.408 .153 2.432);--color-pink-950:oklch(.284 .109 3.907);--color-rose-50:oklch(.969 .015 12.422);--color-rose-100:oklch(.941 .03 12.58);--color-rose-200:oklch(.892 .058 10.001);--color-rose-300:oklch(.81 .117 11.638);--color-rose-400:oklch(.712 .194 13.428);--color-rose-500:oklch(.645 .246 16.439);--color-rose-600:oklch(.586 .253 17.585);--color-rose-700:oklch(.514 .222 16.935);--color-rose-800:oklch(.455 .188 13.697);--color-rose-900:oklch(.41 .159 10.272);--color-rose-950:oklch(.271 .105 12.094);--color-slate-50:oklch(.984 .003 247.858);--color-slate-100:oklch(.968 .007 247.896);--color-slate-200:oklch(.929 .013 255.508);--color-slate-300:oklch(.869 .022 252.894);--color-slate-400:oklch(.704 .04 256.788);--color-slate-500:oklch(.554 .046 257.417);--color-slate-600:oklch(.446 .043 257.281);--color-slate-700:oklch(.372 .044 257.287);--color-slate-800:oklch(.279 .041 260.031);--color-slate-900:oklch(.208 .042 265.755);--color-slate-950:oklch(.129 .042 264.695);--color-gray-50:oklch(.985 .002 247.839);--color-gray-100:oklch(.967 .003 264.542);--color-gray-200:oklch(.928 .006 264.531);--color-gray-300:oklch(.872 .01 258.338);--color-gray-400:oklch(.707 .022 261.325);--color-gray-500:oklch(.551 .027 264.364);--color-gray-600:oklch(.446 .03 256.802);--color-gray-700:oklch(.373 .034 259.733);--color-gray-800:oklch(.278 .033 256.848);--color-gray-900:oklch(.21 .034 264.665);--color-gray-950:oklch(.13 .028 261.692);--color-zinc-50:oklch(.985 0 0);--color-zinc-100:oklch(.967 .001 286.375);--color-zinc-200:oklch(.92 .004 286.32);--color-zinc-300:oklch(.871 .006 286.286);--color-zinc-400:oklch(.705 .015 286.067);--color-zinc-500:oklch(.552 .016 285.938);--color-zinc-600:oklch(.442 .017 285.786);--color-zinc-700:oklch(.37 .013 285.805);--color-zinc-800:oklch(.274 .006 286.033);--color-zinc-900:oklch(.21 .006 285.885);--color-zinc-950:oklch(.141 .005 285.823);--color-neutral-50:oklch(.985 0 0);--color-neutral-100:oklch(.97 0 0);--color-neutral-200:oklch(.922 0 0);--color-neutral-300:oklch(.87 0 0);--color-neutral-400:oklch(.708 0 0);--color-neutral-500:oklch(.556 0 0);--color-neutral-600:oklch(.439 0 0);--color-neutral-700:oklch(.371 0 0);--color-neutral-800:oklch(.269 0 0);--color-neutral-900:oklch(.205 0 0);--color-neutral-950:oklch(.145 0 0);--color-stone-50:oklch(.985 .001 106.423);--color-stone-100:oklch(.97 .001 106.424);--color-stone-200:oklch(.923 .003 48.717);--color-stone-300:oklch(.869 .005 56.366);--color-stone-400:oklch(.709 .01 56.259);--color-stone-500:oklch(.553 .013 58.071);--color-stone-600:oklch(.444 .011 73.639);--color-stone-700:oklch(.374 .01 67.558);--color-stone-800:oklch(.268 .007 34.298);--color-stone-900:oklch(.216 .006 56.043);--color-stone-950:oklch(.147 .004 49.25);--color-black:#000;--color-white:#fff;--spacing:.25rem;--breakpoint-sm:40rem;--breakpoint-md:48rem;--breakpoint-lg:64rem;--breakpoint-xl:80rem;--breakpoint-2xl:96rem;--container-3xs:16rem;--container-2xs:18rem;--container-xs:20rem;--container-sm:24rem;--container-md:28rem;--container-lg:32rem;--container-xl:36rem;--container-2xl:42rem;--container-3xl:48rem;--container-4xl:56rem;--container-5xl:64rem;--container-6xl:72rem;--container-7xl:80rem;--text-xs:.75rem;--text-xs--line-height:calc(1/.75);--text-sm:.875rem;--text-sm--line-height:calc(1.25/.875);--text-base:1rem;--text-base--line-height: 1.5 ;--text-lg:1.125rem;--text-lg--line-height:calc(1.75/1.125);--text-xl:1.25rem;--text-xl--line-height:calc(1.75/1.25);--text-2xl:1.5rem;--text-2xl--line-height:calc(2/1.5);--text-3xl:1.875rem;--text-3xl--line-height: 1.2 ;--text-4xl:2.25rem;--text-4xl--line-height:calc(2.5/2.25);--text-5xl:3rem;--text-5xl--line-height:1;--text-6xl:3.75rem;--text-6xl--line-height:1;--text-7xl:4.5rem;--text-7xl--line-height:1;--text-8xl:6rem;--text-8xl--line-height:1;--text-9xl:8rem;--text-9xl--line-height:1;--font-weight-thin:100;--font-weight-extralight:200;--font-weight-light:300;--font-weight-normal:400;--font-weight-medium:500;--font-weight-semibold:600;--font-weight-bold:700;--font-weight-extrabold:800;--font-weight-black:900;--tracking-tighter:-.05em;--tracking-tight:-.025em;--tracking-normal:0em;--tracking-wide:.025em;--tracking-wider:.05em;--tracking-widest:.1em;--leading-tight:1.25;--leading-snug:1.375;--leading-normal:1.5;--leading-relaxed:1.625;--leading-loose:2;--radius-xs:.125rem;--radius-sm:.25rem;--radius-md:.375rem;--radius-lg:.5rem;--radius-xl:.75rem;--radius-2xl:1rem;--radius-3xl:1.5rem;--radius-4xl:2rem;--shadow-2xs:0 1px #0000000d;--shadow-xs:0 1px 2px 0 #0000000d;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-md:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--shadow-xl:0 20px 25px -5px #0000001a,0 8px 10px -6px #0000001a;--shadow-2xl:0 25px 50px -12px #00000040;--inset-shadow-2xs:inset 0 1px #0000000d;--inset-shadow-xs:inset 0 1px 1px #0000000d;--inset-shadow-sm:inset 0 2px 4px #0000000d;--drop-shadow-xs:0 1px 1px #0000000d;--drop-shadow-sm:0 1px 2px #00000026;--drop-shadow-md:0 3px 3px #0000001f;--drop-shadow-lg:0 4px 4px #00000026;--drop-shadow-xl:0 9px 7px #0000001a;--drop-shadow-2xl:0 25px 25px #00000026;--ease-in:cubic-bezier(.4,0,1,1);--ease-out:cubic-bezier(0,0,.2,1);--ease-in-out:cubic-bezier(.4,0,.2,1);--animate-spin:spin 1s linear infinite;--animate-ping:ping 1s cubic-bezier(0,0,.2,1)infinite;--animate-pulse:pulse 2s cubic-bezier(.4,0,.6,1)infinite;--animate-bounce:bounce 1s infinite;--blur-xs:4px;--blur-sm:8px;--blur-md:12px;--blur-lg:16px;--blur-xl:24px;--blur-2xl:40px;--blur-3xl:64px;--perspective-dramatic:100px;--perspective-near:300px;--perspective-normal:500px;--perspective-midrange:800px;--perspective-distant:1200px;--aspect-video:16/9;--default-transition-duration:.15s;--default-transition-timing-function:cubic-bezier(.4,0,.2,1);--default-font-family:var(--font-sans);--default-font-feature-settings:var(--font-sans--font-feature-settings);--default-font-variation-settings:var(--font-sans--font-variation-settings);--default-mono-font-family:var(--font-mono);--default-mono-font-feature-settings:var(--font-mono--font-feature-settings);--default-mono-font-variation-settings:var(--font-mono--font-variation-settings)}}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}::file-selector-button{box-sizing:border-box;border:0 solid;margin:0;padding:0}html,:host{-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji");font-feature-settings:var(--default-font-feature-settings,normal);font-variation-settings:var(--default-font-variation-settings,normal);-webkit-tap-highlight-color:transparent}body{line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;-webkit-text-decoration:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:var(--default-mono-font-family,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace);font-feature-settings:var(--default-mono-font-feature-settings,normal);font-variation-settings:var(--default-mono-font-variation-settings,normal);font-size:1em}small{font-size:80%}sub,sup{vertical-align:baseline;font-size:75%;line-height:0;position:relative}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}:-moz-focusring{outline:auto}progress{vertical-align:baseline}summary{display:list-item}ol,ul,menu{list-style:none}img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:block}img,video{max-width:100%;height:auto}button,input,select,optgroup,textarea{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}::file-selector-button{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}:where(select:is([multiple],[size])) optgroup{font-weight:bolder}:where(select:is([multiple],[size])) optgroup option{padding-inline-start:20px}::file-selector-button{margin-inline-end:4px}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}textarea{resize:vertical}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-date-and-time-value{min-height:1lh;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-datetime-edit{padding-block:0}::-webkit-datetime-edit-year-field{padding-block:0}::-webkit-datetime-edit-month-field{padding-block:0}::-webkit-datetime-edit-day-field{padding-block:0}::-webkit-datetime-edit-hour-field{padding-block:0}::-webkit-datetime-edit-minute-field{padding-block:0}::-webkit-datetime-edit-second-field{padding-block:0}::-webkit-datetime-edit-millisecond-field{padding-block:0}::-webkit-datetime-edit-meridiem-field{padding-block:0}:-moz-ui-invalid{box-shadow:none}button,input:where([type=button],[type=reset],[type=submit]){-webkit-appearance:button;-moz-appearance:button;appearance:button}::file-selector-button{-webkit-appearance:button;-moz-appearance:button;appearance:button}::-webkit-inner-spin-button{height:auto}::-webkit-outer-spin-button{height:auto}[hidden]:where(:not([hidden=until-found])){display:none!important}}@layer components;@layer utilities{.absolute{position:absolute}.relative{position:relative}.static{position:static}.inset-0{inset:calc(var(--spacing)*0)}.-mt-\[4\.9rem\]{margin-top:-4.9rem}.-mb-px{margin-bottom:-1px}.mb-1{margin-bottom:calc(var(--spacing)*1)}.mb-2{margin-bottom:calc(var(--spacing)*2)}.mb-4{margin-bottom:calc(var(--spacing)*4)}.mb-6{margin-bottom:calc(var(--spacing)*6)}.-ml-8{margin-left:calc(var(--spacing)*-8)}.flex{display:flex}.hidden{display:none}.inline-block{display:inline-block}.inline-flex{display:inline-flex}.table{display:table}.aspect-\[335\/376\]{aspect-ratio:335/376}.h-1{height:calc(var(--spacing)*1)}.h-1\.5{height:calc(var(--spacing)*1.5)}.h-2{height:calc(var(--spacing)*2)}.h-2\.5{height:calc(var(--spacing)*2.5)}.h-3{height:calc(var(--spacing)*3)}.h-3\.5{height:calc(var(--spacing)*3.5)}.h-14{height:calc(var(--spacing)*14)}.h-14\.5{height:calc(var(--spacing)*14.5)}.min-h-screen{min-height:100vh}.w-1{width:calc(var(--spacing)*1)}.w-1\.5{width:calc(var(--spacing)*1.5)}.w-2{width:calc(var(--spacing)*2)}.w-2\.5{width:calc(var(--spacing)*2.5)}.w-3{width:calc(var(--spacing)*3)}.w-3\.5{width:calc(var(--spacing)*3.5)}.w-\[448px\]{width:448px}.w-full{width:100%}.max-w-\[335px\]{max-width:335px}.max-w-none{max-width:none}.flex-1{flex:1}.shrink-0{flex-shrink:0}.translate-y-0{--tw-translate-y:calc(var(--spacing)*0);translate:var(--tw-translate-x)var(--tw-translate-y)}.transform{transform:var(--tw-rotate-x)var(--tw-rotate-y)var(--tw-rotate-z)var(--tw-skew-x)var(--tw-skew-y)}.flex-col{flex-direction:column}.flex-col-reverse{flex-direction:column-reverse}.items-center{align-items:center}.justify-center{justify-content:center}.justify-end{justify-content:flex-end}.gap-3{gap:calc(var(--spacing)*3)}.gap-4{gap:calc(var(--spacing)*4)}:where(.space-x-1>:not(:last-child)){--tw-space-x-reverse:0;margin-inline-start:calc(calc(var(--spacing)*1)*var(--tw-space-x-reverse));margin-inline-end:calc(calc(var(--spacing)*1)*calc(1 - var(--tw-space-x-reverse)))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:3.40282e38px}.rounded-sm{border-radius:var(--radius-sm)}.rounded-t-lg{border-top-left-radius:var(--radius-lg);border-top-right-radius:var(--radius-lg)}.rounded-br-lg{border-bottom-right-radius:var(--radius-lg)}.rounded-bl-lg{border-bottom-left-radius:var(--radius-lg)}.border{border-style:var(--tw-border-style);border-width:1px}.border-\[\#19140035\]{border-color:#19140035}.border-\[\#e3e3e0\]{border-color:#e3e3e0}.border-black{border-color:var(--color-black)}.border-transparent{border-color:#0000}.bg-\[\#1b1b18\]{background-color:#1b1b18}.bg-\[\#FDFDFC\]{background-color:#fdfdfc}.bg-\[\#dbdbd7\]{background-color:#dbdbd7}.bg-\[\#fff2f2\]{background-color:#fff2f2}.bg-white{background-color:var(--color-white)}.p-6{padding:calc(var(--spacing)*6)}.px-5{padding-inline:calc(var(--spacing)*5)}.py-1{padding-block:calc(var(--spacing)*1)}.py-1\.5{padding-block:calc(var(--spacing)*1.5)}.py-2{padding-block:calc(var(--spacing)*2)}.pb-12{padding-bottom:calc(var(--spacing)*12)}.text-sm{font-size:var(--text-sm);line-height:var(--tw-leading,var(--text-sm--line-height))}.text-\[13px\]{font-size:13px}.leading-\[20px\]{--tw-leading:20px;line-height:20px}.leading-normal{--tw-leading:var(--leading-normal);line-height:var(--leading-normal)}.font-medium{--tw-font-weight:var(--font-weight-medium);font-weight:var(--font-weight-medium)}.text-\[\#1b1b18\]{color:#1b1b18}.text-\[\#706f6c\]{color:#706f6c}.text-\[\#F53003\],.text-\[\#f53003\]{color:#f53003}.text-white{color:var(--color-white)}.underline{text-decoration-line:underline}.underline-offset-4{text-underline-offset:4px}.opacity-100{opacity:1}.shadow-\[0px_0px_1px_0px_rgba\(0\,0\,0\,0\.03\)\,0px_1px_2px_0px_rgba\(0\,0\,0\,0\.06\)\]{--tw-shadow:0px 0px 1px 0px var(--tw-shadow-color,#00000008),0px 1px 2px 0px var(--tw-shadow-color,#0000000f);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.shadow-\[inset_0px_0px_0px_1px_rgba\(26\,26\,0\,0\.16\)\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#1a1a0029);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.\!filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)!important}.filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)}.transition-all{transition-property:all;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.transition-opacity{transition-property:opacity;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.delay-300{transition-delay:.3s}.duration-750{--tw-duration:.75s;transition-duration:.75s}.not-has-\[nav\]\:hidden:not(:has(:is(nav))){display:none}.before\:absolute:before{content:var(--tw-content);position:absolute}.before\:top-0:before{content:var(--tw-content);top:calc(var(--spacing)*0)}.before\:top-1\/2:before{content:var(--tw-content);top:50%}.before\:bottom-0:before{content:var(--tw-content);bottom:calc(var(--spacing)*0)}.before\:bottom-1\/2:before{content:var(--tw-content);bottom:50%}.before\:left-\[0\.4rem\]:before{content:var(--tw-content);left:.4rem}.before\:border-l:before{content:var(--tw-content);border-left-style:var(--tw-border-style);border-left-width:1px}.before\:border-\[\#e3e3e0\]:before{content:var(--tw-content);border-color:#e3e3e0}@media (hover:hover){.hover\:border-\[\#1915014a\]:hover{border-color:#1915014a}.hover\:border-\[\#19140035\]:hover{border-color:#19140035}.hover\:border-black:hover{border-color:var(--color-black)}.hover\:bg-black:hover{background-color:var(--color-black)}}@media (width>=64rem){.lg\:-mt-\[6\.6rem\]{margin-top:-6.6rem}.lg\:mb-0{margin-bottom:calc(var(--spacing)*0)}.lg\:mb-6{margin-bottom:calc(var(--spacing)*6)}.lg\:-ml-px{margin-left:-1px}.lg\:ml-0{margin-left:calc(var(--spacing)*0)}.lg\:block{display:block}.lg\:aspect-auto{aspect-ratio:auto}.lg\:w-\[438px\]{width:438px}.lg\:max-w-4xl{max-width:var(--container-4xl)}.lg\:grow{flex-grow:1}.lg\:flex-row{flex-direction:row}.lg\:justify-center{justify-content:center}.lg\:rounded-t-none{border-top-left-radius:0;border-top-right-radius:0}.lg\:rounded-tl-lg{border-top-left-radius:var(--radius-lg)}.lg\:rounded-r-lg{border-top-right-radius:var(--radius-lg);border-bottom-right-radius:var(--radius-lg)}.lg\:rounded-br-none{border-bottom-right-radius:0}.lg\:p-8{padding:calc(var(--spacing)*8)}.lg\:p-20{padding:calc(var(--spacing)*20)}}@media (prefers-color-scheme:dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:border-\[\#3E3E3A\]{border-color:#3e3e3a}.dark\:border-\[\#eeeeec\]{border-color:#eeeeec}.dark\:bg-\[\#0a0a0a\]{background-color:#0a0a0a}.dark\:bg-\[\#1D0002\]{background-color:#1d0002}.dark\:bg-\[\#3E3E3A\]{background-color:#3e3e3a}.dark\:bg-\[\#161615\]{background-color:#161615}.dark\:bg-\[\#eeeeec\]{background-color:#eeeeec}.dark\:text-\[\#1C1C1A\]{color:#1c1c1a}.dark\:text-\[\#A1A09A\]{color:#a1a09a}.dark\:text-\[\#EDEDEC\]{color:#ededec}.dark\:text-\[\#F61500\]{color:#f61500}.dark\:text-\[\#FF4433\]{color:#f43}.dark\:shadow-\[inset_0px_0px_0px_1px_\#fffaed2d\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#fffaed2d);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.dark\:before\:border-\[\#3E3E3A\]:before{content:var(--tw-content);border-color:#3e3e3a}@media (hover:hover){.dark\:hover\:border-\[\#3E3E3A\]:hover{border-color:#3e3e3a}.dark\:hover\:border-\[\#62605b\]:hover{border-color:#62605b}.dark\:hover\:border-white:hover{border-color:var(--color-white)}.dark\:hover\:bg-white:hover{background-color:var(--color-white)}}}@starting-style{.starting\:translate-y-4{--tw-translate-y:calc(var(--spacing)*4);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:translate-y-6{--tw-translate-y:calc(var(--spacing)*6);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:opacity-0{opacity:0}}}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,to{opacity:0;transform:scale(2)}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,to{animation-timing-function:cubic-bezier(.8,0,1,1);transform:translateY(-25%)}50%{animation-timing-function:cubic-bezier(0,0,.2,1);transform:none}}@property --tw-translate-x{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-y{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-z{syntax:"*";inherits:false;initial-value:0}@property --tw-rotate-x{syntax:"*";inherits:false;initial-value:rotateX(0)}@property --tw-rotate-y{syntax:"*";inherits:false;initial-value:rotateY(0)}@property --tw-rotate-z{syntax:"*";inherits:false;initial-value:rotateZ(0)}@property --tw-skew-x{syntax:"*";inherits:false;initial-value:skewX(0)}@property --tw-skew-y{syntax:"*";inherits:false;initial-value:skewY(0)}@property --tw-space-x-reverse{syntax:"*";inherits:false;initial-value:0}@property --tw-border-style{syntax:"*";inherits:false;initial-value:solid}@property --tw-leading{syntax:"*";inherits:false}@property --tw-font-weight{syntax:"*";inherits:false}@property --tw-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-shadow-color{syntax:"*";inherits:false}@property --tw-inset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-shadow-color{syntax:"*";inherits:false}@property --tw-ring-color{syntax:"*";inherits:false}@property --tw-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-ring-color{syntax:"*";inherits:false}@property --tw-inset-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-ring-inset{syntax:"*";inherits:false}@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}@property --tw-ring-offset-color{syntax:"*";inherits:false;initial-value:#fff}@property --tw-ring-offset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-blur{syntax:"*";inherits:false}@property --tw-brightness{syntax:"*";inherits:false}@property --tw-contrast{syntax:"*";inherits:false}@property --tw-grayscale{syntax:"*";inherits:false}@property --tw-hue-rotate{syntax:"*";inherits:false}@property --tw-invert{syntax:"*";inherits:false}@property --tw-opacity{syntax:"*";inherits:false}@property --tw-saturate{syntax:"*";inherits:false}@property --tw-sepia{syntax:"*";inherits:false}@property --tw-drop-shadow{syntax:"*";inherits:false}@property --tw-duration{syntax:"*";inherits:false}@property --tw-content{syntax:"*";inherits:false;initial-value:""}
            </style>
        @endif
    </head>
    <body class="bg-white text-gray-900" style="font-family: 'Cairo', sans-serif;">
        <!-- Navigation Bar -->
        <nav class="fixed top-0 right-0 w-full bg-white shadow-lg z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <img src="{{ asset('images/bg.png') }}" alt="Logo" class="h-8 w-auto">
                    <div class="hidden md:flex space-x-4 space-x-reverse">
                        <a href="#about" class="px-2 text-gray-700 hover:text-[#dd208e] transition">عننا</a>
                        <a href="#services" class="px-2 text-gray-700 hover:text-[#dd208e] transition">الخدمات</a>
                        <a href="#features" class="px-2 text-gray-700 hover:text-[#dd208e] transition">المميزات</a>
                        <a href="#pricing" class="px-2 text-gray-700 hover:text-[#dd208e] transition">الأسعار</a>
                        <a href="{{ route('blogs.public.index') }}" class="px-2 text-gray-700 hover:text-[#dd208e] transition">المدونة</a>
                        
                        <a href="#contact" class="px-2 text-gray-700 hover:text-[#dd208e] transition">التواصل</a>
                    </div>
                    @if (Route::has('login'))
                        <div class="flex gap-3">
                            @auth
                                <a href="{{ route('admin.dashbord') }}" class="px-6 py-2 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-lg hover:shadow-lg transition">لوحة التحكم</a>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2 text-[#dd208e] border border-[#dd208e] rounded-lg hover:bg-red-50 transition">تسجيل الدخول</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="pt-24 sm:pt-32 pb-12 sm:pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] to-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-8 sm:mb-12">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 mb-4 sm:mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">
                             إدارة صالونك بكل سهولة
                        </span>
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto mb-6 sm:mb-8 leading-relaxed px-2">
                        منصة شاملة لإدارة صالونات ومراكز التجميل وعيادات التجميل - احجز المواعيد, أدر الموظفين, وزيد دخلك
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                        @auth
                            <a href="{{ route('admin.dashbord') }}" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-lg font-medium hover:shadow-xl hover:scale-105 transition transform text-sm sm:text-base">
                                اذهب إلى لوحة التحكم
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white rounded-lg font-medium hover:shadow-xl hover:scale-105 transition transform text-sm sm:text-base">
                                ابدأ المحاولة المجانية
                            </a>
                        @endauth
                        <a href="#about" class="px-6 sm:px-8 py-2.5 sm:py-3 border-2 border-[#dd208e] text-[#dd208e] rounded-lg font-medium hover:bg-red-50 transition text-sm sm:text-base">
                            تعرف على المزيد
                        </a>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mt-8 sm:mt-12 md:mt-16">
                    <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-md text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#dd208e] mb-1 sm:mb-2">+١٠٠٠</div>
                        <p class="text-xs sm:text-sm md:text-base text-gray-700 font-medium">صالون وعيادة</p>
                    </div>
                    <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-md text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#dd208e] mb-1 sm:mb-2">+٥٠ألف</div>
                        <p class="text-xs sm:text-sm md:text-base text-gray-700 font-medium">حجز شهري</p>
                    </div>
                    <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-md text-center">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#dd208e] mb-1 sm:mb-2">٤.٩</div>
                        <p class="text-xs sm:text-sm md:text-base text-gray-700 font-medium">تقييم المستخدمين</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- About Section -->
        <section id="about" class="py-12 sm:py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white via-[#faf8fc] to-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 md:mb-20">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">نبذة عننا</span>
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-2">نحن نبني الحل الأمثل لإدارة صالونات ومراكز التجميل - منصة متكاملة تجمع الكفاءة والابتكار</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-20">
                    <div>
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-2xl blur-2xl opacity-20"></div>
                            <div class="relative bg-white rounded-xl sm:rounded-2xl p-6 sm:p-8 md:p-12 shadow-2xl border border-gray-100">
                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-6">رؤيتنا</h3>
                                <p class="text-sm sm:text-base md:text-lg text-gray-700 leading-relaxed mb-4 sm:mb-6">
                                    تطبيقينا يوفر حلاً متكاملاً وحديثاً لإدارة صالونات ومراكز التجميل والعيادات الجمالية من جميع الأحجام. نحن نفهم التحديات الحقيقية التي تواجهك في إدارة المواعيد والعاملين والعملاء.
                                </p>
                                <p class="text-sm sm:text-base md:text-lg text-gray-700 leading-relaxed">
                                    مع تطبيقينا تتحكم بكل جوانب عملك من مكان واحد - من الحجوزات إلى الفواتير، مع توفير تجربة استثنائية لعملائك عبر تطبيق جوال سهل الاستخدام.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 sm:space-y-6">
                        <div class="group">
                            <div class="bg-white rounded-lg sm:rounded-xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#dd208e]">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="text-3xl sm:text-4xl flex-shrink-0">🎯</div>
                                    <div>
                                        <h4 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">الهدف</h4>
                                        <p class="text-sm sm:text-base text-gray-700">تبسيط إدارة صالونك وزيادة الأرباح بتقنيات متقدمة وسهلة الاستخدام</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="bg-white rounded-lg sm:rounded-xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#dd208e]">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="text-3xl sm:text-4xl flex-shrink-0">💡</div>
                                    <div>
                                        <h4 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">الابتكار</h4>
                                        <p class="text-sm sm:text-base text-gray-700">نقدم حلولاً مبتكرة تواكب احتياجات السوق والتقنيات الحديثة</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="bg-white rounded-lg sm:rounded-xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-[#dd208e]">
                                <div class="flex items-start gap-3 sm:gap-4">
                                    <div class="text-3xl sm:text-4xl flex-shrink-0">🤝</div>
                                    <div>
                                        <h4 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">الشراكة</h4>
                                        <p class="text-sm sm:text-base text-gray-700">نحن معك في كل خطوة - دعم كامل وتدريب مستمر لنجاحك</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 text-white">
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
                        <div class="text-center">
                            <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-1 sm:mb-2">+1000</div>
                            <p class="text-xs sm:text-sm md:text-lg text-red-100">صالون وعيادة</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-1 sm:mb-2">+50K</div>
                            <p class="text-xs sm:text-sm md:text-lg text-red-100">حجز شهري</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-1 sm:mb-2">4.9⭐</div>
                            <p class="text-xs sm:text-sm md:text-lg text-red-100">تقييم المستخدمين</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-1 sm:mb-2">24/7</div>
                            <p class="text-xs sm:text-sm md:text-lg text-red-100">دعم فني متاح</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- hpw can use our app video -->
        <section class="py-12 sm:py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 sm:mb-16 md:mb-20">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">
                <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">كيف يمكن لتطبيقينا أن يساعدك؟</span>
                </h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed px-2">شاهد الفيديو القصير التالي لتتعرف على كيفية استخدام تطبيقينا في إدارة صالونك بكفاءة وسهولة.</p>
            </div>      
            <div class="aspect-w-16 aspect-h-9">
                <video controls class="w-full h-full rounded-lg shadow-lg">
                <source src="{{ asset('videos/example.mp4') }}" type="video/mp4">
                
                متصفحك لا يدعم تشغيل الفيديو.
                </video>
            </div>
            </div>
        </section>        

        <!-- Services Section -->
        <section id="services" class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] to-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-3 md:mb-4">الخدمات الرئيسية</h2>
                    <p class="text-xs sm:text-base md:text-lg text-gray-600 px-2">كل ما تحتاجه لتشغيل صالونك بكفاءة</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">📅</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">إدارة المواعيد</h3>
                        <p class="text-xs sm:text-base text-gray-700">نظام متقدم للحجوزات عبر الإنترنت والجوال - دع عملاءك يحجزون بسهولة في أي وقت</p>
                    </div>

                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">👥</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">إدارة العملاء</h3>
                        <p class="text-xs sm:text-base text-gray-700">قاعدة بيانات كاملة لعملائك - تتبع سجلاتهم والخدمات التي استقبلوها والمدفوعات</p>
                    </div>

                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">💼</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">إدارة الموظفين</h3>
                        <p class="text-xs sm:text-base text-gray-700">أدر جدول عمل الموظفين والخدمات التي يقدمونها وأدائهم بسهولة</p>
                    </div>

                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">💰</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">المدفوعات</h3>
                        <p class="text-xs sm:text-base text-gray-700">تتبع المدفوعات لكل الحجوزات</p>
                    </div>

                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">📊</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">التقارير والإحصائيات</h3>
                        <p class="text-xs sm:text-base text-gray-700">تحليلات شاملة عن أداء صالونك والخدمات الأكثر طلباً والإيرادات</p>
                    </div>

                    <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 border border-[#f0b3d8] shadow-lg hover:shadow-xl transition">
                        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">📱</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">متوافقة مع الهواتف</h3>
                        <p class="text-xs sm:text-base text-gray-700"> متوافق مع جميع الأجهزة المحمولة و انواع الشاشات المتعددة</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-12 sm:py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 md:mb-20">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-3 md:mb-4">المميزات الرئيسية</h2>
                    <p class="text-xs sm:text-base md:text-lg text-gray-600 px-2">تقنيات متقدمة تسهل إدارتك اليومية</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 md:gap-12">
                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">حجوزات فورية</h3>
                            <p class="text-xs sm:text-base text-gray-700">عملاؤك يحجزون الخدمات مباشرة من التطبيق أو الموقع دون تدخلك</p>
                        </div>
                    </div>

                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2"> اضافة منتجات</h3>
                            <p class="text-xs sm:text-base text-gray-700">يمكنك إضافة منتجات جديدة بسهولة وإدارتها</p>
                        </div>
                    </div>

                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">إدارة الخدمات</h3>
                            <p class="text-xs sm:text-base text-gray-700">حدد أسعار الخدمات والمدة والموظفين المسؤولين عن كل خدمة</p>
                        </div>
                    </div>

                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">قياس اداء الموظفين</h3>
                            <p class="text-xs sm:text-base text-gray-700">تتبع أداء الموظفين وتحليل الإنتاجية لتحسين الخدمة</p>
                        </div>
                    </div>

                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">إدارة العملاء</h3>
                            <p class="text-xs sm:text-base text-gray-700">إدارة بيانات العملاء وتتبع حجوزاتهم بسهولة</p>
                        </div>
                    </div>

                    <div class="flex gap-3 sm:gap-4">
                        <div class="text-3xl sm:text-4xl flex-shrink-0">✅</div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">دعم فني 24/7</h3>
                            <p class="text-xs sm:text-base text-gray-700">فريق دعم متاح دائماً للإجابة على أسئلتك والمساعدة في حل المشاكل</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-12 sm:py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-[#fde4f1] via-white to-[#fde4f1]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 md:mb-20">
                    <span class="inline-block px-3 sm:px-4 py-1.5 sm:py-2 bg-[#dd208e] bg-opacity-10 text-[#fff] rounded-full text-xs sm:text-sm font-bold mb-3 sm:mb-4">💰 خطط تسعير بسيطة وشفافة</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4 sm:mb-6">
                        <span class="bg-gradient-to-r from-[#dd208e] to-[#b01670] bg-clip-text text-transparent">خطة تسعير شاملة</span>
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed px-2">خطة واحدة شاملة بأسعار مناسبة تناسب الجميع - بدون رسوم مخفية أو تعقيدات</p>
                </div>

                <div class="max-w-5xl mx-auto mb-12 md:mb-20">
                    <!-- Main Pricing Card -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#dd208e] to-[#b01670] rounded-2xl sm:rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition duration-500"></div>
                        <div class="relative bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 shadow-2xl border-2 border-[#dd208e]">
                            <!-- Badge -->
                            <div class="absolute -top-4 sm:-top-6 right-4 sm:right-8">
                                <div class="bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full font-bold text-xs sm:text-sm shadow-lg">⭐ الأفضل والأوحد</div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mt-6 sm:mt-4">
                                <!-- Plan Info -->
                                <div class="lg:col-span-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 sm:mb-3">الخطط</h3>
                                        <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-4 sm:mb-8">الحل الكامل لصالونك</p>
                                        <p class="text-xs sm:text-sm md:text-base text-gray-700 mb-6 sm:mb-8">مناسبة للصالونات والعيادات من جميع الأحجام والنطاقات</p>
                                    </div>
                                </div>

                                <!-- Pricing Options -->
                                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div class="relative group/monthly">
                                        <div class="absolute inset-0 bg-gradient-to-br from-[#dd208e] to-[#b01670] rounded-xl sm:rounded-2xl opacity-0 group-hover/monthly:opacity-10 transition"></div>
                                        <div class="relative bg-gradient-to-br from-[#fde4f1] to-[#fff5f9] rounded-xl sm:rounded-2xl p-6 sm:p-8 border-2 border-transparent group-hover/monthly:border-[#dd208e] transition">
                                            <p class="text-gray-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2 sm:mb-3">🗓️ الدفع الشهري</p>
                                            <div class="mb-2">
                                                <span class="text-4xl sm:text-5xl md:text-6xl font-black text-[#dd208e]">$15</span>
                                            </div>
                                            <p class="text-gray-600 text-xs sm:text-sm mb-2 sm:mb-4">/الشهر</p>
                                            <p class="text-xs text-gray-500">$180 سنوياً</p>
                                        </div>
                                    </div>

                                    <div class="relative group/yearly">
                                        <div class="absolute inset-0 bg-gradient-to-br from-[#dd208e] to-[#b01670] rounded-xl sm:rounded-2xl opacity-10"></div>
                                        <div class="relative bg-gradient-to-br from-white to-[#fde4f1] rounded-xl sm:rounded-2xl p-6 sm:p-8 border-2 border-[#dd208e]">
                                            <div class="inline-block bg-[#dd208e] text-white px-2 sm:px-3 py-1 rounded-full text-xs font-bold mb-2">توفير 33%</div>
                                            <p class="text-gray-600 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2 sm:mb-3">🎁 الدفع السنوي</p>
                                            <div class="mb-2">
                                                <span class="text-4xl sm:text-5xl md:text-6xl font-black text-[#dd208e]">$120</span>
                                            </div>
                                            <p class="text-gray-600 text-xs sm:text-sm">/السنة</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features List -->
                            <div class="mt-8 sm:mt-12 pt-8 sm:pt-12 border-t-2 border-gray-100">
                                <h4 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 sm:mb-8">تشمل الخطة:</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">إدارة المواعيد</h5>
                                            <p class="text-xs sm:text-base text-gray-700">نظام حجز متقدم عبر الويب والجوال - 24/7</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">إدارة العملاء والموظفين</h5>
                                            <p class="text-xs sm:text-base text-gray-700">قاعدة بيانات كاملة بلا حدود</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1"> المدفوعات</h5>
                                            <p class="text-xs sm:text-base text-gray-700">متابعة جميع الحجوزات و مدوفعاتها</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">التقارير والإحصائيات</h5>
                                            <p class="text-xs sm:text-base text-gray-700">تحليلات شاملة و مفصلة</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">تصميم متجاوب</h5>
                                            <p class="text-xs sm:text-base text-gray-700">متكامل مع جميع انواع الشاشات</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">قياس اداء الموظفين</h5>
                                            <p class="text-xs sm:text-base text-gray-700">تتبع اداء الموظفين و تحليل الانتاجية لتحسين الخدمة</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">ادارة المنتجات</h5>
                                            <p class="text-xs sm:text-base text-gray-700">ادارة المنتجات و المخزون</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3 sm:gap-4 group/feature">
                                        <div class="flex-shrink-0 mt-0.5 sm:mt-1">
                                            <div class="flex items-center justify-center h-7 sm:h-8 w-7 sm:w-8 rounded-lg bg-gradient-to-br from-[#dd208e] to-[#b01670] text-white font-bold text-base sm:text-lg">✓</div>
                                        </div>
                                        <div>
                                            <h5 class="text-sm sm:text-lg font-bold text-gray-900 mb-0.5 sm:mb-1">الدعم الفني المتميز</h5>
                                            <p class="text-xs sm:text-base text-gray-700">دعم 24/7 من الفريق المتخصص</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="mt-8 sm:mt-12 flex flex-col sm:flex-row gap-3 sm:gap-4">
                                @auth
                                    <button class="flex-1 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-sm sm:text-lg rounded-lg sm:rounded-xl hover:shadow-2xl hover:scale-105 transition transform duration-300">
                                        اختر هذه الخطة الآن
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-sm sm:text-lg rounded-lg sm:rounded-xl hover:shadow-2xl hover:scale-105 transition transform duration-300 text-center">
                                        ابدأ التجربة المجانية
                                    </a>
                                @endauth
                                <a href="tel:+249110920958" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 border-2 border-[#dd208e] text-[#dd208e] font-bold text-sm sm:text-lg rounded-lg sm:rounded-xl hover:bg-red-50 transition duration-300 flex items-center justify-center">
                                    اتصل بنا للاستفسار
                                </a>
                            </div>

                            <!-- Footer Text -->
                            <div class="mt-6 sm:mt-8 text-center space-y-1 sm:space-y-2">
                                <p class="text-gray-600 font-medium text-xs sm:text-base">✨ بلا رسوم مخفية • بلا عقود طويلة • إلغاء في أي وقت</p>
                                <p class="text-gray-500 text-xs sm:text-sm">14 يوم تجربة مجانية - بدون الحاجة لبطاقة ائتمان</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison Section -->
                <div class="mt-12 md:mt-20 text-center">
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-6">لماذا تختارنا ؟</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 max-w-4xl mx-auto">
                        <div class="bg-white rounded-lg sm:rounded-xl p-6 shadow-lg border border-gray-100">
                            <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">⚡</div>
                            <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-1 sm:mb-2">سريع وسهل</h4>
                            <p class="text-xs sm:text-base text-gray-700">تطبيق سريع وسهل الاستخدام يمكنك البدء به مباشرة</p>
                        </div>
                        <div class="bg-white rounded-lg sm:rounded-xl p-6 shadow-lg border border-gray-100">
                            <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">🔒</div>
                            <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-1 sm:mb-2">آمن وموثوق</h4>
                            <p class="text-xs sm:text-base text-gray-700">معايير أمان عالية وحماية بيانات عملائك</p>
                        </div>
                        <div class="bg-white rounded-lg sm:rounded-xl p-6 shadow-lg border border-gray-100">
                            <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">📈</div>
                            <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-1 sm:mb-2">نمو الأرباح</h4>
                            <p class="text-xs sm:text-base text-gray-700">زيادة الحجوزات والدخل من خلال أدوات متقدمة</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-12 sm:py-16 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-[#fde4f1]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16 md:mb-20">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-3 sm:mb-4 md:mb-6">تواصل معنا</h2>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto px-2">فريقنا متاح لمساعدتك 24/7 للإجابة على جميع أسئلتك</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-12 md:mb-20">
                    <!-- Email Card -->
                    <div class="group">
                        <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="relative mb-6 sm:mb-8">
                                <div class="relative bg-gradient-to-br from-[#dd208e] to-[#b01670] w-14 sm:w-16 h-14 sm:h-16 rounded-lg sm:rounded-xl flex items-center justify-center">
                                    <span class="text-2xl sm:text-3xl">📧</span>
                                </div>
                            </div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">البريد الإلكتروني</h3>
                            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-5">نرد على البريد خلال ساعة واحدة</p>
                            <a href="mailto:support@dohaapp.com" class="inline-flex items-center gap-2 text-[#dd208e] hover:text-[#b01670] font-bold transition text-xs sm:text-base">
                                support@dohaapp.com
                                <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Card -->
                    <div class="group">
                        <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="relative mb-6 sm:mb-8">
                                <div class="relative bg-gradient-to-br from-[#dd208e] to-[#b01670] w-14 sm:w-16 h-14 sm:h-16 rounded-lg sm:rounded-xl flex items-center justify-center">
                                    <span class="text-2xl sm:text-3xl">💬</span>
                                </div>
                            </div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">الواتس آب</h3>
                            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-5">للدعم الفوري والاستفسارات السريعة</p>
                            <a href="https://wa.me/249110920958" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#dd208e] hover:text-[#b01670] font-bold transition text-xs sm:text-base">
                                00249-1109-20958
                            <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Address Card -->
                    <div class="group">
                        <div class="bg-white rounded-lg sm:rounded-2xl p-6 sm:p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <div class="relative mb-6 sm:mb-8">
                                <div class="relative bg-gradient-to-br from-[#dd208e] to-[#b01670] w-14 sm:w-16 h-14 sm:h-16 rounded-lg sm:rounded-xl flex items-center justify-center">
                                    <span class="text-2xl sm:text-3xl">📍</span>
                                </div>
                            </div>
                            <h3 class="text-lg sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-3">المقر الرئيسي</h3>
                            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-5">تفضل بزيارتنا في مسقط</p>
                            <div class="flex items-start gap-2 text-[#dd208e] hover:text-[#b01670] font-bold transition text-xs sm:text-base">
                                <span>العمارات - الخرطوم - السودان</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div id="contact-form" class="bg-white rounded-lg sm:rounded-3xl shadow-2xl overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Form -->
                         
                        <div class="p-6 sm:p-8 md:p-12">
                            <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">أرسل لنا رسالة</h3>
                            <p class="text-xs sm:text-base text-gray-600 mb-6 sm:mb-8">سنرد عليك في أسرع وقت ممكن</p>
                            
                            @if(session('success'))
                                <div class="mb-6 p-4 bg-green-100 border-2 border-green-400 rounded-lg">
                                    <p class="text-green-800 font-semibold text-sm sm:text-base">{{ session('success') }}</p>
                                </div>
                            @endif
                            
                            <form class="space-y-4 sm:space-y-6" action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div>
                                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">الاسم</label>
                                    <input value="{{ old('name') }}" required type="text" name="name" placeholder="أدخل اسمك" class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition text-xs sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">البريد الإلكتروني</label>
                                    <input value="{{ old('email') }}" required type="email" name="email" placeholder="أدخل بريدك الإلكتروني" class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition text-xs sm:text-base">
                                </div>

                                 <div>
                                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2"> الجوال</label>
                                    <input value="{{ old('phone') }}" required type="tel" name="phone" placeholder="أدخل رقم جوالك" class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition text-xs sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">الموضوع</label>
                                    <input value="{{ old('title') }}" required type="text" name="title" placeholder="موضوع الرسالة" class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition text-xs sm:text-base">
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1 sm:mb-2">الرسالة</label>
                                    <textarea required name="message" placeholder="اكتب رسالتك..." rows="5" class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg focus:border-[#dd208e] focus:outline-none transition resize-none text-xs sm:text-base">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="w-full px-6 py-3 sm:py-4 bg-gradient-to-r from-[#dd208e] to-[#b01670] text-white font-bold text-sm sm:text-base rounded-lg sm:rounded-lg hover:shadow-xl transition transform hover:scale-105">
                                    إرسال الرسالة
                                </button>
                            </form>
                        </div>
                       

                        <!-- Info Side -->
                        <div class="bg-gradient-to-br from-[#dd208e] to-[#b01670] p-6 sm:p-8 md:p-12 text-white flex flex-col justify-center">
                            <h3 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">معلومات التواصل</h3>
                            
                            <div class="space-y-6 sm:space-y-8">
                                <div class="flex gap-3 sm:gap-4">
                                    <div class="text-2xl sm:text-3xl flex-shrink-0">⏰</div>
                                    <div>
                                        <h4 class="font-bold text-base sm:text-lg mb-1 sm:mb-2">ساعات العمل</h4>
                                        <p class="text-red-100 text-xs sm:text-sm">الاحد - الخميس: 9 صباحًا - 6 مساءً</p>
                                        <p class="text-red-100 text-xs sm:text-sm">الجمعة: مغلق</p>
                                        <p class="text-red-100 text-xs sm:text-sm">الدعم الفني: 24/7</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 sm:gap-4">
                                    <div class="text-2xl sm:text-3xl flex-shrink-0">🌐</div>
                                    <div>
                                        <h4 class="font-bold text-base sm:text-lg mb-1 sm:mb-2">تابعنا</h4>
                                        <div class="flex gap-2 sm:gap-3 text-xs sm:text-sm text-white">
                                            <a href="#" class="hover:opacity-80 transition" aria-label="Twitter">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M23 4.56a9.83 9.83 0 01-2.828.775A4.93 4.93 0 0022.337 3.2a9.86 9.86 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482A13.97 13.97 0 011.671 3.149a4.92 4.92 0 001.523 6.574A4.9 4.9 0 01.96 9.1v.062a4.92 4.92 0 003.95 4.827 4.9 4.9 0 01-2.212.084 4.93 4.93 0 004.6 3.417A9.87 9.87 0 010 19.54a13.94 13.94 0 007.548 2.212c9.058 0 14.01-7.513 14.01-14.02 0-.213-.005-.425-.014-.636A10.01 10.01 0 0023 4.56z"/>
                                                </svg>
                                            </a>

                                            <a href="#" class="hover:opacity-80 transition" aria-label="Instagram">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm5 6.2A4.8 4.8 0 1016.8 13 4.8 4.8 0 0012 8.2zm6.4-2.6a1.12 1.12 0 11-1.12 1.12A1.12 1.12 0 0118.4 5.6zM12 15.3A3.3 3.3 0 1115.3 12 3.3 3.3 0 0112 15.3z"/>
                                                </svg>
                                            </a>

                                            <a href="#" class="hover:opacity-80 transition" aria-label="TikTok">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 3v10.55A4 4 0 1014 17V7h4V3h-6z"/>
                                                </svg>
                                            </a>

                                            <a href="#" class="hover:opacity-80 transition" aria-label="LinkedIn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M4.98 3.5A2.5 2.5 0 102.48 6a2.5 2.5 0 002.5-2.5zM3 8.98h4v12H3v-12zM9 8.98h3.84v1.64h.05c.54-1.02 1.86-2.08 3.83-2.08 4.1 0 4.86 2.7 4.86 6.21v7.23h-4v-6.4c0-1.53-.03-3.5-2.13-3.5-2.13 0-2.46 1.67-2.46 3.4v6.5H9v-12z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3 sm:gap-4">
                                    <div class="text-2xl sm:text-3xl flex-shrink-0">📞</div>
                                    <div>
                                        <h4 class="font-bold text-base sm:text-lg mb-1 sm:mb-2">رقم الهاتف</h4>
                                        <p class="text-red-100 text-xs sm:text-sm">00249-1109-20958</p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-12 sm:py-16 md:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-[#dd208e] to-[#b01670]">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">جاهز لتطوير صالونك؟</h2>
                <p class="text-sm sm:text-base md:text-lg lg:text-xl text-red-100 mb-6 sm:mb-8 px-2">ابدأ محاولتك المجانية اليوم - لا تحتاج بطاقة ائتمان</p>
                @auth
                    <a href="{{ route('admin.dashbord') }}" class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-white text-[#dd208e] font-bold text-sm sm:text-base md:text-lg rounded-lg sm:rounded-lg hover:shadow-xl hover:scale-105 transition transform">
                        اذهب إلى لوحة التحكم
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-6 sm:px-8 py-3 sm:py-4 bg-white text-[#dd208e] font-bold text-sm sm:text-base md:text-lg rounded-lg sm:rounded-lg hover:shadow-xl hover:scale-105 transition transform">
                        ابدأ التجربة المجانية
                    </a>
                @endauth
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white text-gray-900 py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-8">
                    <div class="space-y-3 sm:space-y-4">
                       
                        <img src="{{ asset('images/bg.png') }}" alt="doha logo" class="h-10 sm:h-12 mb-3 sm:mb-4">
                       
                        <p class="text-xs sm:text-sm">حل متكامل لإدارة صالونات ومراكز التجميل</p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">المنتج</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="#features" class="hover:text-gray-700 transition">المميزات</a></li>
                            <li><a href="#pricing" class="hover:text-gray-700 transition">الأسعار</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">الشركة</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li><a href="#about" class="hover:text-gray-700 transition">عننا</a></li>
                            <li><a href="{{ route('blogs.public.index') }}" class="hover:text-gray-700 transition">المدونة</a></li>
                            
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-3 sm:mb-4 text-base sm:text-lg">قانوني</h4>
                        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            
                            <li><a href="{{ route('policy') }}" class="hover:text-gray-700 transition">الشروط و الاحكام</a></li>
                            <li><a href="#contact" class="hover:text-gray-700 transition">التواصل</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-800 pt-6 sm:pt-8 text-center text-xs sm:text-sm">
                    <p>&copy; 2026 . جميع الحقوق محفوظة.</p>
                    <a href="https://www.instagram.com/mohamed_izeldeen/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 text-[#dd208e] hover:text-[#b01670] mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M7 2C4.23858 2 2 4.23858 2 7v10c0 2.7614 2.23858 5 5 5h10c2.7614 0 5-2.2386 5-5V7c0-2.76142-2.2386-5-5-5H7zm10 2c1.657 0 3 1.343 3 3v10c0 1.657-1.343 3-3 3H7c-1.657 0-3-1.343-3-3V7c0-1.657 1.343-3 3-3h10zM12 7.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zm0 2a2.25 2.25 0 110 4.5 2.25 2.25 0 010-4.5zM17.5 6.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        <span>تم التطوير بواسطة محمد عزالدين</span>
                    </a>
                </div>
            </div>
        </footer>

        <!-- Smooth Scroll -->
        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        </script>
    </body>
</html>
          