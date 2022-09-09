<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <style>
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 100;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-ultralight-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 200;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-thin-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 400;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-regular-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 500;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-medium-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 600;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-semibold-webfont.woff");
        }
        @font-face {
            font-family: ui-sans-serif;
            font-weight: 700;
            src: url("https://applesocial.s3.amazonaws.com/assets/styles/fonts/sanfrancisco/sanfranciscodisplay-bold-webfont.woff");
        }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="flex items-center justify-center min-h-screen">
        <div class="bg-[#1b2443] w-[1200px] h-[630px] text-white p-12 border-[#fe8185] border-[16px]">
            <h1 class="font-bold text-[90px] text-[#fe8185] leading-none">{!! explode(' - ', $title)[0] !!}</h1>
            @if(isset($subtitle))
                <h2 class="mt-6 text-[50px] font-bold text-white uppercase">{{ $subtitle }}</h2>
            @endif
            <div class="inline-block px-6 py-3 mt-10 text-[30px] font-bold text-white rounded-lg bg-[#fe8185]">Read more here</div>
        </div>
    </body>
</html>