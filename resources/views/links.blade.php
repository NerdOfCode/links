<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Links</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Styles -->
        <style>
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            .arrow:hover {
                font-size: 18px;
            }
        </style>
    </head>
    <body class="container antialiased">
        <h1 class="text-center"> Links to Visit</h1>
        <div class="col">
            <p class="text-end">
                {{ $name }}
                <a href="/logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </p>
        </div>
        <hr />

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}<br/>
            </div>
        @endforeach

        @if ($name)
        <div class="row">
            <div class="col-4">
                <form action="/store-link" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6 offset-1">
                            <input type="text" name="name" placeholder="Paste link here" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 offset-1 pt-1">
                            <button class="btn btn-primary" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-4">
                <ul>
                    <div class="row">

                    <div class="container">
                        <i class="arrow fas fa-arrow-up" onclick="moveUp()"></i>
                        |
                        <i class="arrow fas fa-arrow-down" onclick="moveDown()"></i>
                        <button class="btn btn-primary" type="submit" onclick="openCurrentLink()">
                            Go!
                        </button>
                    </div>

                    <links id="numberOfLinks" data-links="{{ $links->count() }}" />
                    @foreach ($links as $link)
                        <li id="linkList">
                            <a href="{{ $link['name'] }}" title="Updated at: {{ $link['updated_at'] }}" target="_blank">
                                {{ $link['name'] }}
                            </a>
                        </li>
                    @endforeach
                    {{ $links->links() }}
                    </div>
                </ul>
            </div>
        </div>
        @else
            <form action="account-name" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Enter name" />
                <br />
                
                <div class="row">
                    <div class="col-2 pt-1">
                    <button class="btn btn-primary" type="submit"> Submit </button>
                    </div>
                </div>
            </form>
        @endif
        <script src="https://kit.fontawesome.com/91f65d0699.js" crossorigin="anonymous"></script>

        <script scoped>
        let currentLink = 0;

        function highlight(linkNode) {
            linkNode.style.backgroundColor = 'orange';
        }

        function removeHighlight(linkNode) {
            linkNode.style.backgroundColor = 'white';
        }

        function numberOfLinks() {
            return document.querySelector('#numberOfLinks').dataset.links;
        }

        function changeCurrentLink(type, val) {
            let maxLinks = numberOfLinks(); 

            if (type === 'ADD') {
                if (currentLink + val > maxLinks) {
                    return;
                } else {
                    currentLink += val;
                }
            }

            if (type === 'SUB') {
                if (currentLink - val < 0) {
                    return;
                } else {
                    currentLink -= val;
                }
            }
        }

        function moveDown() {
            if (currentLink + 1 > numberOfLinks()) {
                return;
            }

            let linkList = document.querySelectorAll('#linkList > a');

            if (currentLink > 0) {
                removeHighlight(linkList[currentLink - 1])
            }

            highlight(linkList[currentLink]);

            changeCurrentLink('ADD', 1);
        }

        function moveUp() {
            if (currentLink - 1 <= 0) {
                return;
            }

            let linkList = document.querySelectorAll('#linkList > a');

            if (currentLink <= 0) {
                return;
            }

            removeHighlight(linkList[currentLink - 1]);

            highlight(linkList[currentLink - 2]);

            changeCurrentLink('SUB', 1);
        }

        function getCurrentLink() {
            let linkList = document.querySelectorAll('#linkList > a');

            return linkList[(currentLink > 0) ? currentLink - 1 : currentLink].href;
        }

        function openCurrentLink() {
            window.open(getCurrentLink(), '_blank').focus();
        }
        </script>
    </body>
</html>
