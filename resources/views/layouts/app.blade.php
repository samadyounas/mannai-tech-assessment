<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    @livewireStyles
</head>
<body>
    <!-- @yield('content') -->
    @livewire('students')
    @livewireScripts
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        const inputElement = document.querySelector('input[id="avatar"]');
        // const pond = FilePond.create(inputElement);
        FilePond.create(inputElement, {
            server: {
                process: {
                    url: '/upload/imageTemp',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                revert: '/remove/imageTemp'
            },
            onremovefile: function (file) {
                Livewire.emit('removeFile', file);
            }
        });
        // document.addEventListener('livewire:load', function () {
        //     FilePond.setOptions({
        //         onremovefile: function (file) {
        //             console.log('in');
        //             Livewire.emit('removeFile', file.id);
        //         }
        //     });
        // });

    </script>
</body>
</html>
