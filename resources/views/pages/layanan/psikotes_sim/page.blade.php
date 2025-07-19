@php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
@endphp
@extends('layouts.app')
@section('content')
    @component('components.homepage.header') @endcomponent
    @component('components.homepage.navbar', [
        'ispeserta' => $ispeserta,
        'path'      => $path,
        'domain'    => $domain
    ]) @endcomponent

    <div class="p-4 bg-kontak">
        <div class="p-4 bg-lp-white-glasses">
            <h2 class="text-2xl text-center font-bold">Biro Psikotes SIM</h2>
            <h3 class="mt-6 text-center font-bold">Cek Data Psikotes SIM</h3>

            <div class="mt-6 justify-items-center">
                <iframe title="@hobibaca, 3 Kunci Kesuksesan" width="750" height="422" src="https://www.youtube.com/embed/v9WPF_JOrM4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen="" class="rounded-xl shadow-xl"></iframe>
            </div>

            <div class="mt-6">
                <ol class="list-decimal ml-6">
                    <li><a href="https://docs.google.com/spreadsheets/d/1-j4ZMj2DqNqzmO_a7t9IAiG40p4p8CuIlWzy7BaXD8c/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Outlet Lebak</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1pkKWl8MFU1isKzYCPzkW_iqFkb7ge1VKnARQogtd9dU/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Outlet Rajeg</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1hKjAHhImkfR-dBNs0ftpjrnscWyWM8untbZzPWI1f7o/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Outlet Cilegon</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1WOKncMIb6CNt3afIsao6MYeo0NSSEcJUaFvMDaiZtms/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Oulet Pandeglang</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1PIZYWEpCFISVxfCZcMIZklM5YhnP7stHCB8Z_iJS1OQ/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Outlet Kota Serang</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1lp8ALU1P96E6R8gNHhWxAF-cqbRDnlZqT5I3hxo-TOk/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Outlet Kabupaten Serang</a></li>
                    <li>Data Outlet Tangerang</li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1bGnfWurNNJEwdKHbDIOYCbe2yLmFnF3e9qm2R-oiyOw/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Rajeg</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/12E2jQ-oEeZ9vF5vLn50SNkxnyYg82dwvvujxnlpJ7Ng/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Lebak</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1nu9TB8MgtMpb5RBqf-UKdDSKCs8ozKQPNwGHtt2Up24/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Polda 1</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1QAdIr1YWs2tE_l8WzrknFyxgLpaATzdW8CO7MCHb6Tc/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Polda 2</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1vB3dITx0yliXPpLhGEgWTdSEBdftxpgu4k8_67ztY_c/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Polda 3</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1RC6HmEKucq4Bf3XIqMvCf4Eaz2G4oTBtrrboewMoSwg/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Polda 4</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/13eirHdEGzgIAM8K88foPpjP0F4-NjXDqlJBGuFWiX1E/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Cilegon</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/1maIs5qM-OI6EdwDO292q9j8_qt3Z1FF_y2uBHaPPV3M/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Pandeglang</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/13-EI5VBwQ8GLaec6EfuV4SxkTocA3z5FSb8EsikJhhI/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Kota Serang 1</a></li>
                    <li><a href="https://docs.google.com/spreadsheets/d/15dBbnqmX91UdccL128Mr6_u0tDrwnraUGl-mmI5FEvM/edit?usp=sharing" class="text-blue-800 hover:text-blue-500">Data Simling Kota Serang 2</a></li>
                    </ol>
            </div>
        </div>
    </div>

    @component('components.footer', ['hidden' => '', 'otherCSS' => '']) @endcomponent
@endsection
