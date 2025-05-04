@extends('layouts.appMaster')

@section('title', 'Takaful')



@section('banner')

    

    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <video autoplay muted loop id="bg-video">
            <source src="{{ asset('images/freeGaza.mp4') }}" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <div class="caption">
                <h2>Welcome to Takaful</h2>
                <p>In response to the ongoing war and humanitarian crisis in Gaza, this platform has been built to connect those in need with those willing to help. Through transparent donation tracking, organized aid requests, and a secure case management system, we strive to bring critical support to families, children, and communities affected by the conflict. Every action taken here is a step toward relief, dignity, and hope for the people of Gaza.</p>
                <div class="main-button-red">
                    <div class="scroll-to-section"><a href="#contact">Contact Us</a></div>
                </div>
            </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

@endsection


@section('content')


    


    @include('sections.services')

    @include('sections.apply')

    @include('sections.hopeDelivered')
    
    @include('sections.contact')

@endsection