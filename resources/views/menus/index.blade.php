<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollingstones Eateries Menu</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com/3.0.24"></script>
</head>

<body class="bg-black">
    <div
        style="background-image: url('{{ asset('/images/bellow-menu-bg.jpg') }}'); background-repeat: repeat-x; top: 0;">
        <div class="max-w-screen-lg w-full  py-6 mx-auto">
            <h3 class="font-bold text-center text-3xl my-3 text-[#FBD0A0] ">Welcome to Rollingstones
                Eatery MENU!
            </h3>
            <!-- Header Section -->
            <div class="flex justify-center items-center flex-col">
                <img src="{{ asset('/images/logo.jpg') }}" class="w-24" />
            </div>
        </div>
    </div>

    <div
        style="background-image: url('{{ asset('/images/bellow-menu-bg.jpg') }}'); background-repeat: repeat-x; top: 0;">
        <div class="max-w-screen-lg w-full px-5 py-6 mx-auto">

            <!-- Menu Grid Section -->
            <div class="min-h-screen p bg-black text-[#efbf04]">
                <h1 class="font-bold text-4xl ml-4 my-4">Click to Open (A~Z)</h1>
                <!-- Categories Grid -->
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($categories as $cat)
                        <a href="/menu-items/{{ $cat->id }}"
                            class="flex justify-start items-start p-4 rounded-md bg-[#FBD0A0] text-black hover:bg-[#e2b06f] transition-colors">
                            <div class="text-left font-semibold text-lg">
                                {{ $cat->name }}
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="w-full text-center mt-6">End!</div>
            </div>

        </div>
    </div>
</body>
