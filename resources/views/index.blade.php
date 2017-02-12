@extends('layouts.app')

@section('content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="display-3">Welcome to AI Med</h1>
            <p class="lead text-muted">A place for using Data Science in Medicine.</p>
            <p>
                <a href="{{ route('register') }}" class="btn btn-primary">Create an Account</a>
                <a href="{{ url('/datasets') }}" class="btn btn-secondary">Browse Datasets</a>
            </p>
        </div>
    </section>
    <div class="container">
        <div class="row text-left">
            <div class="col-3">
                <h2>Datasets</h2>
                <p>Explore, Analyze and Share Public Medical Data</p>
                <p><a class="btn btn-secondary" href="/datasets" role="button">Browse »</a></p>
            </div>

            <div class="col-3">
                <h2>Code</h2>
                <p>Publish and find code through the community</p>
                <p><a class="btn btn-secondary" href="/code" role="button">Browse »</a></p>
            </div>
            <div class="col-3">
                <h2>News</h2>
                <p>Stay up-to-date on news and publications related to Medicine and Artificial Intelligence</p>
                <p><a class="btn btn-secondary" href="/news" role="button">Browse »</a></p>
            </div>

            <div class="col-3">
                <h2>Forum</h2>
                <p>Discuss about datasets, code and find new ways to help the community through data science</p>
                <p><a class="btn btn-secondary" href="/forum" role="button">Browse »</a></p>
            </div>
        </div>
    </div>
@endsection