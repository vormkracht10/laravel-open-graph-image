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
        {!! file_get_contents(public_path('css/app.css')) !!}
        </style>
    </head>
    <body class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-900 w-[1200px] h-[630px] text-white p-12 border-emerald-400 border-b-[16px]">
            <h1 class="font-bold text-[90px] text-emerald-400 leading-none">{!! explode(' - ', $title)[0] !!}</h1>
            <h2 class="mt-6 text-[50px] font-bold text-gray-200 uppercase">Rocketeers</h2>
            <div class="inline-block px-6 py-3 mt-10 text-[30px] font-bold text-white rounded-lg bg-emerald-500">Read more here</div>
        </div>
    </body>
</html>